<?php

namespace JscPhp\Configs;

use Exception;
use JscPhp\Configs\bin\Ini;

class Config
{
    private       $file_path;
    private       $parser;
    private array $data;

    private array $options = [
        'autosave' => true,
    ];

    public function __construct(string $file_path, array $options = [])
    {
        $this->options = array_merge($this->options, $options);
        $extension = pathinfo($file_path, PATHINFO_EXTENSION) |>
                     strToLower(...);
        $this->parser = match ($extension) {
            'ini'   => new Ini($file_path),
            default => throw new Exception("Unsupported file extension: {$extension}")
        };
        $this->data = $this->parser->parseFile();
    }

    public function __destruct()
    {
        if ($this->options['autosave']) {
            $this->parser->writeFile($this->data);
        }
    }

    public function set(string $key, mixed $value, ?string $section = null): void
    {
        if ($section) {
            $this->data[$section][$key] = $value;
        } else {
            $this->data[$key] = $value;
        }
    }

    public function save()
    {
        $this->parser->writeFile($this->data);
    }

    public function delete(string $key, ?string $section = null): void
    {
        if ($section) {
            if (isset($this->data[$section][$key])) {
                unset($this->data[$section][$key]);
            }
        } else {
            if (!isset($this->data[$key])) {
                unset($this->data[$key]);
            }
        }
    }

    public function get(string $key, ?string $section = null): mixed
    {
        if ($section) {
            return $this->data[$section][$key] ?? null;
        }
        return $this->data[$key] ?? null;
    }

}