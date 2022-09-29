<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class Home extends BaseController
{
    public function index()
    {
        $data['title'] = 'Home';

        echo view('templates/index_header', $data);
        echo view('pages/home');
        echo view('templates/footer');
    }

    public function view_pages($page = 'home')
    {
        if (! is_file(APPPATH . 'Views/pages/' . $page . '.php')) {

            throw new \Codeigniter\Exceptions\PageNotFoundException($page);

        } else {

            if (($page == 'terms_use') || ($page == 'privacy_policy')) {
                
                echo view('pages/' . $page);

            } else {

                $data['title'] = ucfirst($page);
                    
                echo view('templates/index_header', $data);
                echo view('pages/' . $page, $data);
                echo view('templates/footer');
            }
        }
    }
}