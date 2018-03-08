<?php declare(strict_types = 1);

namespace Converter\Writer;

final class SimpleFileWriter implements FileWriter
{
    /**
     * {@inheritdoc}
     */
    public function write(string $fileName, string $data)
    {
        file_put_contents($fileName, $data);
    }
}
