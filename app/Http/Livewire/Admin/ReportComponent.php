<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use PDF;

class ReportComponent extends Component
{
    public function downloadPDF()
    {
        $html = '<h1>Este es mi PDF</h1><p>Contenido del PDF</p>';
        $pdf = PDF::loadHTML($html);
        return $pdf->download('pdf-download.pdf');
    }

    public function render()
    {
        return view('livewire.admin.report-component')->layout('layouts.admin');
    }
}
