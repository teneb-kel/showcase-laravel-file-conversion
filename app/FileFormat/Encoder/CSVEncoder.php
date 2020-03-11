<?php


namespace App\FileFormat\Encoder;


class CSVEncoder implements EncoderInterface
{
    public function encode(array $data) : string
    {
        // The cleanest solution is to write to a temporary file in memory.
        $f = fopen("php://memory", 'r+');

        $keys = array_keys($data[0]);
        $ucfirst_keys = array_map("ucfirst", $keys);
        fputcsv($f, $ucfirst_keys, ",");

        foreach ($data as $entry)
        {
            fputcsv($f, $entry, ",");
        }

        rewind($f);
        return stream_get_contents($f);
    }

    public function getMime() : string
    {
        return "text/csv";
    }

    public function getFileExtension() : string
    {
        return "csv";
    }
}
