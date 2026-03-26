<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class LanguageSwitcher extends Controller
{
    public function switch($lang = 'en')
    {
        $session = session();

        // Supported languages
        $supported = ['en', 'ar'];

        if (in_array($lang, $supported)) {
            $session->set('lang', $lang);
        } else {
            $session->set('lang', 'en');
        }

        // Redirect back to the previous page
        return redirect()->back();
    }
}
