<?php

namespace JscPhp\Configs\bin;

class Yaml extends Parser
{

    public function parseFile(): array
    {
        $contents = file_get_contents($this->file_path);
        return yaml_parse($contents);
    }


    public function convertArray(array $data): string
    {
        return yaml_emit($data);
    }
}