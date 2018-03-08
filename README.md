
# Approach

My implementation approach is based on the following assumptions :

1) This application would be used via cli.

Reasons:

- Most "big" data conversion tasks are done as scheduled tasks.
- It will give me the chance to focus more on the code (domain problem) and less on bootstrapping an http application.

2) Same name will be used for both the input and output file (with their respective extensions).

3) Default formats: json and xml.

4) Uri validation: uri should contain a protocol.

## Installation:

```composer install```

## Usage:
  ```php trivago csv:convert [options] [--] <file>```

Arguments:
  file                   Csv file path

#### Options:
```
 -o, --output[=OUTPUT]  Comma separated list of supported output formats. Defaults to xml and json

 -s, --strict           Determines if the script should run gracefully by writing only valid records to output files

 -d, --debug            Displays errors in non-strict mode. Defaults to True

 -h, --help             Display this help message

```

#### Basic usage:

```php trivago csv:convert /path/to/hotels.csv```

---

This uses a simple validation rule. Invalid records will not be written to the respective output files.
To view the respective invalid record detail, pass the debug flag:

```php trivago csv:convert /path/to/hotels.csv --debug```

##### Sample Output

```
Name: "Apartment Dörr" is invalid (contains non-ascii characters).
Name: "The Sölzer" is invalid (contains non-ascii characters).
Name: "The Hörle" is invalid (contains non-ascii characters).
...
...
...
Name: "Müller" is invalid (contains non-ascii characters).
Name: "Koch Mühle" is invalid (contains non-ascii characters).
```

---

To use a more strict validation scheme where no output file will be generated if there are invalid records,
pass the --strict flag in the command:

```php trivago csv:convert /path/to/hotels.csv --strict```

---

By default, a json and xml output file will be generated. To specify the output files you want, pass them as a comma
separated list with the --output flag

###### Single output file:

```php trivago csv:convert /path/to/hotels.csv --output=html```

###### Multiple output files:

```php trivago csv:convert /path/to/hotels.csv --output=html,xml,txt```

---

To view help using this command:

```php trivago csv:convert --help```

---

### Running Test:

```bin/phpunit```

---

### Adding new formats:

 - Implement the Encoder interface

```php
class NewFormatEncoder implements Encoder {

   /**
     * {@inheritdoc}
     */
    public function format(): string
    {
        return 'format'; //Will be used as file extension
    }

    /**
     * {@inheritdoc}
     */
    public function encode(array $data) : string
    {
        return $this->encoder->encode($data, $this->format());
    }
}
```

 - Map the encoder

 ###### Format.php

```php
...
...
	private static $encoders = [
        'json' => JsonEncoder::class,
        'xml' =>  XMLEncoder::class,
        'html' => HTMLEncoder::class,
        'txt' => TextEncoder::class,

        //add new format encoder mapping
    ];
...
...
```


### Final note:

Even though there are further modifications to be made to improve the quality and
flexibility of the code (e.g configuring default output formats and encoders), I decided not to do them since no further work will be done on
this code (my YAGNI card).

Also, given the relatively small size of the sample data, I decided to process the entire csv data in memory rather than processing
it in streams.
