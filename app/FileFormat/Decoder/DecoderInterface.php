<?php


namespace App\FileFormat\Decoder;


interface DecoderInterface
{
    public function decode(string $data) : array;
}
