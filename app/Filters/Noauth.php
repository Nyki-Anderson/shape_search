<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class Noauth implements FilterInterface
{
    public function before (RequestInterface $request, $arguments = null)
    {
        if (session()->get('isLoggedIn')) {

            if (session()->get('role') == 1) {

                return redirect('admin_dashboard');
            }

            if (session()->get('role') ==  0) {

                return redirect('member_dashboard');
            }
        }
    }
    
    public function after (RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        
    }
}