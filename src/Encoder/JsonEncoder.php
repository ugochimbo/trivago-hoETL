<?php declare(strict_types = 1);

namespace Converter\Encoder;

use Symfony\Component\Serializer\Encoder\JsonEncoder as SymfonyJsonEncoder;

final class JsonEncoder implements Encoder
{
    const FORMAT = 'json';

    /**
     * @var SymfonyJsonEncoder
     */
    private $encoder;

    public function __construct()
    {
        $this->encoder = new SymfonyJsonEncoder();
    }

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
        return $this->encoder->encode($data, $this->format());
    }
}
