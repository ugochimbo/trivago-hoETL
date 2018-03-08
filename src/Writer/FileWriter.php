<?php declare(strict_types = 1);

namespace Converter\Writer;

interface FileWriter
{
    /**
     * @param string $fileName
     * @param string $data
     */
    public function write(string $fileName, string $data);
}