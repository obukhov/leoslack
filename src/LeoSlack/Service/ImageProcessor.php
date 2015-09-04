<?php
namespace LeoSlack\Service;

use Imagine\Imagick\Imagine;
use LeoSlack\Exception\UnknownImageException;

class ImageProcessor
{
    /** @var  string */
    protected $basePath;
    /** @var  string */
    protected $baseUrl;
    /** @var  int */
    protected $defaultSize;
    /** @var  array */
    protected $imageMap;

    /**
     * ImageProcessor constructor.
     * @param Config $config
     */
    public function __construct(Config $config)
    {
        $this->baseUrl = $config->getKey('baseUrl');
        $this->basePath = $config->getKey('basePath');
        $this->defaultSize = (int)$config->getKey('size');
        $this->imageMap = $config->getKey('map');
        $this->imagine = new Imagine();
    }

    /**
     * @param string $code
     * @param int|null $size vertical size of image
     *
     * @return string Url of image for specified
     * @throws UnknownImageException
     */
    public function getUrlForImageCode($code, $size = null)
    {
        if (!isset($this->imageMap[$code])) {
            throw new UnknownImageException(sprintf('Unknown image code %s', $code));
        }

        if (!$size) {
            $size = $this->defaultSize;
        }

        $this->resizeImage($code, $size);

        return $this->baseUrl . '/' . $size . '/' . $this->imageMap[$code];
    }

    /**
     * @param null $size
     * @return string
     * @throws UnknownImageException
     */
    public function getCodeReferenceHtml($size = null)
    {
        $html = <<<EOT
<html>
    <head>
        <title>Leo slack stickers</title>
        <style style="text/css">li { display: inline-block; text-align: center }</style>
    </head>
    <body>
        <ul>
        %s
        </ul>
    </body>
</html>
EOT;
        $list = '';
        foreach (array_keys($this->imageMap) as $code) {
            $list .= sprintf(
                '<li><img height="%d" src="%s" /><br />%s</li>',
                (int)($size / 2),
                $this->getUrlForImageCode($code, $size),
                $code
            );
        }

        return sprintf($html, $list);
    }

    /**
     * @param string $code
     * @param int $size
     */
    protected function resizeImage($code, $size)
    {
        $targetImage = $this->basePath . '/' . $size . '/' . $this->imageMap[$code];

        if (!file_exists($targetImage)) {

            $this->makeDirectoryForSize($size);
            $sourceImage = $this->baseUrl . '/source/' . $this->imageMap[$code];
            $image = $this->imagine->open($sourceImage);
            $image
                ->resize($image->getSize()->heighten($size))
                ->save($targetImage, ['quality' => 100, 'resolution-x' => 300, 'resolution-y' => 300]);
        }
    }

    /**
     * @param int $size
     */
    protected function makeDirectoryForSize($size)
    {
        if (!file_exists($this->basePath . '/' . $size)) {
            mkdir($this->basePath . '/' . $size, 0775);
        }
    }
}
