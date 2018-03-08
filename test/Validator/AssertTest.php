<?php declare(strict_types = 1);

namespace Test\Validator;

use Converter\Validator\Assert;
use PHPUnit\Framework\TestCase;

final class AssertTest extends TestCase
{
    public function test_invalid_csv_file()
    {
        $filePath = __DIR__ . '/html/fixture.html';

        $this->expectException(\DomainException::class);

        Assert::isCsvFile($filePath);
    }

    public function test_valid_csv_file()
    {
        $filePath = __DIR__ . '/csv/partial.csv';

        $this->assertTrue(Assert::isCsvFile($filePath));
    }
}
