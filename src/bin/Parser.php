<?php

namespace JscPhp\Configs\bin;

abstract class Parser
{
    protected $file_path;

    public function __construct(string $file_path)
    {
        if (!is_readable($file_path)) {
            throw new \Exception("File not readable");
        }
        $this->file_path = $file_path;
    }


    public abstract function parseFile(): array;

    public abstract function writeFile(array $data): void;

}