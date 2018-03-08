<?php declare(strict_types = 1);

namespace Converter;

final class FormatEncoder implements \Iterator
{
    /** @var array */
    private $encoders = [];

    /** @var int */
    private $index;

    /**
     * @param array $outputFormats
     */
    public function __construct(array $outputFormats)
    {
        $this->index = 0;
        $this->encoders = Format::encoders($outputFormats);
    }

    /**
     * {@inheritdoc}
     */
    public function current()
    {
        return $this->encoders[$this->index];
    }

    /**
     * {@inheritdoc}
     */
    public function next()
    {
        $this->index++;
    }

    /**
     * {@inheritdoc}
     */
    public function key()
    {
        return $this->index;
    }

    /**
     * {@inheritdoc}
     */
    public function valid()
    {
        return isset($this->encoders[$this->index]);
    }

    /**
     * {@inheritdoc}
     */
    public function rewind()
    {
        $this->index = 0;
    }
}
