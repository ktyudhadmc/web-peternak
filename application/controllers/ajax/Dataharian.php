<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Dataharian extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('MData');
        $this->load->model('MThirdApp');
        $this->load->model('MSql');
    }

    //Menampilkan data ternak
    function index()
    {
        if ($this->input->post()) {
            $tokenstatus = $this->MThirdApp->validatetoken();
            if ($tokenstatus['status']) {
                $this->view_dataharian();
            } else {
                echo json_encode(['status' => FALSE, 'message' => 'Wrong Token']);
            }
        } else {
            echo json_encode(['status' => FALSE, 'message' => 'Wrong Page']);
        }
    }
    function view_dataharian()
    {
        // Protector Jika URL Lebih dari 3 maka di tolak
        if (count($this->uri->segment_array()) < 3) {
            if ($this->input->post('kandangperiode')) {
                $kandangperiode = explode("|", $this->input->post('kandangperiode'));
                $idkandang = $kandangperiode[0];
                $periode = $kandangperiode[1];
                $this->load->view('main/content/ternak_detail_dataharian.php');
            }
        } else {
            echo json_encode(['status' => FALSE, 'message' => 'Wrong Page']);
        }
    }
    public function dataharian()
    {
        if ($this->input->post()) {
            if ($this->input->post('token')) {
                $validatetoken = $this->MThirdApp->validateToken($this->input->post('token'));
                if ($validatetoken['status']) {
                    $kandangperiode = explode("|", $this->input->post('kandangperiode'));
                    $idkandang = $kandangperiode[0];
                    $periode = $kandangperiode[1];
                    $getactivitydetail = $this->MData->customrow("SELECT * FROM kandang_activity where id_kandang = '{$idkandang}' AND periode ='{$periode}' ORDER BY created_at DESC");
                    $getdataharian = $this->getdataharian($idkandang, $periode, $getactivitydetail->strain);
                    echo json_encode($getdataharian);
                } else {
                    echo json_encode(['status' => 'error', 'message' => 'Token Salah']);
                }
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Token Kosong']);
            }
        } else {
            //
            echo json_encode(['status' => 'error', 'message' => 'Invalid token']);
        }
    }
    public function getdataharian($idkandang, $periode = NULL, $strain)
    {
        $panen_kg = "IFNULL((SELECT round(sum(tot_kg) - sum(beratkeranjang) - sum(susut),3) as kg from (SELECT aaa.susut, aaa.beratkeranjang, sum(aaa.qty_kg) as tot_kg, tanggal  FROM `kandang_activity_log_panen` as aaa where aaa.id_kandang = {$idkandang} and aaa.periode = '{$periode}'  GROUP by aaa.nomorDO) as tot where tot.tanggal <= a.tanggal),0)";
        $panen_ekor = "IFNULL((SELECT sum(qty_ekor) FROM `kandang_activity_log_panen` WHERE id_kandang = a.id_kandang and periode = a.periode and tanggal <= a.tanggal),0)";
        $populasi = "((SELECT populasi_awal from kandang_activity WHERE id_kandang = a.id_kandang and periode = a.periode) - IFNULL((SELECT sum(total_mati) FROM `kandang_activity_log` WHERE id_kandang = a.id_kandang and periode = a.periode and tanggal <= a.tanggal),0) - {$panen_ekor})";
        $tot_feed = "((SELECT sum(qty) from kandang_activity_log_sapronak WHERE id_kandang = a.id_kandang and periode = a.periode and type_sapronak = 'pakan' and method_sapronak = 'use' and tanggal_kandang_activity_log = a.tanggal))";
        $tot_feed_fcr = "((SELECT sum(qty) from kandang_activity_log_sapronak WHERE id_kandang = a.id_kandang and periode = a.periode and type_sapronak = 'pakan' and method_sapronak = 'use' and tanggal_kandang_activity_log <= a.tanggal))";
        $std_bw_0_harian = "(SELECT bw FROM `std_bw` where strain = '{$strain}' AND day = 0)";
        $act_bw_0_harian = "(SELECT bw FROM `kandang_activity_log` where id_kandang = '{$idkandang}' AND periode = '{$periode}' AND tanggal = tanggal_chickin)";

        $act_fcr = "IFNULL(round({$tot_feed_fcr} * 50000 / (({$populasi} * a.bw) + ({$panen_kg} *1000)) ,3), 0) ";
        $std_fcr = "IFNULL(round(b.fcr,3), 0) ";
        $diff_fcr = "IFNULL(round((({$act_fcr} / {$std_fcr}) - 1) * 100,2),0) ";
        $getdataharian_query = "SELECT
              a.id,
              DATEDIFF(a.tanggal, a.tanggal_chickin) as umur,
              a.tanggal,
              a.bw,
              a.mati,
              a.culling,
              a.water,
              a.cv,
              a.uniformity,
              a.total_mati,
              d.populasi_awal,
              ({$populasi}) as populasi,
              ({$tot_feed}) as qty_feed,
              IFNULL(round({$tot_feed_fcr} * 50000 / ({$populasi} + {$panen_ekor}) / a.bw,3), 0) as act_fcr_lama,
              {$act_fcr} as act_fcr,
              {$std_fcr} as std_fcr,
              {$diff_fcr} as diff_fcr,
              IFNULL(round({$tot_feed} * 50000 / {$populasi},3), 0) as act_feed_intake,
              IFNULL(round(c.feedintake,3), 0) as std_feed_intake,
              IFNULL(round(a.bw / DATEDIFF(a.tanggal, a.tanggal_chickin)), 0) as act_adg,
              IF(a.total_mati >= round(d.populasi_awal * 0.003 ,0),a.total_mati,NULL) as ews_mati,
              IF({$act_bw_0_harian}<{$std_bw_0_harian}, round(({$act_bw_0_harian} / {$std_bw_0_harian} * c.bw),0), c.bw) as std_bw,
              IFNULL(round(IF({$act_bw_0_harian}<{$std_bw_0_harian}, round(({$act_bw_0_harian} / {$std_bw_0_harian} * c.bw),0), c.bw)/DATEDIFF(a.tanggal, a.tanggal_chickin),2), 0) as std_adg,
              IFNULL((SELECT ket from kandang_activity_log_ews where type_ews = 'mati' and id_kandang = a.id_kandang and periode = a.periode and tanggal = a.tanggal ORDER by id desc limit 1),NULL) as ket_ews_mati,
              IFNULL((SELECT ket from kandang_activity_log_ews where type_ews = 'bw' and id_kandang = a.id_kandang and periode = a.periode and tanggal = a.tanggal ORDER by id desc limit 1),NULL) as ket_ews_bw,
              IFNULL((SELECT id from kandang_activity_log_ews where type_ews = 'mati' and id_kandang = a.id_kandang and periode = a.periode and tanggal = a.tanggal ORDER by id desc limit 1),NULL) as id_ews_mati,
              IFNULL((SELECT id from kandang_activity_log_ews where type_ews = 'bw' and id_kandang = a.id_kandang and periode = a.periode and tanggal = a.tanggal ORDER by id desc limit 1),NULL) as id_ews_bw
              FROM `kandang_activity_log` as a
              LEFT JOIN (SELECT * from std where strain = '{$strain}') as b on b.bw = a.bw
              LEFT JOIN (SELECT * from std_bw WHERE strain = '{$strain}') as c on c.day = DATEDIFF(a.tanggal, a.tanggal_chickin)
              LEFT JOIN kandang_activity as d on d.periode = a.periode and d.id_kandang = a.id_kandang
              WHERE a.id_kandang = '{$idkandang}' AND a.periode = '{$periode}' ORDER BY a.tanggal DESC";
        $getdataharian = $this->MData->customresult($getdataharian_query);
        return $getdataharian;
    }
    public function getdataharianmain()
    {
        $kandangperiode = explode("|", $this->input->post('kandangperiode'));
        $idkandang = $kandangperiode[0];
        $periode = $kandangperiode[1];
        $getactivitydetail = $this->MData->customrow("SELECT * FROM kandang_activity where id_kandang = '{$idkandang}' AND periode ='{$periode}' ORDER BY created_at DESC");
        $getdataharian = $this->getdataharian($idkandang, $periode, $getactivitydetail->strain);
        echo json_encode($getdataharian);
    }
}

/* End of file Sapronak.php */
