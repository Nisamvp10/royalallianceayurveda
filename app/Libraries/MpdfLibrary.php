<?php 
namespace App\Libraries;

use Mpdf\Mpdf;

class MpdfLibrary
{
    public function load($config = [])
    {
        return new Mpdf($config);
    }
}
