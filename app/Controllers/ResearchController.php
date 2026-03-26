<?php
namespace App\Controllers;

class ResearchController extends BaseController{
    public function index() {
        return view('frontend/research');
    }

    public function whtnottodo() {
        return view('frontend/what-not-to-do');
    }
   
}