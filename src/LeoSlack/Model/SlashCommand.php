<?php

namespace LeoSlack\Model;

class SlashCommand
{
    protected $teamId;
    protected $teamDomain;
    protected $channelId;
    protected $channelName;
    protected $userId;
    protected $userName;
    protected $command;
    protected $text;

    /**
     * SlashCommand constructor.
     * @param string $teamId
     * @param string $teamDomain
     * @param string $channelId
     * @param string $channelName
     * @param string $userId
     * @param string $userName
     * @param string $command
     * @param string $text
     */
    public function __construct($teamId, $teamDomain, $channelId, $channelName, $userId, $userName, $command, $text)
    {
        $this->teamId = $teamId;
        $this->teamDomain = $teamDomain;
        $this->channelId = $channelId;
        $this->channelName = $channelName;
        $this->userId = $userId;
        $this->userName = $userName;
        $this->command = $command;
        $this->text = $text;
    }

    /**
     * @return string
     */
    public function getTeamId()
    {
        return $this->teamId;
    }

    /**
     * @return string
     */
    public function getTeamDomain()
    {
        return $this->teamDomain;
    }

    /**
     * @return string
     */
    public function getChannelId()
    {
        return $this->channelId;
    }

    /**
     * @return string
     */
    public function getChannelName()
    {
        return $this->channelName;
    }

    /**
     * @return string
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * @return string
     */
    public function getUserName()
    {
        return $this->userName;
    }

    /**
     * @return string
     */
    public function getCommand()
    {
        return $this->command;
    }

    /**
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }
}
