<?php
namespace LeoSlack;

use LeoSlack\Exception\InvalidTokenRequestException;
use LeoSlack\Exception\UnknownImageException;
use LeoSlack\Model\SlashCommand;
use LeoSlack\Service\Config;
use LeoSlack\Service\ImageProcessor;
use LeoSlack\Service\SlackApi;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class Application
{
    /** @var SlackApi */
    protected $slackApi;
    /** @var ImageProcessor */
    protected $imageProcessor;
    /** @var Config */
    protected $appConfig;

    /**
     * Application constructor.
     * @param SlackApi $slackApi
     * @param ImageProcessor $imageProcessor
     * @param Config $appConfig
     */
    public function __construct(SlackApi $slackApi, ImageProcessor $imageProcessor, Config $appConfig)
    {
        $this->slackApi = $slackApi;
        $this->imageProcessor = $imageProcessor;
        $this->appConfig = $appConfig;
    }

    /**
     * @param array $config
     * @return Application
     */
    public static function create(array $config)
    {
        $config = new Config($config);

        return new Application(
            new SlackApi($config->getNamespace('slack')),
            new ImageProcessor($config->getNamespace('image')),
            $config->getNamespace('app')
        );
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function run(Request $request)
    {
        if ($request->getMethod() === Request::METHOD_GET) {
            return Response::create($this->imageProcessor->getCodeReferenceHtml(500));
        }

        try {
            $command = $this->slackApi->parseSlashCommand($request);
            if ($command->getCommand() === $this->appConfig->getKey('stickerCommand')) {
                $this->processStickerCommand($command);
            } else {
                return Response::create('Unknown command', 400);
            }
        } catch (UnknownImageException $requestException) {
            return Response::create(
                sprintf(
                    '%s. Please refer to <%s|help page> to see all available Leo stickers',
                    $requestException->getMessage(),
                    $this->appConfig->getKey('helpUrl')
                ),
                404
            );
        } catch (InvalidTokenRequestException $requestException) {
            return Response::create($requestException->getMessage(), 400);
        } catch (\Exception $e) {
            return Response::create(sprintf('Error %s with message %s', get_class($e), $e->getMessage()), 500);
        }

        return Response::create();
    }

    /**
     * @param SlashCommand $command
     * @throws UnknownImageException
     */
    protected function processStickerCommand(SlashCommand $command)
    {
        $arguments = explode(' ', $command->getText());
        $code = $arguments[0];
        $size = null;

        if (count($arguments) > 1) {
            $size = (int)($arguments[1]);
        }

        if ($size < 100) {
            $size = null;
        }

        $imageUrl = $this->imageProcessor->getUrlForImageCode($code, $size);
        $this->slackApi->sendAttachedImage($command, $imageUrl);
    }
}
