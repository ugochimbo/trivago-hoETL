<?php declare(strict_types = 1);

namespace Converter\Encoder;

use Symfony\Component\Serializer\Encoder\XmlEncoder as SymfonyXmlEncoder;

final class XMLEncoder implements Encoder
{
    const FORMAT = 'xml';

    /**
     * @var SymfonyXmlEncoder
     */
    private $encoder;

    public function __construct()
    {
        $this->encoder = new SymfonyXmlEncoder();
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
