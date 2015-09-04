<?php
namespace LeoSlack;

use LeoSlack\Service\Config;
use LeoSlack\Service\ImageProcessor;
use LeoSlack\Service\SlackApi;
use Maknz\Slack\Client;
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
        if ($request->getMethod() !== Request::METHOD_POST && $request->get('command') !== '/leo')



        return Response::create('Hi there!');
    }
}
