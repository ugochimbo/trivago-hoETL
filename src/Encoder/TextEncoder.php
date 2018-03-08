<?php declare(strict_types = 1);

namespace Converter\Encoder;

final class TextEncoder implements Encoder
{
    const FORMAT = 'txt';

    /**
     * {@inheritdoc}
     */
    public function format(): string
    {
        return self::FORMAT;
    }

    /**
     * {@inheritdoc}
     */
    public function encode(array $data) : string
    {
        return array_reduce($data, function ($result, $record){
            return $result . print_r($record, true) . PHP_EOL;
        }, '');
    }
}
