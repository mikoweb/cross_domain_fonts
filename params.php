<?php

class Params
{
    /**
     * Nazwa folderu z czcionkami
     */
    const FOLDER_FONTS = "fonts";

    /**
     * @var string
     */
    private $rootDir = "";

    /**
     * @var string
     */
    private $fontsDir = "";

    /**
     * @param string $rootDir
     */
    public function __construct($rootDir)
    {
        $this->rootDir = (string)$rootDir;
        $this->fontsDir = $this->getRootDir() . "/" . self::FOLDER_FONTS;
    }

    /**
     * @return string
     */
    public function getRootDir()
    {
        return $this->rootDir;
    }

    /**
     * @return string
     */
    public function getFontsDir()
    {
        return $this->fontsDir;
    }
}
