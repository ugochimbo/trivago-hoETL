<?php declare(strict_types = 1);

namespace Converter\Normalizer;

interface FileNormalizable
{
    /**
     * @param string $fileName
     * @return array
     */
    public function normalize(string $fileName) : array;
}
