<?php declare(strict_types = 1);

namespace Test;

use Converter\Encoder\{
    Encoder, HTMLEncoder, JsonEncoder, TextEncoder
};
use Converter\FormatEncoder;
use PHPUnit\Framework\TestCase;

final class FormatEncoderTest extends TestCase
{
    /**
     * @dataProvider supportedFormatsProvider
     *
     * @param array $formats
     * @param array $encoders
     */
    public function test_supported_formats(array $formats, array $encoders)
    {
        $formatEncoders = new FormatEncoder($formats);

        /**
         * @var Encoder $encoder
         */
        foreach ($formatEncoders as $encoder) {
            $this->assertTrue(in_array(get_class($encoder), $encoders));
        }
    }

    /**
     * @dataProvider unSupportedFormatsProvider
     *
     * @param array $formats
     */
    public function test_unsupported_formats(array $formats)
    {
        $this->expectException(\DomainException::class);

        $formatEncoders = new FormatEncoder($formats);
    }

    /**
     * @return array
     */
    public function supportedFormatsProvider() : array
    {
        return [
            'One format'  => [['json'], [JsonEncoder::class]],
            'Two formats'  => [['json', 'txt'], [JsonEncoder::class, TextEncoder::class]],
            'Three formats'  => [['html', 'json', 'txt'], [HTMLEncoder::class, JsonEncoder::class, TextEncoder::class]],
        ];
    }

    /**
     * @return array
     */
    public function unSupportedFormatsProvider() : array
    {
        return [
            'One format'  => [['ght']],
            'Two formats'  => [['unknown', 'demo']],
        ];
    }
}
