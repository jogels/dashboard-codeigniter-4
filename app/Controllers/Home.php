<?php

namespace App\Controllers;


use App\Models\model_system;
use App\Models\model_upload;
use App\Models\model_nwb;
use Exception;
use App\Libraries\Auth_Custom; // Import library
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Dompdf\Dompdf;

class Home extends BaseController
{
    protected $model_system;
    protected $model_nwb;
    protected $model_upload;
    private $userModel;

    public function __construct()
    {

        $this->Auth_Custom = new Auth_Custom(); // create an instance of Library

        $this->Auth_Custom->isLoggedIn();

        $this->userModel = new  \App\Models\UserModel();
        $this->model_system = new \App\Models\model_system();
        $this->model_nwb = new model_nwb();
        $this->model_upload = new \App\Models\model_upload();
    }

    public function index()
    {

        // if ($this->Auth_Custom->isAdmin()) {
        //     return redirect()->to('home_admin');
        // } else {
        //     return redirect()->to('home_user');
        // }

        $this->Auth_Custom->isAdmin2('home_admin', 'home_user');
    }

    public function home_user()
    {
        // $session = session();
        // echo "Welcome back, " . $session->get('username');
        return view('home_user');
    }
    public function home_user_close()
    {
        return view('home_user_close');
    }

    public function home_admin()
    {
        $this->Auth_Custom->isAdmin3();
        // $session = session();
        // echo "Welcome back, " . $session->get('username');
        return view('home_admin');
    }

    public function home_admin_test()
    {
        return view('home_admin_test');
    }
    public function home_admin_by12digit()
    {
        return view('home_admin_by12digit');
    }
    public function home_admin_close()
    {
        return view('home_admin_close');
    }
    public function home_admin_script()
    {
        return view('home_admin_script');
    }
    public function home_admin_tabulasi()
    {
        return view('home_admin_tabulasi');
    }
    //  public function home_user(){
    //     return view('home_user');
    // }
    public function home_user_script()
    {
        return view('home_user_script');
    }
    public function home_user_tabulasi()
    {
        return view('home_user_tabulasi');
    }

    public function home_admin_utility()
    {
        return view('home_admin_utility');
    }
    public function home_user_utility()
    {
        return view('home_user_utility');
    }

    public function exportnwb()
    {
        $nwb = $this->model_nwb->findAll();


        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'NWB_ID');
        $sheet->setCellValue('C1', 'NWB_10digit');
        $sheet->setCellValue('D1', 'NWB_12digit');
        $sheet->setCellValue('E1', 'NWB_IDPROJ');
        $sheet->setCellValue('F1', 'NWB_MINLOI');
        $sheet->setCellValue('G1', 'NWB_MAXLOI');
        $sheet->setCellValue('H1', 'NWB_MINTIME');
        $sheet->setCellValue('I1', 'NWB_MAXTIME');
        // $sheet->setCellValue('J1', 'NWB_INT');
        // $sheet->setCellValue('K1', 'NWB_StartDate');
        // $sheet->setCellValue('L1', 'NWB_Quota1');
        // $sheet->setCellValue('M1', 'NWB_Quota2');
        // $sheet->setCellValue('N1', 'NWB_Quota3');
        // $sheet->setCellValue('O1', 'NWB_Quota4');
        // $sheet->setCellValue('P1', 'NWB_Quota5');
        // $sheet->setCellValue('Q1', 'NWB_Quota6');
        // $sheet->setCellValue('R1', 'NWB_Quota7');
        // $sheet->setCellValue('S1', 'NWB_Quota8');
        // $sheet->setCellValue('T1', 'NWB_Num');
        // $sheet->setCellValue('U1', 'NWB_STATUS');
        // $sheet->setCellValue('V1', 'TimeDownload');

        $column = 2;  //column start
        foreach ($nwb as $key => $value) {
            $sheet->setCellValue('A' . $column, ($column - 1));
            $sheet->setCellValue('B' . $column, $value->NWB_ID);
            $sheet->setCellValue('C' . $column, $value->NWB_10digit);
            $sheet->setCellValue('D' . $column, $value->NWB_12digit);
            $sheet->setCellValue('E' . $column, $value->NWB_IDPROJ);
            $sheet->setCellValue('F' . $column, $value->NWB_MINLOI);
            $sheet->setCellValue('G' . $column, $value->NWB_MAXLOI);
            $sheet->setCellValue('H' . $column, $value->NWB_MINTIME);
            $sheet->setCellValue('I' . $column, $value->NWB_MAXTIME);
            // $sheet->setCellValue('J' . $column, $value->NWB_INT);
            // $sheet->setCellValue('K' . $column, $value->NWB_StartDate);
            // $sheet->setCellValue('L' . $column, $value->NWB_Quota1);
            // $sheet->setCellValue('M' . $column, $value->NWB_Quota2);
            // $sheet->setCellValue('N' . $column, $value->NWB_Quota3);
            // $sheet->setCellValue('O' . $column, $value->NWB_Quota4);
            // $sheet->setCellValue('P' . $column, $value->NWB_Quota5);
            // $sheet->setCellValue('Q' . $column, $value->NWB_Quota6);
            // $sheet->setCellValue('R' . $column, $value->NWB_Quota7);
            // $sheet->setCellValue('S' . $column, $value->NWB_Quota8);
            // $sheet->setCellValue('T' . $column, $value->NWB_Num);
            // $sheet->setCellValue('U' . $column, $value->NWB_STATUS);
            // $sheet->setCellValue('V' . $column, $value->TimeDownload);
            $column++;
        }
        $writer = new Xlsx($spreadsheet);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename=nwb.csv');
        header('Cache-Control: max-age=0');


        $writer->save('php://output');
        exit();
    }

    function datedifference($date_1, $date_2)
    {

        $date1 = date_create($date_1);
        $date2 = date_create($date_2);
        $diff = date_diff($date1, $date2);
        $hsl = $diff->format("%R%a days");
        $hsl = str_replace("+", "", $hsl);
        $hsl = str_replace(" days", "", $hsl);
        return $hsl;
    }
    public function data_before_export()
    {
        $skarang = date("Y-m-d");
        $conn = mysqli_connect("localhost", "root", "", "webopsid_webops_db");
        $strquery = "SELECT VendorName as RTD_Company_Name,ID_INTV_LAMA as RTD_User_ID,IDVENDOR as RTD_IDVENDOR  FROM RTD_masterdata GROUP BY RTD_User_ID";
        $bantu01 = mysqli_query($conn, $strquery);
        $master_rtd = [];
        while ($row = mysqli_fetch_assoc($bantu01)) {
            $master_rtd[] = $row;
        }
        $arr_idrtd = array_column($master_rtd, 'RTD_User_ID');

        $strquery = "SELECT id_vendor as VEN_ID,provinsi as VEN_PROV,vendor_name as VEN_NAME,kota_area_cakupan as VEN_AREA,pic as VEN_PIC,telp_pic as VEN_TELPPIC  FROM RTD_vendor GROUP BY VEN_ID";
        $bantu01 = mysqli_query($conn, $strquery);
        $SUMMVENDOR = [];
        $arr_idvendor = [];
        while ($row = mysqli_fetch_assoc($bantu01)) {
            $SUMMVENDOR[] = $row;
        }
        //print_r($SUMMVENDOR);
        $arr_idvendor = array_column($SUMMVENDOR, 'VEN_ID');
        // print_r($arr_idvendor);
        // die();


        $strquery = "SELECT PROJ_KODENWB,PROJ_ID10DGT,PROJ_name_parent,PROJ_Field_End,PROJ_Field_End_Adj FROM tb_Project_ownership WHERE PROJ_StatusFieldFinal=1  GROUP BY PROJ_KODENWB";
        $bantu01 = mysqli_query($conn, $strquery);
        $tb_owner = [];
        $id_own = [];
        while ($row = mysqli_fetch_assoc($bantu01)) {
            // $tb_owner1[] = $row;
            // if(datedifference($skarang,$row['PROJ_Field_End_Adj'])>=0){
            $bantu = [];
            $bantu['PROJ_KODENWB'] = $row['PROJ_KODENWB'];
            $bantu['PROJ_ID10DGT'] = $row['PROJ_ID10DGT'];
            $bantu['PROJ_name_parent'] = $row['PROJ_name_parent'];
            $bantu['PROJ_Field_End_Adj'] = $row['PROJ_Field_End_Adj'];
            $bantu['selisih_tgl'] = $this->datedifference($skarang, $row['PROJ_Field_End_Adj']);
            $tb_owner[] = $bantu;
            // }
        }
        // print_r($tb_owner);
        $id_own = array_column($tb_owner, 'PROJ_KODENWB');
        // print_r($id_own);
        // die();


        // $strquery = "SELECT *  FROM tb_NWB  LEFT JOIN tb_Project_ownership ON NWB_ID = PROJ_KODENWB WHERE PROJ_StatusFieldFinal=1 GROUP BY NWB_INT";
        // $bantu01 = mysqli_query($conn, $strquery);
        // $bantu02 = [];
        // while ($row = mysqli_fetch_assoc($bantu01)) {
        //     $bantu02[] = $row;
        // }
        // $arr_intvw = array_column($bantu02, 'NWB_INT');
        // $strquery = "SELECT NWB_INT,NWB_StartDate  FROM tb_NWB GROUP BY NWB_StartDate";
        // $bantu01 = mysqli_query($conn, $strquery);
        // $bantu02 = [];
        // while ($row = mysqli_fetch_assoc($bantu01)) {
        //     $bantu02[] = $row;
        // }
        // $arr_date = array_column($bantu02, 'NWB_StartDate');
        // $c_intv = COUNT($arr_intvw);
        // $min_date = str_replace('-', '/', MIN($arr_date));
        // $max_date = str_replace('-', '/', MAX($arr_date));
        $c_intv = '';
        $min_date = '';
        $max_date = '';


        //BUAT LIS VENDOR VS JUM INTV
        //TESSSS
        /*
        $strquery = "SELECT PROJ_Symphoni_num,PROJ_Project_name,NWB_ID,NWB_INT,PROJ_Field_End,PROJ_Field_End_Adj,SUM(IF(NWB_STATUS = 'Complete',NWB_Num,0)) AS vValid,SUM(IF(NWB_STATUS = 'Cancelled',NWB_Num,0)) AS vCancel   FROM tb_NWB LEFT JOIN tb_Project_ownership ON NWB_ID = PROJ_KODENWB  LEFT JOIN tb_RTD ON tb_NWB.NWB_INT = tb_RTD.RTD_User_ID   WHERE PROJ_StatusFieldFinal=1 and RTD_IDVENDOR LIKE '13824348' GROUP BY NWB_12digit";
        $bantu01 = mysqli_query($conn, $strquery);
        $TES = [];
        while ($row = mysqli_fetch_assoc($bantu01)) {
            $TES[] = $row;
        }
        print_r($TES);
        // die();
        */

        //$strquery = "SELECT * FROM tb_NWB LEFT JOIN tb_RTD ON tb_NWB.NWB_INT = tb_RTD.RTD_User_ID  WHERE RTD_IDVENDOR!=''  GROUP BY NWB_ID,NWB_INT";
        $strquery = "SELECT PROJ_Symphoni_num,PROJ_Project_name,NWB_ID,NWB_INT,PROJ_Field_End,PROJ_Field_End_Adj,SUM(IF(NWB_STATUS = 'Complete',NWB_Num,0)) AS vValid,SUM(IF(NWB_STATUS = 'Cancelled',NWB_Num,0)) AS vCancel   FROM tb_NWB LEFT JOIN tb_Project_ownership ON NWB_ID = PROJ_KODENWB  WHERE PROJ_StatusFieldFinal=1  GROUP BY NWB_12digit,NWB_INT";
        $bantu01 = mysqli_query($conn, $strquery);
        if (!$bantu01) {
            echo mysqli_error($bantu01);
        }
        $bantu02 = [];
        while ($row = mysqli_fetch_assoc($bantu01)) {
            // if(datedifference($skarang,$row['PROJ_Field_End_Adj'])>=0){
            $bantu = [];
            $bantu['PROJ_Symphoni_num'] = $row['PROJ_Symphoni_num'];
            $bantu['NWB_ID'] = $row['NWB_ID'];
            $bantu['NWB_INT'] = $row['NWB_INT'];
            $bantu['PROJ_projname'] = $row['PROJ_Project_name'];
            $bantu['vValid'] = $row['vValid'];
            $bantu['vCancel'] = $row['vCancel'];
            $bantu['PROJ_Field_End_Adj'] = $row['PROJ_Field_End_Adj'];
            $bantu02[] = $bantu;
            // }
        }
        $ArrJumINTPerVendor = [];
        //$newarray = array_column($tb_vendorintv, 'RTD_IDVENDOR');
        // print_r($bantu02);
        // die();

        $masterdata = [];
        foreach ($bantu02 as $row0) {
            $idint = array_search($row0['NWB_INT'], $arr_idrtd, true);
            $bantu3 = [];
            $bantu3['id'] = $idint;
            $bantu3['NWB_INT'] = $row0['NWB_INT'];
            $bantu3['PROJ_Symphoni_num'] = $row0['PROJ_Symphoni_num'];
            $bantu3['PROJ_projname'] = $row0['PROJ_projname'];
            $bantu3['NWB_ID'] = $row0['NWB_ID'];
            $bantu3['vValid'] = $row0['vValid'];
            $bantu3['vCancel'] = $row0['vCancel'];
            if (!($idint == '')) {
                $bantu3['RTD_IDVENDOR'] = $master_rtd[$idint]['RTD_IDVENDOR'];
                $bantu3['RTD_Company_Name'] = $master_rtd[$idint]['RTD_Company_Name'];
                $bantu3['idgab_int'] = $master_rtd[$idint]['RTD_IDVENDOR'] . '#' . $row0['NWB_INT'];
                $bantu3['idgab_proj'] = $master_rtd[$idint]['RTD_IDVENDOR'] . '#' . $row0['PROJ_Symphoni_num'];
            }
            if (($idint == '')) {
                $bantu3['RTD_IDVENDOR'] = '';
                $bantu3['RTD_Company_Name'] = '';
                $bantu3['idgab_int'] = '';
                $bantu3['idgab_proj'] = '';
            }
            $masterdata[] = $bantu3;
        }

        // //TES TULIS DATA
        // $hapus="DELETE FROM CekTb_sementara";
        // $conn->query($hapus);
        // $id=0;
        // foreach ($masterdata as $row) {
        //     $sqlstr = "INSERT INTO CekTb_sementara (id, NWB_INT, PROJ_Symphoni_num, NWB_ID,RTD_IDVENDOR,RTD_Company_Name,idgab_int,idgab_proj) VALUES ('";
        //     $sqlstr=$sqlstr.$row['id'] ."','";
        //     $sqlstr=$sqlstr.$row['NWB_INT'] ."','";
        //     $sqlstr=$sqlstr.$row['PROJ_Symphoni_num']."','";
        //     $sqlstr=$sqlstr.$row['NWB_ID']."','";
        //     $sqlstr=$sqlstr.$row['RTD_IDVENDOR']."','";
        //     $sqlstr=$sqlstr.$row['RTD_Company_Name']."','";
        //     $sqlstr=$sqlstr.$row['idgab_int']."','";
        //     $sqlstr=$sqlstr.$row['idgab_proj'] ."')";
        //     print_r($sqlstr);
        //     $conn->query($sqlstr);
        // }

        // die();

        // print_r($masterdata);
        // die();
        $columns = array_column($masterdata, "idgab_proj");
        array_multisort($columns, SORT_DESC, $masterdata);
        // print_r($masterdata);

        $aruniq_vendor_int = [];
        $aruniq_vendor_proj = [];
        $ar_vendor_int = [];
        $ar_summary_vendor_int = [];
        $ar_summary_vendor_proj = [];
        $ar_uniq_vendor = [];
        $ar_uniq_vendor2 = [];
        $hitung = 0;
        $hitungporj = 0;
        foreach ($masterdata as $row) {
            if (!in_array($row['idgab_int'], $aruniq_vendor_int)) {
                $aruniq_vendor_int[] = $row['idgab_int'];
                if (!in_array($row['RTD_IDVENDOR'], $ar_uniq_vendor)) {
                    $ar_uniq_vendor[] = $row['RTD_IDVENDOR'];
                    $bantu2 = [];
                    $bantu2['RTD_IDVENDOR'] = $row['RTD_IDVENDOR'];
                    $bantu2['JUMINT'] = 1;
                    $bantu2['JUMVALID'] = $row['vValid'];
                    $bantu2['JUMCANCEL'] = $row['vCancel'];
                    $ar_summary_vendor_int[] = $bantu2;
                    $hitung = 1;
                    $hitungvalid = $row['vValid'];
                    $hitungcancel = $row['vCancel'];
                }
                if (in_array($row['RTD_IDVENDOR'], $ar_uniq_vendor)) {
                    $id = array_search($row['RTD_IDVENDOR'], $ar_uniq_vendor, true);
                    $ar_summary_vendor_int[$id]['JUMINT'] = $hitung;
                    $ar_summary_vendor_int[$id]['JUMVALID'] = $hitungvalid;
                    $ar_summary_vendor_int[$id]['JUMCANCEL'] = $hitungcancel;
                    $hitung++;
                    $hitungvalid = $hitungvalid + $row['vValid'];
                    $hitungcancel = $hitungcancel + $row['vCancel'];
                }
                // $bantu=[];
                // $bantu['RTD_IDVENDOR'] = $row['RTD_IDVENDOR'];
                // $bantu['NWB_INT'] = $row['NWB_INT'];
                // // $hitung++;
                // $ar_vendor_int[] = $bantu;
            }
            if (!in_array($row['idgab_proj'], $aruniq_vendor_proj)) {
                $aruniq_vendor_proj[] = $row['idgab_proj'];
                if (!in_array($row['RTD_IDVENDOR'], $ar_uniq_vendor2)) {
                    $ar_uniq_vendor2[] = $row['RTD_IDVENDOR'];
                    $bantu2 = [];
                    $bantu2['RTD_IDVENDOR'] = $row['RTD_IDVENDOR'];
                    $bantu2['JUMPROJ'] = 1;
                    $bantu2['JUMVALIDPROJ'] = $row['vValid'];
                    $bantu2['JUMCANCELPROJ'] = $row['vCancel'];
                    $ar_summary_vendor_proj[] = $bantu2;
                    $hitungporj = 1;
                    $hitungvalid = $row['vValid'];
                    $hitungcancel = $row['vCancel'];
                }
                if (in_array($row['RTD_IDVENDOR'], $ar_uniq_vendor2)) {
                    $id = array_search($row['RTD_IDVENDOR'], $ar_uniq_vendor2, true);
                    $ar_summary_vendor_proj[$id]['JUMPROJ'] = $hitungporj;
                    $ar_summary_vendor_proj[$id]['JUMVALIDPROJ'] = $hitungvalid;
                    $ar_summary_vendor_proj[$id]['JUMCANCELPROJ'] = $hitungcancel;
                    $hitungporj++;
                    $hitungvalid = $hitungvalid + $row['vValid'];
                    $hitungcancel = $hitungcancel + $row['vCancel'];
                }
            }
        }

        // print_r($ar_summary_vendor_int);
        // print_r($ar_summary_vendor_proj);


        $db_vendor = [];
        $jum = 0;
        $arrjumproj = array_column($ar_summary_vendor_proj, 'RTD_IDVENDOR');
        $arrjumint = array_column($ar_summary_vendor_int, 'RTD_IDVENDOR');
        // $arr_vendorid = array_column($SUMMVENDOR, 'VEN_ID');
        $idproj = -1;
        $idint = -1;
        foreach ($SUMMVENDOR as $rowvendor) {
            $idproj = array_search($rowvendor['VEN_ID'], $arrjumproj, true);
            $idint = array_search($rowvendor['VEN_ID'], $arrjumint, true);
            // $idactive = array_search($rowvendor['VEN_ID'], $id_own1, true); 
            // if($idactive!=''){
            $arbantu0 = [];
            $jum = 0;
            $arbantu0['RTD_IDVENDOR'] = $rowvendor['VEN_ID'];
            // $arbantu0['id'] = $id;
            $arbantu0['idproj'] = $idproj;
            $arbantu0['idint'] = $idint;
            $arbantu0['VEN_PIC'] = $rowvendor['VEN_PIC'];
            $arbantu0['VEN_AREA'] = $rowvendor['VEN_AREA'];
            $arbantu0['VEN_NAME'] = $rowvendor['VEN_NAME'];
            $arbantu0['VEN_PROV'] = $rowvendor['VEN_PROV'];
            $arbantu0['VEN_TELPPIC'] = $rowvendor['VEN_TELPPIC'];
            if (!($idproj == '')) {
                $arbantu0['COUNT_PROJ'] = $ar_summary_vendor_proj[$idproj]['JUMPROJ'];
                $arbantu0['JUMVALIDPROJ'] = $ar_summary_vendor_proj[$idproj]['JUMVALIDPROJ'];
                $arbantu0['JUMCANCELPROJ'] = $ar_summary_vendor_proj[$idproj]['JUMCANCELPROJ'];
            } else {
                $arbantu0['COUNT_PROJ'] = 0;
                $arbantu0['JUMVALIDPROJ'] = 0;
                $arbantu0['JUMCANCELPROJ'] = 0;
            }
            if (!($idint == '')) {
                $arbantu0['COUNT_INTV'] = $ar_summary_vendor_int[$idint]['JUMINT'];
                $arbantu0['JUMVALID'] = $ar_summary_vendor_int[$idint]['JUMVALID'];
                $arbantu0['JUMCANCEL'] = $ar_summary_vendor_int[$idint]['JUMCANCEL'];
            } else {
                $arbantu0['COUNT_INTV'] = 0;
                $arbantu0['JUMVALID'] = 0;
                $arbantu0['JUMCANCEL'] = 0;
            }

            $db_vendor[] = $arbantu0;
            // }
        }
        return $db_vendor;
    }

    public function export()
    {
        //   $rtd = $this->model_system->alldata2();

        //   echo $this->model_system->getLastQuery()->getQuery();

        // echo json_encode($this->data_before_export());

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'ID VENDOR');
        $sheet->setCellValue('C1', 'VENDOR NAME');
        $sheet->setCellValue('D1', 'PIC VENDOR');
        $sheet->setCellValue('E1', 'NO TELP');
        $sheet->setCellValue('F1', 'AREA');
        $sheet->setCellValue('G1', 'CITY');
        $sheet->setCellValue('H1', '#PROJ');
        $sheet->setCellValue('I1', '#INTV');
        $sheet->setCellValue('J1', '%DROP');

        $db_vendor = $this->data_before_export();
        $i = 0;
        $column = 2;  //column start
        foreach ($db_vendor as $key => $value) {
            $i = $i + 1;
            $sheet->setCellValue('A' . $column,  $i);
            $sheet->setCellValue('B' . $column, $value['RTD_IDVENDOR']);
            $sheet->setCellValue('C' . $column, $value['VEN_NAME']);
            $sheet->setCellValue('D' . $column, $value['VEN_PIC']);
            $sheet->setCellValue('E' . $column, $value['VEN_TELPPIC']);
            $sheet->setCellValue('F' . $column, $value['VEN_AREA']);
            $sheet->setCellValue('G' . $column, $value['VEN_PROV']);
            $sheet->setCellValue('H' . $column, "0");
            $sheet->setCellValue('I' . $column, "0");
            $sheet->setCellValue('J' . $column, "0");
            $column++;
        }
        $writer = new Xlsx($spreadsheet);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename=rtd.xlsx');
        header('Cache-Control: max-age=0');
        $writer->save('php://output');
        exit();
    }

    public function import()
    {
        $file_excel = $this->request->getFile('fileexcel');
        $ext = $file_excel->getClientExtension();
        if ($ext == 'xls') {
            $render = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
        } else {
            $render = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        }
        $spreadsheet = $render->load($file_excel);

        $data = $spreadsheet->getActiveSheet()->toArray();
        foreach ($data as $x => $row) {
            if ($x == 0) {
                continue;
            }

            $idvendor = $row[0];
            $Nama = $row[1];
            $Alamat = $row[2];

            $db = \Config\Database::connect();

            $cekId = $db->table('RTD_masterdata')->getWhere(['IDVENDOR' => $idvendor])->getResult();

            if (count($cekId) > 0) {
                session()->setFlashdata('message', '<b style="color:red">Data Gagal di Import NIS ada yang sama</b>');
            } else {

                $simpandata = [
                    'IDVENDOR' => $idvendor, 'Nama' => $Nama, 'Alamat' => $Alamat
                ];

                $db->table('RTD_masterdata')->insert($simpandata);
                session()->setFlashdata('message', 'Berhasil import excel');
            }
        }

        return redirect()->to('/home');
    }

    public function home_admin_export()
    {
        $rtd = $this->model_system->findAll();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'nwb_code');
        $sheet->setCellValue('B1', 'sym_12digit');
        $sheet->setCellValue('C1', 'proj_name');
        $sheet->setCellValue('D1', 'start_date');
        $sheet->setCellValue('E1', 'int_login');
        $sheet->setCellValue('F1', 'ach_num');

        $column = 2;  //column start
        foreach ($rtd as $key => $value) {
            // $sheet->setCellValue('A' . $column, ($column - 1));
            $sheet->setCellValue('A' . $column, $value->nwb_code);
            $sheet->setCellValue('B' . $column, $value->sym_12digit);
            $sheet->setCellValue('C' . $column, $value->proj_name);
            $sheet->setCellValue('D' . $column, $value->start_date);
            $sheet->setCellValue('E' . $column, $value->int_login);
            $sheet->setCellValue('F' . $column, $value->ach_num);
            $column++;
        }

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename=nwb.xlsx');
        header('Cache-Control: max-age=0');
        $writer->save('php://output');
        exit();
    }

    public function generatepdf()
    {

        $filename = date('y-m-d-H-i-s') . 'pdf report';

        // instantiate and use the dompdf class
        $dompdf = new \Dompdf\Dompdf();

        // load HTML content
        $dompdf->loadHtml(view('pdf_view'));

        // (optional) setup the paper size and orientation
        $dompdf->setPaper('A4', 'landscape');

        // render html as PDF
        $dompdf->render();

        // output the generated pdf
        $dompdf->stream($filename);
    }

    public function view_db_subproj()
    {
        return view('view_data_subproj');
    }

    public function adminteam()
    {
        return view('view_teamadmin');
    }

    public function view_news()
    {
        return view('view_news');
    }
    public function view_galerry_bali()
    {
        return view('view_galerryops_bali');
    }
    public function view_galerry_yogya()
    {
        return view('view_galerryops_yogya');
    }
    public function view_galerry_bromo()
    {
        return view('view_galerryops_bromo');
    }
    public function view_galerry_belitung()
    {
        return view('view_galerryops_belitung');
    }

    public function helpmaindashboard()
    {
        return view('helpmaindashboard');
    }

    public function view_db_shorten()
    {
        return view('view_shorten');
    }
    public function view_dbqc()
    {
        return view('view_databaseqc');
    }
    public function view_db_qualy()
    {
        return view('view_data_qualy');
    }
    public function view_db_qualyload()
    {
        return view('view_data_qualyload');
    }
    public function view_db_qualyload_byproj()
    {
        return view('view_data_qualyload_byproj');
    }

    public function view_db_qc()
    {
        return view('view_data_qc');
    }
    public function view_db_dp()
    {
        return view('view_data_dp');
    }
    public function view_db_dpload()
    {
        return view('view_data_dpload');
    }
    public function view_db_dpload_byproj()
    {
        return view('view_data_dpload_byproj');
    }
    public function view_db_dptype()
    {
        return view('view_data_dptype');
    }
    public function view_db_dptype_byproj()
    {
        return view('view_data_dptype_byproj');
    }
    public function view_db_dpstatus()
    {
        return view('view_data_dpstatus');
    }
    public function view_db_dpstatus_byproj()
    {
        return view('view_data_dpstatus_byproj');
    }

    public function view_db_profile()
    {
        return view('view_data_profile');
    }
    public function view_db_intv()
    {
        return view('view_data_intv');
    }
    public function view_db_intv_bydate()
    {
        return view('view_data_intv_bydate');
    }
    public function view_db_intv_bydate2()
    {
        return view('view_data_intv_bydate2');
    }
    public function view_db_intv_bydate_byintv()
    {
        return view('view_data_intv_bydate_byintv');
    }
    public function view_db_intv_bydate_byintv2()
    {
        return view('view_data_intv_bydate_byintv2');
    }
    public function view_db_subintv()
    {
        return view('view_data_subintv');
    }
    public function view_db_intv_spv()
    {
        return view('view_data_intv_spv');
    }
    public function view_db_subintv_spv()
    {
        return view('view_data_subintv_spv');
    }
    public function view_db_rtd()
    {
        return view('view_data_rtd');
    }
    public function view_db_rtd_int()
    {
        return view('view_data_rtd_int');
    }
    public function view_db_rtd_int_internal()
    {
        return view('view_data_rtd_int_internal');
    }
    public function view_db_rtd_int_vendor()
    {
        return view('view_data_rtd_int_vendor');
    }
    public function view_db_main_close()
    {
        return view('view_data_main_close');
    }
    public function view_db_rtd_int_perproj_i()
    {
        return view('view_data_rtd_int_perproj_i');
    }
    public function view_db_rtd_int_perproj_v()
    {
        return view('view_data_rtd_int_perproj_v');
    }
    public function view_db_rtd_int_proj()
    {
        return view('view_data_rtd_int_proj');
    }
    public function view_db_rtd_spv()
    {
        return view('view_data_rtd_spv');
    }
    public function view_db_rtd_vendor()
    {
        return view('view_data_rtd_vendor');
    }
    public function view_db_rtd_vendor_proj()
    {
        return view('view_data_rtd_vendor_proj');
    }
    public function view_db_rtd_vendor_int()
    {
        return view('view_data_rtd_vendor_int');
    }
    public function view_db_rtd_vendor_proj_int()
    {
        return view('view_data_rtd_vendor_proj_int');
    }
    public function view_db_rtd_vendor_int_proj()
    {
        return view('view_data_rtd_vendor_int_proj');
    }
    public function view_db_rtd_intprof()
    {
        return view('view_data_rtd_int_prof');
    }
    public function view_db_rtd_intproj()
    {
        return view('view_data_rtd_int_proj');
    }
    public function view_db_rtd_intproj1()
    {
        return view('view_data_rtd_int_proj1');
    }

    public function view_db_intv_spv_byproj()
    {
        return view('view_data_intv_spv_byproj');
    }
    public function view_db_intv_byspv()
    {
        return view('view_data_intv_byspv');
    }
    public function view_db_spv()
    {
        return view('view_data_spv');
    }
    public function view_db_quota()
    {
        return view('view_data_quota');
    }
    public function view_db_quota_admin()
    {
        return view('view_data_quota_admin');
    }
    public function view_db_quota_int()
    {
        return view('view_data_quota_int');
    }
    public function view_db_quota_int_perarea()
    {
        return view('view_data_quota_int_perarea');
    }
    public function view_db_subquota()
    {
        return view('view_data_subquota');
    }
    public function view_db_vendor()
    {
        return view('view_vendor');
    }
    public function view_db_sfm_load1()
    {
        return view('view_data_sfm_load1');
    }
    public function view_db_sfm_load0()
    {
        return view('view_data_sfm_load0');
    }
    public function view_db_sfm_load2()
    {
        return view('view_data_sfm_load2');
    }
    public function view_db_sfm_load_byproj()
    {
        return view('view_data_sfm_load_byproj');
    }

    public function view_db_spv_load()
    {
        return view('view_data_spv_load');
    }

    public function view_db_target_interviewer()
    {
        return view('view_data_target_interviewer');
    }

    public function view_db_rtd_int_backup()
    {
        return view('view_data_rtd_int_backup');
    }



    public function insert_user()
    {
        return view('insert_user');
    }
    public function importform()
    {
        return view('importform');
    }
    public function view_export()
    {
        return view('view_export');
    }


    public function signup_user()
    {
        return view('signup');
    }

    public function edit($id = null)
    {
        if ($id != null) {
            $query = $this->db->table('tb_Project_ownership')->getWhere(['PROJ_KODENWB' => $id]);
            if ($query->resultID->num_rows > 0) {
                $data['row'] = $query->getRow();
                return view('edit', $data);
            } else {
                throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
            }
        } else {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
    }

    public function update($id)
    {
        $data = $this->request->getPost();
        $data['PROJ_KODENWB'] = $id;
        // print_r($data);
        unset($data['_method']);

        $this->db->table('tb_Project_ownership')->where(['PROJ_KODENWB' => $id])->update($data);
        return redirect()->to(site_url('Home/index'))->with('success', 'Data Berhasil Di Update');
    }

    public function update_intv($id)
    {
        $data = $this->request->getPost();
        $data['int_target'] = $id;
        // print_r($data);
        unset($data['_method']);

        $this->db->table('tb_intv')->where(['int_target' => $id])->update($data);
        return redirect()->to(site_url('Home/view_db_target_interviewer'))->with('success', 'Data Berhasil Di Update');
    }
}
