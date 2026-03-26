<?php
namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class Userauth implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $userData = session('user');
        if (!$userData  || empty($userData['isLoggedIn'])) {
            return redirect()->to('login');
        }
    }

     public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do nothing after
    }
}