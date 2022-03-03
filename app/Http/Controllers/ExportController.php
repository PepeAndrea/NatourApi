<?php

namespace App\Http\Controllers;

use App\Models\Path;
use Illuminate\Http\Request;
use PDF;

class ExportController extends Controller
{
    

    public function exportPdf(Path $path)
    {
        $pdf = PDF::loadView("pathDetail",["path" => $path,"formattedDuration" => $this->formatDuration($path->duration)]);
        return $pdf->download(str_replace(" ","_",$path->title).".pdf");
    }

    private function formatDuration($milliseconds){
        $seconds = floor($milliseconds / 1000);
        $minutes = floor($seconds / 60);
        $hours = floor($minutes / 60);
        $seconds = $seconds % 60;
        $minutes = $minutes % 60;
        $format = '%u Ore %02u Minuti %02u Secondi';
        $time = sprintf($format, $hours, $minutes, $seconds);
        return rtrim($time, '0');
    }

    public function exportGpx(Path $path)
    {
        $fileName = str_replace(" ","_",$path->title).".gpx";

        $headers = array(
            "Content-type"        => "text/xml",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        );

        $header = '<?xml version="1.0" encoding="UTF-8"?><gpx xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns="http://www.topografix.com/GPX/1/1" xsi:schemaLocation="http://www.topografix.com/GPX/1/1 http://www.topografix.com/GPX/1/1/gpx.xsd http://www.garmin.com/xmlschemas/GpxExtensions/v3 http://www.garmin.com/xmlschemas/GpxExtensionsv3.xsd http://www.garmin.com/xmlschemas/TrackPointExtension/v1 http://www.garmin.com/xmlschemas/TrackPointExtensionv1.xsd http://www.topografix.com/GPX/gpx_style/0/2 http://www.topografix.com/GPX/gpx_style/0/2/gpx_style.xsd" xmlns:gpxtpx="http://www.garmin.com/xmlschemas/TrackPointExtension/v1" xmlns:gpxx="http://www.garmin.com/xmlschemas/GpxExtensions/v3" xmlns:gpx_style="http://www.topografix.com/GPX/gpx_style/0/2" version="1.1" creator="https://gpx.studio"><metadata><name>'.$path->title.'</name><author><name>'.$path->username.'</name><link href="https://natour.pepeandrea.it"></link></author></metadata><trk><name>'.$path->title.'</name><trkseg>';

        $coordinates = "";
        foreach ($path->coordinates as $item) {
            $coordinates .= '<trkpt lat="'.$item->latitude.'" lon="'.$item->longitude.'"><ele>12.5</ele></trkpt>';
        }
        $footer = '</trkseg></trk></gpx>';

        return response()->make($header.$coordinates.$footer, 200, $headers);
    }


}
