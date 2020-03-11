<?php


namespace App\Http\Controllers;

use App\FileFormat\Encoder\EncoderFactory;
use Illuminate\Http\Request;

class ExportController extends Controller
{
    public function postExport(Request $request)
    {
        $content = json_decode($request->get('content'), true);
        $format = $request->get('format');

        // TODO: Better error handling.
        try
        {
            $encoder = EncoderFactory::getInstance($format);
            $data = $encoder->encode($content);
        }
        catch (Exception $e)
        {
            // Something is wrong with your files.
            abort(400);
        }

        return response($data)
            ->withHeaders([
                'Content-Type' => $encoder->getMime(),
                'Cache-Control' => 'no-store, no-cache',
                'Content-Disposition' => 'attachment; filename="countries.' . $encoder->getFileExtension()
            ]);
    }
}
