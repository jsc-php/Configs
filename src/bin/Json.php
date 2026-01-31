<?php

namespace JscPhp\Configs\bin;

class Json extends Parser
{

    public function parseFile(): array
    {
        $json = file_get_contents($this->file_path);
        return json_decode($json, true);
    }

    public function convertArray(array $data): string
    {
        return json_encode($data, JSON_PRETTY_PRINT);
    }
}