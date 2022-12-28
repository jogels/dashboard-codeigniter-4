<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use Dompdf\Dompdf;

class Convert extends Controller
{
    public function index()
    {
        return view('home_user');
    }

    public function generatepdf()
    {
        $filename = date('y-m-d-H-i-s') . 'pdf report';

        // instantiate and use the dompdf class
        $dompdf = new Dompdf();

        // load HTML content
        $dompdf->loadHtml(view('pdf_view'));

        // (optional) setup the paper size and orientation
        $dompdf->setPaper('A4', 'landscape');

        // render html as PDF
        $dompdf->render();

        // output the generated pdf
        $dompdf->stream($filename);
    }
}
