<?php

namespace App\Console\Commands;

use App\FileFormat\Decoder\DecoderFactory;
use App\FileFormat\Encoder\EncoderFactory;
use Illuminate\Console\Command;
use Storage;

class ConvertFile extends Command
{
    protected $signature = 'convert:countries {--i|input-file=} {--o|output-file=}';

    protected $description = 'Converts a file to a different format';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $input = $this->option('input-file');
        $input_format = last(explode('.', $input));
        if ($input_format == null)
            $input_format = "json";

        // TODO: Better error handling.
        try
        {
            $decoder = DecoderFactory::getInstance($input_format);
            $data = $decoder->decode(Storage::disk('public')->get($input));
        }
        catch (ErrorException $e)
        {
            // Something is wrong with your files.
            echo "Invalid input file.\n";
        }

        $output = $this->option('output-file');
        $output_format = last(explode('.', $output));
        if ($output_format == null)
            $output_format = "json";

        echo "Converting to $output_format...\n";

        $encoder = EncoderFactory::getInstance($output_format);
        $converted_data = $encoder->encode($data);

        Storage::disk('public')->put($output, $converted_data);

        echo "Conversion has been successful.\n";
    }
}
