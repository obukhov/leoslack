<?php

namespace LeoSlack\Service;

use Frlnc\Slack\Core\Commander;
use Frlnc\Slack\Http\CurlInteractor;
use Frlnc\Slack\Http\SlackResponseFactory;
use LeoSlack\Exception\ApiException;
use LeoSlack\Exception\ConfigException;
use LeoSlack\Exception\InvalidTokenRequestException;
use LeoSlack\Model\SlashCommand;
use Maknz\Slack\Client;
use Symfony\Component\HttpFoundation\Request;

class SlackApi
{
    /** @var  Client */
    protected $hookClient;
    /** @var  Config */
    protected $config;

    /**
     * SlackApi constructor.
     * @param Config $config
     */
    public function __construct(Config $config)
    {
        $this->hookClient = new Client($config->getKey('endpoint'));
        $this->token = $config->getKey('token');

        $webApiInteractor = (new CurlInteractor());
        $webApiInteractor->setResponseFactory(new SlackResponseFactory());
        $this->webApiClient = new Commander($config->getKey('webApiToken'), $webApiInteractor);
    }

    /**
     * @param Request $request
     * @return SlashCommand
     * @throws InvalidTokenRequestException
     * @throws ConfigException
     */
    public function parseSlashCommand(Request $request)
    {
        if ($request->getMethod() !== Request::METHOD_POST || $request->get('token') !== $this->token) {
            throw new InvalidTokenRequestException('Wrong request token');
        }

        return new SlashCommand(
            $request->get('team_id'),
            $request->get('team_domain'),
            $request->get('channel_id'),
            $request->get('channel_name'),
            $request->get('user_id'),
            $request->get('user_name'),
            $request->get('command'),
            $request->get('text')
        );
    }

    /**
     * @param SlashCommand $command
     * @param string $imageUrl
     * @throws ApiException
     */
    public function sendAttachedImage(SlashCommand $command, $imageUrl)
    {
        $result = $this->webApiClient->execute('users.info', ['user' => $command->getUserId()]);
        if (!$result->getStatusCode() === 200 || !isset($result->getBody()['ok']) || !$result->getBody()['ok']) {
            throw new ApiException('Error api call to users.info:' . $result->getBody()['error']);
        } else {
            $userProfile = $result->getBody()['user']['profile'];
        }

        $message = $this->hookClient->createMessage()
            ->from($userProfile['real_name'])
            ->to($command->getChannelId())
            ->setIcon($userProfile['image_72'])
            ->setText('/leo ' . $command->getText())
            ->attach(['image_url' => $imageUrl]);

        $this->hookClient->sendMessage($message);
    }
}
