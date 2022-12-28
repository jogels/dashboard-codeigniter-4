<?php

namespace App\Controllers;

use App\Libraries\Auth_Custom; // Import library

class Admin extends BaseController
{

    public function __construct()
    {

        $this->Auth_Custom = new Auth_Custom(); // create an instance of Library
        $this->session = session();
    }

    public function index()
    {
        //cek apakah ada session bernama isLogin
        if (!$this->session->has('isLogin')) {
            return redirect()->to('/auth/login');
        }

        //cek role dari session
        // if ($this->session->get('role_id') != 1) {
        //     return redirect()->to('home_user');
        //     // echo 'bukan admin';
        // }

        // return view('home');
        // // echo $this->session->get('role_id');

        if ($this->Auth_Custom->isAdmin()) {
            return view('home_admin');
        } else {
            return redirect()->to('home_user');
        }
    }

    public function Home()
    {
    }
}
