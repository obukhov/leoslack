<?php

namespace LeoSlack\Service;

use LeoSlack\Exception\ConfigException;

class Config
{
    /** @var  array */
    protected $config;

    /**
     * Config constructor.
     * @param array $config
     */
    public function __construct(array $config)
    {
        $this->config = $config;
    }

    public function getNamespace($namespace)
    {
        return new Config($this->getKey($namespace));
    }

    public function getKey($keyName)
    {
        if (!isset($this->config[$keyName])) {
            throw new ConfigException(sprintf('Key %s not found', $keyName));
        }

        return $this->config[$keyName];
    }
}
