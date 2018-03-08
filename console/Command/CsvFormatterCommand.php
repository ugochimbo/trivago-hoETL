<?php declare(strict_types = 1);

namespace Console\Command;

use Converter\Converter;
use Converter\Validator\{RecordValidator, SimpleRecordValidator, StrictRecordValidator};
use Converter\Normalizer\CsvNormalizer;
use Converter\Writer\SimpleFileWriter;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\{
    InputArgument, InputDefinition, InputInterface, InputOption
};
use Symfony\Component\Console\Output\OutputInterface;

final class CsvFormatterCommand extends Command
{
    const DESCRIPTION_FILE = 'Csv file path';
    const DESCRIPTION_OUTPUT = 'Comma separated list of supported output formats. Defaults to xml and json';
    const DESCRIPTION_STRICT = 'Determines if the script should run gracefully by writing only valid records to output files';
    const DESCRIPTION_DEBUG = 'Displays errors in non-strict mode. Defaults to True';

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this->setName('csv:convert')
            ->setDescription('Converts csv to predefined formats')
            ->setHelp('This command allows you to convert csv to predefined formats.
             Available formats: xml, html, json and txt')
            ->setDefinition(
                new InputDefinition([
                    new InputArgument('file', InputArgument::REQUIRED, self::DESCRIPTION_FILE),
                    new InputOption('output', 'o', InputOption::VALUE_OPTIONAL, self::DESCRIPTION_OUTPUT, []),
                    new InputOption('strict', 's', InputOption::VALUE_NONE, self::DESCRIPTION_STRICT),
                    new InputOption('debug', 'd', InputOption::VALUE_NONE, self::DESCRIPTION_DEBUG),
                ])
            );
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $converter = new Converter(new CsvNormalizer(), $this->getValidator($input), new SimpleFileWriter());

        $converter->convert($this->absoluteFilePath($input), $this->outputFormats($input));

        $output->writeln('Done');
    }

    /**
     * @param InputInterface $input
     * @return RecordValidator
     */
    private function getValidator(InputInterface $input) : RecordValidator
    {
        if ($input->getOption('strict')) {
            return new StrictRecordValidator();
        }

        return new SimpleRecordValidator($input->getOption('debug'));
    }

    /**
     * @param InputInterface $input
     * @return string
     */
    private function absoluteFilePath(InputInterface $input) : string
    {
        $absolutePath = realpath($input->getArgument('file'));

        if (!$absolutePath) {
            throw new \RuntimeException(
                sprintf('File does not exist: %s', $input->getArgument('file'))
            );
        }

        return $absolutePath;
    }

    /**
     * @param InputInterface $input
     * @return array
     */
    private function outputFormats(InputInterface $input) : array
    {
        $formats = $input->getOption('output');

        return is_array($formats) ? $formats : explode(',', $formats);
    }
}