<?php

namespace App\Models;

use CodeIgniter\Model;

class model_nwb extends Model
{
    protected $table = 'tb_NWB';
    protected $primaryKey = "NWB_ID";
    protected $useTimeStamps = true;
    protected $allowedFields = [
        'NWB_10digit',
        'NWB_12digit',
        'NWB_IDPROJ',
        'NWB_MINLOI',
        'NWB_MAXLOI',
        'NWB_MINTIME',
        'NWB_MAXTIME',
        'NWB_INT',
        'NWB_StartDate',
        'NWB_Quota1',
        'NWB_Quota2',
        'NWB_Quota3',
        'NWB_Quota4',
        'NWB_Quota5',
        'NWB_Quota6',
        'NWB_Quota7',
        'NWB_Quota8',
        'NWB_Num',
        'NWB_STATUS',
        'TimeDownload',
    ];
    protected $returnType = 'object';

    public function alldata()
    {
        return $this->db->table('tb_NWB')->get()->getResultArray();
    }
}
