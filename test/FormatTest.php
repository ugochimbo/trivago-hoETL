<?php declare(strict_types = 1);

namespace Test;

use Converter\Encoder\{HTMLEncoder, JsonEncoder, TextEncoder};
use Converter\Format;
use PHPUnit\Framework\TestCase;

final class FormatTest extends TestCase
{
    /**
     * @dataProvider filenameProvider
     *
     * @param string $csvFilePath
     * @param string $extension
     * @param string $expected
     */
    public function test_filename_formatting(string $csvFilePath, string $extension, string $expected)
    {
        $this->assertEquals(Format::formattedFileName($csvFilePath, $extension), $expected);
    }

    public function test_should_return_default_formats_encoders()
    {
        $actual = Format::encoders([]);
        $expected = Format::encoders(Format::$defaultFormats);

        $this->assertEquals($actual, $expected);
    }

    /**
     * @dataProvider supportedEncodersProvider
     *
     * @param array $formats
     * @param array $encoders
     */
    public function test_valid_encoders(array $formats, array $encoders)
    {
        $actualEncoders = Format::encoders($formats);

        foreach ($actualEncoders as $encoder) {
            $this->assertTrue(in_array(get_class($encoder), $encoders));
        }
    }

    /**
     * @dataProvider unSupportedEncodersProvider
     *
     * @param array $formats
     */
    public function test_invalid_encoders(array $formats)
    {
        $this->expectException(\DomainException::class);

        $actualEncoders = Format::encoders($formats);
    }


    /**
     * @return array
     */
    public function filenameProvider(): array
    {
        return [
            'csv to Json'  => ['demo.csv', 'json', 'demo.json'],
            'csv to Xml'  => [__DIR__ . 'demo.csv', 'XML', __DIR__ . 'demo.xml'],
            'csv to Html'  => ['demo.csv', ' HTML ', 'demo.html'],
            'csv to Txt'  => [__DIR__ . '/test/demo.csv', 'txt', __DIR__ . '/test/demo.txt'],
        ];
    }

    /**
     * @return array
     */
    public function supportedEncodersProvider() : array
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
    public function unSupportedEncodersProvider() : array
    {
        return [
            'One format'  => [['ght']],
            'Two formats'  => [['unknown', 'demo']],
        ];
    }
}
