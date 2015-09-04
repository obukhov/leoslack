<?php

namespace LeoSlack\Service;

use Maknz\Slack\Client;

class SlackApi
{
    /** @var  Client */
    protected $client;
    /** @var  Config */
    protected $config;

    /**
     * SlackApi constructor.
     * @param Client $client
     * @param Config $config
     */
    public function __construct(Client $client, Config $config)
    {
        $this->client = $client;
        $this->config = $config;
    }
}
