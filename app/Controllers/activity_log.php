<?php

namespace App\Controllers;

use App\Models\UserModel;
use Exception;

class activity_log extends BaseController
{
   public function __construct ($database) {
      $this->database = database; // koneksi dan query ke database
      $this->table_name = 'tb_utility'; // nama tabel
   }
   public function record ($activity_name, $data) { //method untuk merekam aktivitas

      $toRecord = array();
      $toRecord['username'] = $activity_name;
      $toRecord['email'] = json_encode($data);
      $toRecord['tgllogin'] = date("Y-m-d h:i:s");

      $result = $this->database->insert('tb_utility', $toRecord); // simpan data ke tabel

       if(!$result):
          return false;
       endif;
       return $result;

   }
}