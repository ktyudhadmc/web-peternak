<?php

defined('BASEPATH') or exit('No direct script access allowed');
Sentry\init(['dsn' => 'https://4dba7b441a7ff5576bdc44cf8098b987@o4504875505483776.ingest.sentry.io/4506318591950848']);
class Ews extends CI_Controller
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
        $getdatauser = $this->MData->customresult("SELECT b.nama,a.* FROM `kandang_activity` as a left join kandang as b on a.id_kandang = b.id ORDER BY `b`.`nama` ASC, a.tanggal_mulai DESC");
        $data = array(
            'title' => 'EWS',
            'content' => 'ews',
            'getdatauser' => $getdatauser,
        );
        $this->load->view('main/template', $data);
    }
    public function get_data_warning()
    {
        $querywarning = "SELECT
    a.*,b.nama,DATEDIFF(a.tanggal, c.tanggal_mulai) as umur, c.tanggal_mulai FROM `kandang_activity_log_ews`  as a
    LEFT join kandang as b on a.id_kandang = b.id
    LEFT join kandang_activity as c on a.id_kandang = c.id_kandang and a.periode = c.periode
    ORDER BY a.`tanggal` DESC";
        $getdatawarning = $this->MData->customresult($querywarning);
        echo json_encode($getdatawarning);
    }
    public function get_data_warning_lokasi()
    {
        $ews = array();
        $id_kandang_activity = $_POST['id'];
        for ($i = 0; $i < count($id_kandang_activity); $i++) {
            $data = $this->get_data_warning_lokasi_fun($id_kandang_activity[$i]);
            $ews = array_merge($ews, $data);
            // $ews[] = $data;
        }
        echo json_encode($ews);
    }
    public function get_data_warning_lokasi_fun($id_kandang_activity)
    {

        // $id_kandang_activity = $_POST['id'];
        // for ($i = 0; $i < count($id_kandang_activity); $i++) {


        // $getactivitydetail = $this->MData->customrow("SELECT * FROM kandang_activity where id_kandang = '{$idkandang}' AND periode ='{$periode}' ORDER BY created_at DESC");
        $getactivitydetail = $this->MData->customrow("SELECT * FROM kandang_activity where id = '{$id_kandang_activity}' ORDER BY created_at DESC");
        // $idkandang = $_POST['lokasi'];
        // $periode  = $_POST['periode'];
        $idkandang = $getactivitydetail->id_kandang;
        $periode  = $getactivitydetail->periode;
        $std_bw_0_harian = "(SELECT bw FROM `std_bw` where strain = '{$getactivitydetail->strain}' AND day = 0)";
        $act_bw_0_harian = "(SELECT bw FROM `kandang_activity_log` where id_kandang = '{$idkandang}' AND periode = '{$periode}' AND tanggal = tanggal_chickin)";
        $queryrdataharian = "SELECT
    a.id,
    DATEDIFF(a.tanggal, a.tanggal_chickin) as umur,
    a.tanggal,
    a.bw,
    a.mati,
    a.culling,
    a.total_mati,
    e.alamat as lokasi,
    e.nama as farm,
    e.user_id,
    d.populasi_awal,
    {$act_bw_0_harian} as bw_0,
     IF(a.total_mati >= round(d.populasi_awal * 0.003 ,0),a.total_mati,NULL) as ews_mati,
    IF({$act_bw_0_harian}<{$std_bw_0_harian}, round(({$act_bw_0_harian} / {$std_bw_0_harian} * c.bw),0), c.bw) as std_bw,
    IFNULL((SELECT ket from kandang_activity_log_ews where type_ews = 'mati' and id_kandang = a.id_kandang and periode = a.periode and tanggal = a.tanggal ORDER by id desc limit 1),NULL) as ket_ews_mati,
    IFNULL((SELECT ket from kandang_activity_log_ews where type_ews = 'bw' and id_kandang = a.id_kandang and periode = a.periode and tanggal = a.tanggal ORDER by id desc limit 1),NULL) as ket_ews_bw,
    IFNULL((SELECT id from kandang_activity_log_ews where type_ews = 'mati' and id_kandang = a.id_kandang and periode = a.periode and tanggal = a.tanggal ORDER by id desc limit 1),NULL) as id_ews_mati,
    IFNULL((SELECT id from kandang_activity_log_ews where type_ews = 'bw' and id_kandang = a.id_kandang and periode = a.periode and tanggal = a.tanggal ORDER by id desc limit 1),NULL) as id_ews_bw
    FROM `kandang_activity_log` as a
    LEFT JOIN (SELECT * from std where strain = '{$getactivitydetail->strain}') as b on b.bw = a.bw
    LEFT JOIN (SELECT * from std_bw WHERE strain = '{$getactivitydetail->strain}') as c on c.day = DATEDIFF(a.tanggal, a.tanggal_chickin)
    LEFT JOIN kandang_activity as d on d.periode = a.periode and d.id_kandang = a.id_kandang
    LEFT JOIN kandang as e on e.id = a.id_kandang
    WHERE a.id_kandang = '{$idkandang}' AND a.periode = '{$periode}' ORDER BY a.tanggal DESC";
        $getdataharian = $this->MData->customresult($queryrdataharian);
        if (is_array($getdataharian) || is_object($getdataharian)) {
            $std = 0;
            $ews = array();
            $data_harian_bw = $getdataharian;
            // function cmp($a, $b) 
            // {
            //     return strcmp($a->tanggal, $b->tanggal);
            // }
            // $data_sort_bw = $this->sortdata($data_harian_bw);
            // usort($data_harian_bw, "cmp");
            // usort($data_harian_bw, $this->cmp());
            usort($data_harian_bw, function ($a, $b) {
                return strcmp($a->tanggal, $b->tanggal);
            });
            foreach ($data_harian_bw as $data_harian_bws) {
                // foreach ($data_sort_bw as $data_harian_bws) {
                foreach ($data_harian_bw as $v) {
                    $map[$v->umur] = abs($data_harian_bws->bw - $v->std_bw);
                }

                $msg = array_search(min($map), $map);
                if ($data_harian_bws->umur >= 7 && $data_harian_bws->umur <= 35) {
                    if ($data_harian_bws->umur - $msg > $std) {
                        $ket = $data_harian_bws->umur - $msg;
                    } else {
                        $ket = NULL;
                    }
                    $std = $data_harian_bws->umur - $msg;
                } else {
                    $ket = NULL;
                }
                if ($ket) {
                    $ews[] = array(
                        'nama' => $data_harian_bws->farm,
                        'periode' => $periode,
                        'umur' => $data_harian_bws->umur,
                        'type_ews' => 'bw',
                        'tanggal' => $data_harian_bws->tanggal,
                        'nilai' => $ket,
                        'ket' => $data_harian_bws->ket_ews_bw,
                    );
                }
                if ($data_harian_bws->ews_mati) {
                    $ews[] = array(
                        'nama' => $data_harian_bws->farm,
                        'periode' => $periode,
                        'umur' => $data_harian_bws->umur,
                        'type_ews' => 'mati',
                        'tanggal' => $data_harian_bws->tanggal,
                        'nilai' => $data_harian_bws->ews_mati,
                        'ket' => $data_harian_bws->ket_ews_mati,
                    );
                }
            }
        }
        // }
        // echo json_encode($ews);
        return $ews;
    }
    public function sortdata($data)
    {
        function cmp($a, $b)
        {
            return strcmp($a->tanggal, $b->tanggal);
        }
        return usort($data, "cmp");
    }
    public function cmp($a, $b)
    {
        return strcmp($a->tanggal, $b->tanggal);
    }
}
