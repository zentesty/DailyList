<?php
require_once "yaml/sfYaml.php";

class YamlParser
{
    public function load($filePath) {
        try {
            return sfYaml::load($filePath);
        }
        catch (Exception $e) {
            throw new YamlParserException(
                $e->getMessage(), $e->getCode(), $e);
        }
    }

    public function dump($array) {
        try {
            return sfYaml::dump($array);
        }
        catch (Exception $e) {
            throw new YamlParserException(
                $e->getMessage(), $e->getCode(), $e);
        }
    }
}

class YamlParserException extends Exception
{
    public function __construct($message = "", $code = 0, $previous = NULL) {
        if (version_compare(PHP_VERSION, "5.3.0") < 0) {
            parent::__construct($message, $code);
        }
        else {
            parent::__construct($message, $code, $previous);
        }
    }
}