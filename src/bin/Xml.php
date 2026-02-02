<?php

namespace JscPhp\Configs\bin;

use SimpleXMLElement;

class Xml extends Parser
{

    public function parseFile(): array
    {
        $contents = file_get_contents($this->file_path);
        $xml = simplexml_load_string($contents);
        $json = json_encode($xml);
        return json_decode($json, true);
    }

    public function convertArray(array $data): string
    {
        $xml = new SimpleXMLElement('<?xml version="1.0"?><config></config>');
        $this->arrayToXml($data, $xml);
        return $xml->asXML();
    }

    private function arrayToXml(array $data, SimpleXMLElement &$xml): void
    {
        foreach ($data as $key => $value) {
            if (is_array($value)) {
                $subnode = $xml->addChild($key);
                $this->arrayToXml($value, $subnode);
            } else {
                $xml->addChild("$key", htmlspecialchars("$value"));
            }
        }
    }


    public function getValidExtensions(): array
    {
        return ['xml'];
    }
}