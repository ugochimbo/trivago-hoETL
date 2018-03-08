<?php declare(strict_types=1);

namespace Converter;

use Converter\Encoder\Encoder;
use Converter\Normalizer\FileNormalizable;
use Converter\Validator\{
    Assert, Filter, RecordValidator
};
use Converter\Writer\FileWriter;

final class Converter
{
    /**
     * @var FileNormalizable
     */
    private $normalizer;

    /**
     * @var RecordValidator
     */
    private $recordValidator;

    /**
     * @var FileWriter
     */
    private $fileWriter;

    /**
     * @param FileNormalizable $normalizer
     * @param RecordValidator $recordValidator
     * @param FileWriter $fileWriter
     */
    public function __construct(
        FileNormalizable $normalizer,
        RecordValidator $recordValidator,
        FileWriter $fileWriter
    ) {
        $this->normalizer = $normalizer;
        $this->recordValidator = $recordValidator;
        $this->fileWriter = $fileWriter;
    }

    /**
     * @param string $fileName
     * @param array $formats
     */
    public function convert(string $fileName, array $formats)
    {
        Assert::isValidFile($fileName);

        $validRecords = Filter::validRecords($this->recordValidator, $this->normalizer->normalize($fileName));

        $this->writeFiles($fileName, $formats, $validRecords);
    }

    /**
     * @param string $fileName
     * @param array $outputFormats
     * @param array $data
     */
    private function writeFiles(string $fileName, array $outputFormats, array $data)
    {
        $formats = new FormatEncoder($outputFormats);

        /** @var Encoder $format */
        foreach ($formats as $format) {
            $this->fileWriter->write(
                Format::formattedFileName($fileName, $format->format()),
                $format->encode($data)
            );
        }
    }
}
