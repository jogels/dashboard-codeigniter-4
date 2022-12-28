<?php

namespace App\Models;

use CodeIgniter\Model;

class model_upload extends Model
{
    protected $table = 'RTD_masterdata';
    protected $primaryKey = "IDVENDOR";
    protected $useTimeStamps = true;
    protected $allowedFields = [
        'No',
        'IDVENDOR',
        'VendorName',
        'KodeAREA',
        'Help_Urut_Lama',
        'Help_Urut',
        'NamaArea',
        'Status',
        'Divisi',
        'Metode',
        'ID_INTV_LAMA',
        'ID_INTV',
        'Password_Login',
        'Nama',
        'Jenis_Kelamin',
        'Tanggal_Bergabung',
        'Alamar_Saat_Ini',
        'Kota',
        'Provinsi',
        'Nomor_Handphone',
        'Nomor_WA',
        'Email',
        'Tempat_Kelahiran',
        'Tanggal_Lahir',
        'KTP',
        'Alamat',
        'Status_Pernikahan',
        'Nomor_Rekening',
        'Nama_Bank',
        'NPWP',
        'Pendidikan_Terakhir',
        'NamaKeluargaAlternative',
        'NoTELPKeluargaAlternative',
        'RiwayatVaksinCovid',
        'AlasanBelumVaksin',
        'Jenis_Vaksin',
        'Tanggal_Vaksin_Ke_1',
        'Tanggal_Vaksin_Ke_2',
        'Beneficiary_Name',
        'Status_Active',
        'Tanggal_Blacklist_Suspend',
        'Tanggal_Selesai_Suspend',
        'Judul_Training',
        'Tgl_Training',
        'Mentor_Training',
        'Mentor_Training1',


    ];
    protected $returnType = 'object';

    public function alldata()
    {
        return $this->db->table('RTD_masterdata')->get()->getResultArray();
    }
}
