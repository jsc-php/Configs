<?php

namespace JscPhp\Configs\bin;

class Php extends Parser {

    public function parseFile(): array {
        $data = include($this->file_path);
        print_r($data);
        return $data;
    }

    public function convertArray(array $data): string {
        return '<?php' . PHP_EOL . 'return ' . var_export($data, true) . ';';
    }

    public function getValidExtensions(): array {
        return ['php'];
    }
}