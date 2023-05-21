<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Dompdf\Dompdf;

class ReportesController extends Controller
{
    public function generarPDF()
    {
        // Crea una nueva instancia de DOMPDF
        $dompdf = new Dompdf();

        // Carga el HTML que quieres convertir a PDF
        $dompdf->loadHTML('<h1>Hola mundo</h1>');

        // Genera el PDF
        $dompdf->render();

        // Descarga el PDF
        $dompdf->stream();
    }
}
