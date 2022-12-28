<?php

namespace App\Libraries;

use CodeIgniter\Session\Session;
use phpDocumentor\Reflection\Location;

class Auth_Custom
{
    // This function converts a string into slug format
    public function isAdmin()
    {
        //cek role dari session
        $session = session();
        if ($session->get('role_id') != 1) {
            return false;
            // echo 'bukan admin';
        } else {

            return true;
            // echo $this->session->get('role_id');
        }
    }
    public function isAdmin2($view1, $view2)
    {
        //cek role dari session
        $session = session();
        if ($session->get('role_id') != 1) {
            // redirect($view2);
            header('Location: ' . base_url($view2));

            // echo 'bukan admin';
        } else {

            // redirect($view1);
            header('Location: ' . base_url($view1));

            // echo $this->session->get('role_id');
        }
        exit();
    }

    public function isAdmin3()
    {
        $session = session();
        if ($session->get('role_id') != 1) {
            header('Location: ' . base_url());
            exit();
        }
    }
    public function isLoggedIn()
    {
        $session = session();
        if (!$session->has('isLogin')) {
            header('Location: ' . base_url('/auth/login'));
            exit();
        }
    }
}
