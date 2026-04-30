<?php

defined('BASEPATH') or exit('No direct script access allowed');
Sentry\init(['dsn' => 'https://4dba7b441a7ff5576bdc44cf8098b987@o4504875505483776.ingest.sentry.io/4506318591950848']);
class Kandang_profil extends CI_Controller
{

    public $cookiex;
    public function __construct()
    {
        parent::__construct();
        $this->load->model('MData');
        $this->load->model('MThirdApp');
        $this->MThirdApp->checksession();
        $this->load->library('Dummy');
        $this->cookiex = getcookienya('user_data');
    }

    public function index()
    {
        $id_user = $this->cookiex['user_id'];
        $role = $this->cookiex['role'];
        // if ($role == '1') {
        //   $getdatauser = $this->MData->customresult("SELECT a.user_id as id, b.first_name FROM `kandang` as a LEFT JOIN users as b on b.id = a.user_id group by user_id ORDER BY `id` ASC");
        // } else {
        //   $getdatauser = $this->MData->customresult("SELECT c.first_name , c.id FROM `users` as a left join kandang as b on FIND_IN_SET(a.id, b.user_id_sharing) and b.status_kandang not in ('DELETE') left join users as c on b.user_id = c.id where a.id = '{$id_user}' GROUP by c.id ORDER BY `nama`,b.nama ASC");
        // }
        $getdatauser = $this->MThirdApp->listkandang($id_user);
        if (is_array($getdatauser) || is_object($getdatauser)) {
            $lastdata = 0;
            $data = array();
            foreach ($getdatauser as $getdatausers) {
                if ($lastdata == $getdatausers->nama_user) {
                    $data[] = $getdatausers->id_kandang;
                } else {
                    $result[] = array(
                        "nama_user" => $lastdata,
                        "id_kandang" => $data,
                    );
                    $data = array();
                    $data[] = $getdatausers->id_kandang;
                }
                $lastdata = $getdatausers->nama_user;
            }
        }
        $data = array(
            'title' => 'Profil Kandang',
            'content' => 'kandang_profil',
            // 'getdatauser' => $getdatauser,
            'getdatauser' => (object)$result,
            'session2' => $this->cookiex['role'],
        );
        $this->load->view('main/template', $data);
    }
    public function get_data_kandang_profil()
    {
        $id_user = $_POST['id_user'];
        $id_user_value = implode(",", $id_user);
        $querykandangprofil =
            "SELECT
        *
        FROM kandang as a
        LEFT JOIN kandang_profil as b ON a.id = b.id_kandang
        where a.id in ({$id_user_value})";
        $datakandangprofil = $this->MData->customresult($querykandangprofil);
        echo json_encode($datakandangprofil);
    }
}
