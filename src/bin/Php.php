<?php

namespace JscPhp\Configs\bin;

class Php extends Parser {

    public function parseFile(): array {
        return require_once($this->file_path);
    }

    public function convertArray(array $data): string {
        return '<?php' . PHP_EOL . 'return ' . var_export($data, true) . ';';
    }

    public function getValidExtensions(): array {
        return ['php'];
    }
}