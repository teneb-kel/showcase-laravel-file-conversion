<?php


namespace App\FileFormat\Decoder;


class CSVDecoder implements DecoderInterface
{
    public function decode($data)
    {
        $data = trim($data);

        $array = array_map('str_getcsv', explode("\n", $data));
        $keys = array_map('strtolower', array_shift($array));

        array_walk($array, function(&$r) use ($keys, $array)
        {
            $r = array_combine($keys, $r);
        });

        return $array;
    }
}
