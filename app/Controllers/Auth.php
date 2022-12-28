<?php

namespace App\Controllers;

use App\Models\UserModel;
use Exception;

class Auth extends BaseController
{

    public function __construct()
    {
        //membuat user model untuk konek ke database 
        $this->userModel = new UserModel();

        //meload validation
        $this->validation = \Config\Services::validation();

        //meload session
        $this->session = \Config\Services::session();
    }

    public function login()
    {
        //menampilkan halaman login
        return view('/auth/login');
    }

    public function register()
    {
        //menampilkan halaman register
        return view('/auth/register');
    }

    public function valid_register()
    {
        //tangkap data dari form 
        $data = $this->request->getPost();

        //jalankan validasi
        $this->validation->run($data, '/auth/register');

        //cek errornya
        $errors = $this->validation->getErrors();

        //jika ada error kembalikan ke halaman register
        if ($errors) {
            session()->setFlashdata('error', $errors);
            return redirect()->to('/auth/register');
        }

        //jika tdk ada error 

        //buat salt
        // $salt = uniqid('', true);

        //hash password digabung dengan salt
        $password = md5($data['password']);
        // . $salt;

        //masukan data ke database
        $this->userModel->save([
            'username' => $data['username'],
            'email' => $data['email'],
            'password' => $password,
            'confirmpassword' => $password,
            // 'salt' => $salt,
            'role_id' => 0
        ]);

        //arahkan ke halaman login
        session()->setFlashdata('/auth/login', 'Anda berhasil mendaftar, silahkan login');
        return redirect()->to('/auth/login');
    }
    
     public function insert_data_utility($data)
    {
        return $this->db->table('tb_utility')->insert($data);
    }
     public function edit_data_ownership($data)
    {
        return $this->db->table('tb_Project_ownership')->insert($data);
    }

    public function valid_login()
    {
        //ambil data dari form
        date_default_timezone_set("Asia/Bangkok");
        $data_post = $this->request->getPost();
        $now = date('Y-m-d H:i:s');

        //ambil data user di database yang usernamenya sama 
        $user = $this->userModel->where('username', $data_post['username'])->first();
        $data = array(
            'username' => $user['username'],
            'email' => $user['email'],
            // 'password' => $user['password'],
            'tgllogin' => $now
        );
        if ($user['email'] != 'erza.mazde@ffi-group.co.id' && $user['email'] != 'slamet.supriyanto@ipsos.com') {
        // if ($user['email'] != 'erza.mazde@ffi-group.co.id') {
            $this->insert_data_utility($data);
        }
        //cek apakah username ditemukan
        if ($user) {
            //cek password
            //jika salah arahkan lagi ke halaman login
            if ($user['password'] != md5($data_post['password'])) {
                session()->setFlashdata('password', 'Password salah');
                return redirect()->to('/auth/login');
            } else {
                //jika benar, arahkan user masuk ke aplikasi 
                $sessLogin = [
                    'isLogin' => true,
                    'username' => $user['username'],
                    'role_id' => $user['role_id']
                ];
                $this->session->set($sessLogin);
                $this->session->markAsTempdata('isLogin', 1500);

                return redirect()->to('Home/index');
            }
        } else {
            //jika username tidak ditemukan, balikkan ke halaman login
            session()->setFlashdata('username', 'Username tidak ditemukan');
            return redirect()->to('/auth/login');
        }
       
        
    }

    public function logout()
    {
        //hancurkan session 
        //balikan ke halaman login
        $this->session->destroy();
        return redirect()->to('/auth/login');
    }
}
