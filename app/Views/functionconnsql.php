<?php
$conn = mysqli_connect("localhost", "root", "", "webopsid_webops_db");

$tgl = date('l, d-M-Y');




//$username = $this->input->post('username');
//$password = $this->input->post('password');

//$users = $this->db->get_where('users', ['username' => $username])->row_array();

//$data['users']=$this->db->get_where('users',['username'=>$this-session->userdata('username')])->row_array();
//var_dump($data);


/*$users = $this->db->get_where('users', ['username' => $username])->row_array();
$data = [
    'username' => $users['username'],
    'role_id' => $users['role_id'],
];

//$name = $session->get($id_role);
$this->session->set_userdata($data);
var_dump($users);
if($users['role_id'] == 3)
{
	$resultDashboard=mysqli_query($conn,"SELECT * FROM tb_main_dashboard_rev WHERE role_id LIKE 3") ;
	redirect('Welcome/index');
}*/


function hitung_umur($tanggal_lahir)
{
    $birthDate = new DateTime($tanggal_lahir);
    $today = new DateTime("today");
    if ($birthDate > $today) {
        exit("0 tahun 0 bulan 0 hari");
    }
    $y = $today->diff($birthDate)->y;
    $m = $today->diff($birthDate)->m;
    $d = $today->diff($birthDate)->d;
    //return $y." tahun ".$m." bulan ".$d." hari";
    return $m * 30 + ($d + 1);
}



function query($query)
{
    global $conn;
    $conn = mysqli_connect("localhost", "root", "", "webopsid_webops_db");
    $result = mysqli_query($conn, $query);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    return $rows;
}

//$this->$session->get($id_role);

//  function user_login(){
//         $role_id = $this->session->userdata('role_id');
//         $role_data = $this->session->get($role_id)->row();
//         return $role_data;
//     }

//$resultDashboard = $conn->query('SELECT * FROM tb_main_dashboard_rev')->where('role_id',3);

//$resultDashboard=$db->query('SELECT name, title, email FROM my_table');
//$resultDashboard=mysqli_query($conn,"SELECT * FROM tb_main_dashboard_rev WHERE PROJECT_NAME_DB LIKE 'Swim'");


/*
$data = [
    'username' => $users['username'],
    'role_id' => $users['role_id'],
];
$this->session->set_userdata($data);
if($users['role_id'] == 3){
$resultDashboard=mysqli_query($conn,"SELECT * FROM tb_main_dashboard_rev WHERE roleId=1") ;
}
*/


$resultDashboard = mysqli_query($conn, "SELECT * FROM tb_main_dashboard_rev WHERE Interv_Active_DB>0 && Sample_PR>0");

/*$resultProgRpt=mysqli_query($conn,"SELECT SymphonyNumber as JB,Project as Proj,Sample as sample, Hasil_QC as QC,
round(Achievement/Sample,0)*100 as Ach_PCT, Time_PCT as FW_Day_PCT,round((Achievement/Sample*100)/Time_PCT,0)*100 as index_FW,IntvActive as Intv_act,
Sample as SAMPLE,NmPROJECT,StartDate,EndDate,Method,PIC_CS,PIC_FIELD,PIC_QC,Sample_ver_QC,QC_SIZE,Stat_Proj,Visit_TOT,
Visit_OK,Ph_TOT,Ph_OK,Elec_TOT,Elec_OK,Wtn_TOT,Wtn_OK,OTS_TOT,OTS_OK,Hasil_QC,REMARK,Stat_QC

 FROM (progressreport_db LEFT JOIN qc_db ON progressreport_db.SymphonyNumber = qc_db.SymphonyCode) 
 LEFT JOIN  intvw_active_db ON progressreport_db.SymphonyNumber = intvw_active_db.SymphonyProj
  WHERE Sample>0") ;*/

// $resultQC = mysqli_query($conn, "SELECT * FROM qc_db");

//$resultProgRpt2=mysqli_query($conn,"SELECT * FROM progressreport_db") ;
// $resultQC = mysqli_query($conn, "SELECT * FROM qc_db");

//var_dump($resultDashboard);
//$rowProgres = mysqli_fetch_assoc($resultProgRpt);

/*
if (!$rowProgres) {
	die ('Gagal terhubung MySQL: ' . mysqli_connect_error());	
}
if (!$resultQC) {
	die ('Gagal terhubung MySQL: ' . mysqli_connect_error());	
}
*/


//$ddd=hitung_umur("0000-00-00");
//var_dump($ddd);

function hitung_usia($tgl_lahir)
{

    // ubah ke format Ke Date Time
    $lahir = new DateTime($tgl_lahir);
    $hari_ini = new DateTime();

    $diff = $hari_ini->diff($lahir);

    // Display
    echo "Tanggal Lahir: " . date('d M Y', strtotime($tgl_lahir)) . '<br />';
    echo "Umur: " . $diff->y . " Tahun";
    echo " " . $diff->m . " Bulan";
    echo " " . $diff->d . " Hari";
}

function editData($data)
{
    global $conn;
    $id = $data['PROF_ID10DGT'];
    $fwstart = $data['PROJ_Field_start'];
    $fwend = $data['PROJ_Field_End'];
    $protarget = $data['PROJ_Target'];

    print_r($id);
    print_r($fwstart);
    print_r($fwend);
    print_r($protarget);
    exit();

    mysqli_query($conn, "UPDATE tb_Project_ownership SET
  PROJ_Field_start = '$fwstart',
  PROJ_Field_End = '$fwend',
  PROJ_Target = '$protarget'
  
  WHERE PROF_ID10DGT = $id
  
  ");
    return mysqli_affected_rows($conn);
}
