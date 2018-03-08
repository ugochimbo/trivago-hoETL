<?php declare(strict_types=1);

namespace Converter\Encoder;

interface Encoder
{
    /**
     * @return string
     */
    public function format() : string;

    /**
     * @param array $data
     * @return string
     */
    public function encode(array $data) : string;
}
