<?php declare(strict_types = 1);

namespace Test\Validator;

use Converter\Validator\SimpleRecordValidator;
use PHPUnit\Framework\TestCase;

final class SimpleRecordValidatorTest extends TestCase
{
    /**
     * @dataProvider recordSets
     *
     * @param array $record
     * @param bool $expected
     */
    public function test_record_set(array $record, bool $expected)
    {
        $validator = new SimpleRecordValidator();

        $this->assertEquals($validator->isValid($record), $expected);
    }

    /**
     * @return array
     */
    public function recordSets(): array
    {
        return [
                'Valid Record'  => [['name' => 'James Bond', 'uri' => 'http://www.ugochimbo.com', 'stars' => '4.6'], true],
                'Invalid Name'  => [['name' => 'Ùgó Bond', 'uri' => 'http://www.ugochimbo.com', 'stars' => '5.0'], false],
                'Invalid Url'  => [['name' => 'James Bond', 'uri' => 'ugochimbo.com', 'stars' => '4.6'], false],
                'Negative Rating'  => [['name' => 'James Bond', 'uri' => 'http://www.ugochimbo.com', 'stars' => '-3.6'], false],
                'Out of bound Rating'  => [['name' => 'James Bond', 'uri' => 'http://www.ugochimbo.com', 'stars' => '5.1'], false],
            ];
    }
}
