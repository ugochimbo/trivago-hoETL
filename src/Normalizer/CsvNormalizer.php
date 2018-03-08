<?php declare(strict_types = 1);

namespace Converter\Normalizer;

use Converter\Validator\Assert;
use ParseCsv\Csv;

final class CsvNormalizer implements FileNormalizable
{
    /**
     * {@inheritdoc}
     */
    public function normalize(string $fileName) : array
    {
        Assert::isCsvFile($fileName);

        return (new Csv($fileName))->data;
    }
}
