<?php


namespace App\FileFormat\Decoder;


class XMLDecoder implements DecoderInterface
{
    public function decode(string $data) : array
    {
        $xml = simplexml_load_string($data);

        // Flip it to JSON and then to array. Works like a charm.
        $json = json_encode($xml);
        $array = json_decode($json, true);

        // Skip the "element" node.
        return $array['element'];
    }
}
