<?php

namespace JscPhp\Configs\bin;

abstract class Parser {
    protected $file_path;

    public function __construct(string $file_path) {
        $this->file_path = $file_path;
    }


    /**Read the file contents and return an array
     * @return array
     */
    public abstract function parseFile(): array;

    /**Convert the array into storable string
     *
     * @param array $data
     *
     * @return string
     */
    public abstract function convertArray(array $data): string;

    /**Return valid file extensions for the selected type
     * @return array
     */
    public abstract function getValidExtensions(): array;


}