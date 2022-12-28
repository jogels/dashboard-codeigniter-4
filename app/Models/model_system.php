<?php

namespace App\Models;

use CodeIgniter\Model;

class model_system extends Model
{
    protected $table = 'tb_RTD';
    protected $primaryKey = "RTD_User_ID";
    protected $useTimeStamps = true;
    protected $allowedFields = [
        'RTD_Last_Name',
        'RTD_Gender',
        'RTD_Company_Name',
        'RTD_Address',
        'RTD_City',
        'RTD_Phone_home',
        'RTD_IDVENDOR',
    ];
    protected $returnType = 'object';

    public function alldata()
    {
        return $this->db->table('tb_rtd')->get()->getResultArray();
    }
}
