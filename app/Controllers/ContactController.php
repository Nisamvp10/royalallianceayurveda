<?php
namespace App\Controllers;
use CodeIgniter\Controllers;
class ContactController extends BaseController
{
    public function index()
    {
        $page = "Contact Us";
        return view('frontend/contact-us',compact('page'));
    }
}
