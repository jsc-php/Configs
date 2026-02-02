<?php

namespace JscPhp\Configs\bin;

abstract class Parser
{
    protected $file_path;

    public function __construct(string $file_path)
    {
        $this->file_path = $file_path;
    }


    public abstract function parseFile(): array;

    public abstract function convertArray(array $data): string;

    public abstract function getValidExtensions(): array;


}