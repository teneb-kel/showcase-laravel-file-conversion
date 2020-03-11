<?php


namespace App\Http\Controllers;

use App\FileFormat\Decoder\DecoderFactory;
use Illuminate\Http\Request;

class ImportController extends Controller
{
    public function postImport(Request $request)
    {
        $file = $request->file('file');

        // TODO: Better error handling.
        try
        {
            $mime_type = $file->getClientMimeType();
            $format = last(explode('/', $mime_type));

            $decoder = DecoderFactory::getInstance($format);
            $data = $decoder->decode(file_get_contents($file->getRealPath()));
        }
        catch (ErrorException $e)
        {
            // Something is wrong with your files.
            abort(400);
        }

        if (!is_array($data))
            abort(400);

        return view('edit')->with('data', $data);
    }
}
