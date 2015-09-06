<?php

namespace LeoSlack\Service;

class UsageStats
{
    /** @var string */
    protected $basePath;

    /**
     * UsageStats constructor.
     * @param Config $config
     * @throws \LeoSlack\Exception\ConfigException
     */
    public function __construct(Config $config)
    {
        $this->basePath = $config->getKey('basePath');
    }

    /**
     * @param string $code
     * @param \DateTime $time
     */
    public function saveUsageEvent($code, \DateTime $time)
    {
        file_put_contents($this->basePath . '/' . $code, $time->format('c') . PHP_EOL, FILE_APPEND);
    }
}
