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


}
