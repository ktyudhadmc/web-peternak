<?php

defined('BASEPATH') or exit('No direct script access allowed');
Sentry\init(['dsn' => 'https://4dba7b441a7ff5576bdc44cf8098b987@o4504875505483776.ingest.sentry.io/4506318591950848']);
class Temperature extends CI_Controller
{


    public function __construct()
    {
        parent::__construct();
        $this->load->model('MData');
        $this->load->model('MThirdApp');
        // $this->MThirdApp->checksession();
        $this->load->library('Dummy');
    }

    public function index()
    {
        // $getdatauser = $this->MData->customresult("SELECT b.nama,a.* FROM `kandang_activity` as a left join kandang as b on a.id_kandang = b.id");
        $getdatauser = $this->MData->customresult("SELECT * FROM  kandang");
        $data = array(
            'title' => 'Temperature',
            'content' => 'temperature',
            'getdatauser' => $getdatauser,
        );
        $this->load->view('main/template', $data);
    }

    public function loaddata()
    {
        $id_kandang = $_POST['id_kandang'];
        $periode = $_POST['periode'];
        $sensor = $_POST['sensor'];
        if (isset($_POST['mindate']) && isset($_POST['maxdate'])) {
            $mindate = $_POST['mindate'];
            $maxdate = $_POST['maxdate'];
        } else {
            $mindate = "";
            $maxdate = "";
        }
        $search_periode = $this->MData->customrow("SELECT * FROM `kandang_activity` WHERE id_kandang = {$id_kandang} ORDER by created_at desc limit 1");
        $where_periode = ($periode == '') ? " and periode = '{$search_periode->periode}'" : " and periode = '{$periode}' ";



        $search_maxmin_tgl = $this->MData->customrow("SELECT max(created_at) as maxtgl, min(created_at) as mintgl FROM `logger_sensor`WHERE id_kandang = {$id_kandang} {$where_periode}");
        $ketmindate = date_format(date_create($search_maxmin_tgl->mintgl), "d M Y");
        $ketmaxdate = date_format(date_create($search_maxmin_tgl->maxtgl), "d M Y");


        $where_tgl = ($mindate != '' && $maxdate != '') ? " and created_at between '{$mindate}' and '{$maxdate}'" : "";
        $getdatakandang = $this->MData->customrow("Select * from kandang where id = {$id_kandang}");
        if ($sensor == 'temperature') {
            $getdata = $this->MData->customresult("SELECT * FROM `logger_sensor` where id_kandang = {$id_kandang} {$where_periode} {$where_tgl} ORDER BY `logger_sensor`.`created_at`  ASC");
        } else {
            $getdata = NULL;
        }
        if ($getdata == NULL) {
            $status = "gagal";
        } else {
            $status = "sukses";
        }

        // SELECT a.*, DATEDIFF(a.created_at, b.tanggal_mulai) as umur  FROM `logger_sensor` as a
        // left join kandang_activity as b on a.id_kandang = b.id_kandang and a.periode = b.periode
        // where a.id_kandang = 75 and a.periode = 2203 ORDER BY `a`.`created_at`  ASC

        // $query_filter = "SELECT tanggal, tanggal_chickin, DATEDIFF(tanggal, tanggal_chickin) as umur FROM `kandang_activity_log` WHERE id_kandang = {$id_kandang} {$where_periode}";
        // $getfilter = $this->MData->customresult($query_filter);
        // $array_getfilter = json_decode(json_encode($getfilter), true);

        // var_dump(count($array_getfilter));
        // exit;
        // for ($i = 0; $i < count($array_getfilter); $i++) {
        // }

        $result = array(
            'status' => $status,
            'data' => $getdata,
            'namakandang' => $getdatakandang->nama,
            'mindate' => $search_maxmin_tgl->mintgl,
            'maxdate' => $search_maxmin_tgl->maxtgl,
            'ketmindate' => $ketmindate,
            'ketmaxdate' => $ketmaxdate,
            // 'SQL' => "SELECT * FROM `logger_sensor` where id_kandang = {$id_kandang} {$where_periode} {$where_tgl} ORDER BY `logger_sensor`.`created_at`  ASC",
        );

        echo json_encode($result);
    }
    public function loaddata_water()
    {
        $id_kandang = $_POST['id_kandang'];
        $periode = $_POST['periode'];
        $sensor = $_POST['sensor'];
        $data_water = [];
        if (isset($_POST['mindate']) && isset($_POST['maxdate'])) {
            $mindate = $_POST['mindate'];
            $maxdate = $_POST['maxdate'];
        } else {
            $mindate = "";
            $maxdate = "";
        }
        $search_periode = $this->MData->customrow("SELECT * FROM `kandang_activity` WHERE id_kandang = {$id_kandang} ORDER by created_at desc limit 1");
        $where_periode = ($periode == '') ? " and periode = '{$search_periode->periode}'" : " and periode = '{$periode}' ";



        $search_maxmin_tgl = $this->MData->customrow("SELECT max(created_at) as maxtgl, min(created_at) as mintgl FROM `logger_sensor`WHERE id_kandang = {$id_kandang} {$where_periode}");
        $ketmindate = date_format(date_create($search_maxmin_tgl->mintgl), "d M Y");
        $ketmaxdate = date_format(date_create($search_maxmin_tgl->maxtgl), "d M Y");


        $where_tgl = ($mindate != '' && $maxdate != '') ? " and created_at between '{$mindate}' and '{$maxdate}'" : "";
        $getdatakandang = $this->MData->customrow("Select * from kandang where id = {$id_kandang}");
        if ($sensor == 'temperature') {
            $getdata = $this->MData->customresult("SELECT * FROM `logger_sensor` where id_kandang = {$id_kandang} {$where_periode} {$where_tgl} ORDER BY `logger_sensor`.`created_at`  ASC");
        } else {
            $getdata = NULL;
        }
        if ($getdata == NULL) {
            $status = "gagal";
        } else {
            $status = "sukses";
        }

        if (is_array($getdata) || is_object($getdata)) {
            $tot_water = 0;
            for ($i = 0; $i < count($getdata); $i++) {
                $a = $i + 1;
                if ($a >= count($getdata)) {
                    $water_level = 0;
                } else {
                    $water_level = ($getdata[$a]->water) - ($getdata[$i]->water);
                    if ($water_level < 0) {
                        $water_level = 0;
                    }
                }
                $tot_water = $tot_water + $water_level;
                $data_water[] = array(
                    'water' => $water_level,
                    'created_at' => $getdata[$i]->created_at,
                );
            }
        }

        $result = array(
            'status' => $status,
            'data' => $data_water,
            'data_water' => $tot_water,
            'namakandang' => $getdatakandang->nama,
            'mindate' => $search_maxmin_tgl->mintgl,
            'maxdate' => $search_maxmin_tgl->maxtgl,
            'ketmindate' => $ketmindate,
            'ketmaxdate' => $ketmaxdate,
            // 'SQL' => "SELECT * FROM `logger_sensor` where id_kandang = {$id_kandang} {$where_periode} {$where_tgl} ORDER BY `logger_sensor`.`created_at`  ASC",
        );

        echo json_encode($result);
    }
    public function loaddata_weighing()
    {
        $id_kandang = $_POST['id_kandang'];
        $periode = $_POST['periode'];
        $sensor = $_POST['sensor'];
        if (isset($_POST['mindate']) && isset($_POST['maxdate'])) {
            $mindate = $_POST['mindate'];
            $maxdate = $_POST['maxdate'];
        } else {
            $mindate = "";
            $maxdate = "";
        }
        $search_periode = $this->MData->customrow("SELECT * FROM `kandang_activity` WHERE id_kandang = {$id_kandang} ORDER by created_at desc limit 1");
        $where_periode = ($periode == '') ? " and periode = '{$search_periode->periode}'" : " and periode = '{$periode}' ";



        $search_maxmin_tgl = $this->MData->customrow("SELECT max(created_at) as maxtgl, min(created_at) as mintgl FROM `logger_sensor`WHERE id_kandang = {$id_kandang} {$where_periode}");
        $ketmindate = date_format(date_create($search_maxmin_tgl->mintgl), "d M Y");
        $ketmaxdate = date_format(date_create($search_maxmin_tgl->maxtgl), "d M Y");


        $where_tgl = ($mindate != '' && $maxdate != '') ? " and created_at between '{$mindate}' and '{$maxdate}'" : "";
        $getdatakandang = $this->MData->customrow("Select * from kandang where id = {$id_kandang}");
        if ($sensor == 'weighing') {
            $getdata = $this->MData->customresult("SELECT * FROM `logger_sensor` where id_kandang = {$id_kandang} {$where_periode} and bw > 0 {$where_tgl} ORDER BY `logger_sensor`.`created_at`  ASC");
        } else {
            $getdata = NULL;
        }
        if ($getdata == NULL) {
            $status = "gagal";
        } else {
            $status = "sukses";
        }

        // SELECT a.*, DATEDIFF(a.created_at, b.tanggal_mulai) as umur  FROM `logger_sensor` as a
        // left join kandang_activity as b on a.id_kandang = b.id_kandang and a.periode = b.periode
        // where a.id_kandang = 75 and a.periode = 2203 ORDER BY `a`.`created_at`  ASC

        // $query_filter = "SELECT tanggal, tanggal_chickin, DATEDIFF(tanggal, tanggal_chickin) as umur FROM `kandang_activity_log` WHERE id_kandang = {$id_kandang} {$where_periode}";
        // $getfilter = $this->MData->customresult($query_filter);
        // $array_getfilter = json_decode(json_encode($getfilter), true);

        // var_dump(count($array_getfilter));
        // exit;
        // for ($i = 0; $i < count($array_getfilter); $i++) {
        // }

        $result = array(
            'status' => $status,
            'data' => $getdata,
            'namakandang' => $getdatakandang->nama,
            'mindate' => $search_maxmin_tgl->mintgl,
            'maxdate' => $search_maxmin_tgl->maxtgl,
            'ketmindate' => $ketmindate,
            'ketmaxdate' => $ketmaxdate,
            // 'SQL' => "SELECT * FROM `logger_sensor` where id_kandang = {$id_kandang} {$where_periode} {$where_tgl} ORDER BY `logger_sensor`.`created_at`  ASC",
        );

        echo json_encode($result);
    }
}
