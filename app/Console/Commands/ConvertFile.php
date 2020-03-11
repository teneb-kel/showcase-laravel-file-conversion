<?php

namespace App\Console\Commands;

use App\FileFormat\Decoder\DecoderFactory;
use App\FileFormat\Encoder\EncoderFactory;
use Illuminate\Console\Command;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
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
            $input_file = Storage::disk('public')->get($input);

            $decoder = DecoderFactory::getInstance($input_format);
            $data = $decoder->decode($input_file);
        }
        catch (FileNotFoundException $fnfe)
        {
            $this->error("Input file not found. It should be located in storage/app/public");

            return;
        }
        catch (ErrorException $e)
        {
            // Something is wrong with your files.
            $this->error("Invalid input file.");

            return;
        }

        $output = $this->option('output-file');
        $output_format = last(explode('.', $output));
        if ($output_format == null)
            $output_format = "json";

        $this->info("Converting to $output_format...");

        $encoder = EncoderFactory::getInstance($output_format);
        $converted_data = $encoder->encode($data);

        Storage::disk('public')->put($output, $converted_data);

        $this->info("Conversion has been successful.");
    }
}
