<?php

namespace JscPhp\Configs;

use Exception;
use JscPhp\Configs\bin\Ini;
use JscPhp\Configs\bin\Json;
use JscPhp\Configs\bin\Php;
use JscPhp\Configs\bin\Xml;
use JscPhp\Configs\bin\Yaml;

class Config {
    private Yaml|Json|Ini|Xml|Php $parser;
    private array                 $data          = [];
    private array                 $original_data = [];
    private string                $file_path;
    private array                 $options       = [
            'autosave' => true,
    ];

    public function __construct(string $file_path, array $options = []) {
        $this->file_path = $file_path;
        $this->options = array_merge($this->options, $options);
        $extension = pathinfo($file_path, PATHINFO_EXTENSION) |>
                    strToLower(...);
        $this->parser = $this->getParser();
        if (file_exists($file_path)) {
            $this->data = $this->parser->parseFile();
        } else {
            $this->data = [];
        }
        $this->original_data = $this->data;
    }

    private function getParser(?string $file_path = null): Ini|Php|Json|Xml|Yaml {
        if (!$file_path) {
            $file_path = $this->file_path;
        }
        $extension = pathinfo($file_path, PATHINFO_EXTENSION) |>
                    strToLower(...);
        return match ($extension) {
            'ini'         => new Ini($file_path),
            'json'        => new Json($file_path),
            'yaml', 'yml' => new Yaml($file_path),
            'xml'         => new Xml($file_path),
            'php'         => new Php($file_path),
            default       => throw new Exception("Unsupported file extension: {$extension}")
        };
    }

    public function __destruct() {
        if ($this->options['autosave']) {
            $this->save();
        }
    }

    public function save(): bool|int {
        if ($this->data === $this->original_data) {
            return true;
        }
        $content = $this->parser->convertArray($this->data);
        return file_put_contents($this->file_path, $content);
    }

    public function saveAs(string $file_path, bool $return = false): string|false|int {
        $parser = $this->getParser($file_path);
        $extension = pathinfo($file_path, PATHINFO_EXTENSION) |>
                    strtolower(...);
        if (!in_array($extension, $parser->getValidExtensions())) {
            throw new Exception("Invalid file extension: {$extension}");
        }
        $content = $parser->convertArray($this->data);
        if ($return) {
            return $content;
        }
        return file_put_contents($file_path, $content);
    }

    public function delete(string ...$keys): void {
        $this->_delete($this->data, $keys);
    }

    private function _delete(array &$array, array $keys): void {
        foreach ($keys as $key) {
            if (array_key_exists($key, $array)) {
                if (is_array($array[$key])) {
                    $this->_delete($array[$key], ...array_slice($keys, 1));
                } else {
                    unset($array[$key]);
                }
                if (empty($array[$key])) {
                    unset($array[$key]);
                }
            }
        }
    }

    public function getAll(): array {
        return $this->data;
    }

    public function setAll(array $data): void {
        $this->data = $data;
    }

    public function mergeData(array $data): void {
        $this->data = array_merge($this->data, $data);
    }

    public function __get(string $key): mixed {
        return $this->data[$key] ?? null;
    }

    public function __set(string $key, mixed $value): void {
        $this->data[$key] = $value;
    }

    public function get(string ...$keys) {
        $work = $this->data;
        for ($i = 0; $i < count($keys); $i++) {
            $work = $work[$keys[$i]] ?? null;
        }
        return $work;
    }

    public function set(mixed $value, string ...$keys): void {
        if (count($keys) === 1) {
            $this->data[$keys[0]] = $value;
        } else {
            $working_array = &$this->data;
            for ($i = 0; $i < count($keys); $i++) {
                if ($i < (count($keys) - 1)) {
                    if (array_key_exists($keys[$i], $working_array)) {
                        $working_array = &$working_array[$keys[$i]];
                    } else {
                        $this->data[$keys[$i]] = [];
                        $working_array = &$this->data[$keys[$i]];
                    }
                } else {
                    $working_array[$keys[$i]] = $value;
                }
            }
        }
    }

}