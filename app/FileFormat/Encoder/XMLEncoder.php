<?php


namespace App\FileFormat\Encoder;


class XMLEncoder implements EncoderInterface
{
    // Recursive array walk and XML addChild were switching keys and values around.
    protected function array2XML($array)
    {
        $xml_string = '';

        foreach($array as $key => $value)
        {
            // Getting rid of numeric keys.
            if (is_integer($key))
                $key = "element";

            if (is_array($value))
                $xml_string .= "<$key>" . $this->array2xml($value) . "</$key>";
            elseif ($value == '')
                $xml_string .= "<$key/>";
            else
                $xml_string .= "<$key>" . $value . "</$key>";
        }

        return $xml_string;
    }

    public function encode(array $data) : string
    {
        $xml = new \SimpleXMLElement("<root>" . $this->array2XML($data) . "</root>");

        return $xml->asXML();
    }

    public function getMime() : string
    {
        return "text/xml";
    }

    public function getFileExtension() : string
    {
        return "xml";
    }
}
