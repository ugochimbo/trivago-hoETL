<?php declare(strict_types=1);

namespace Test;

use Converter\Converter;
use Converter\Format;
use Converter\Normalizer\CsvNormalizer;
use Converter\Validator\SimpleRecordValidator;
use Converter\Writer\SimpleFileWriter;
use PHPUnit\Framework\TestCase;

final class ConverterTest extends TestCase
{
    public function test_invalid_files_throws_exceptions()
    {
       $converter = new Converter(new CsvNormalizer(), new SimpleRecordValidator(), new SimpleFileWriter());

       $this->expectException(\RuntimeException::class);

       $converter->convert('/path/to/invalid.csv', []);
    }

    public function test_should_create_output_files()
    {
       $dirPath = __DIR__ . '/fixture/csv/';
       $expected1 = sprintf('%s/test.%s', $dirPath, Format::$defaultFormats[0]);
       $expected2 = sprintf('%s/test.%s', $dirPath, Format::$defaultFormats[1]);

       $converter = new Converter(new CsvNormalizer(), new SimpleRecordValidator(), new SimpleFileWriter());
       $converter->convert($dirPath . '/test.csv', []);

       $this->assertTrue(file_exists($expected1));
       $this->assertTrue(file_exists($expected2));

       $this->cleanUp([$expected1, $expected2]);
    }

    private function cleanUp(array $files)
    {
        foreach ($files as $file) {
            unlink($file);
        }
    }
}
