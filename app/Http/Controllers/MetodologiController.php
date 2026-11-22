<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class MetodologiController extends Controller
{
    public function index()
    {
        // Read academic reports if available
        $dataDictPath = base_path('data/reports/data_dictionary.md');
        $etlLogPath = base_path('data/reports/etl_transformation_log.md');
        $qualityReportPath = base_path('data/reports/data_quality_report.json');

        $dataDict = File::exists($dataDictPath) ? File::get($dataDictPath) : '';
        $etlLog = File::exists($etlLogPath) ? File::get($etlLogPath) : '';
        $qualityJson = File::exists($qualityReportPath) ? json_decode(File::get($qualityReportPath), true) : [];

        return view('dashboard.metodologi', compact('dataDict', 'etlLog', 'qualityJson'));
    }
}
