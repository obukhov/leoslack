<?php
namespace LeoSlack\Service;

class ImageProcessor
{
    /** @var  string */
    protected $basePath;
    /** @var  string */
    protected $baseUrl;

    /**
     * ImageProcessor constructor.
     * @param Config $config
     */
    public function __construct(Config $config)
    {
        $this->baseUrl = $config->getKey('baseUrl');
        $this->baseUrl = $config->getKey('basePath');
        $this->defautlSize = $config->getKey('size');
        $this->imageMap = $config->getKey('map');
    }

    /**
     * @param string $code
     * @param int $size vertical size of image
     *
     * @return string Url of image for specified
     */
    public function getUrlForImageCode($code, $size)
    {

        return $this->baseUrl;
    }

}
