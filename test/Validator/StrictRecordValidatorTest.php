<?php declare(strict_types = 1);

namespace Test\Validator;

use Converter\Validator\StrictRecordValidator;
use PHPUnit\Framework\TestCase;

final class StrictRecordValidatorTest extends TestCase
{
    public function test_valid_record_set()
    {
        $record = ['name' => 'James Bond', 'uri' => 'http://www.ugochimbo.com', 'stars' => '4.6'];

        $validator = new StrictRecordValidator();

        $this->assertTrue($validator->isValid($record));
    }

    /**
     * @dataProvider invalidRecordSets
     * @param array $record
     */
    public function test_invalid_records_throw_exceptions(array $record)
    {
        $validator = new StrictRecordValidator();

        $this->expectException(\DomainException::class);

        $validator->isValid($record);
    }

    /**
     * @return array
     */
    public function invalidRecordSets(): array
    {
        return [
            'Invalid Name'  => [['name' => 'Ùgó Bond', 'uri' => 'http://www.ugochimbo.com', 'stars' => '5.0']],
            'Invalid Url'  => [['name' => 'James Bond', 'uri' => 'ugochimbo.com', 'stars' => '4.6']],
            'Negative Rating'  => [['name' => 'James Bond', 'uri' => 'http://www.ugochimbo.com', 'stars' => '-3.6']],
            'Out of bound Rating'  => [['name' => 'James Bond', 'uri' => 'http://www.ugochimbo.com', 'stars' => '5.1']],
        ];
    }
}
