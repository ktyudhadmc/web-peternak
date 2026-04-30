<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Ternak2 extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('MThirdApp');
        $this->load->model('MData');
        $this->load->model('MSql');
        // $this->MThirdApp->checksession();
    }
    public function dataharian()
    {
        if ($this->input->post()) {
            // if ($this->input->post('token')) {
            //     $validatetoken = $this->MThirdApp->validateToken($this->input->post('token'));
            // if ($validatetoken['status']) {
            $kandangperiode = explode("|", $this->input->post('kandangperiode'));
            $idkandang = $kandangperiode[0];
            $periode = $kandangperiode[1];
            $getactivitydetail = $this->MData->customrow("SELECT * FROM kandang_activity where id_kandang = '{$idkandang}' AND periode ='{$periode}' ORDER BY created_at DESC");
            $getdataharian = $this->getdataharian($idkandang, $periode, $getactivitydetail->strain);
            echo json_encode($getdataharian);
            // } else {
            //     echo "token salah";
            // }
            // }
        } else {
            //
            echo json_encode(['status' => 'error', 'message' => 'Invalid token']);
        }
    }
    function getdataharian($idkandang, $periode = NULL, $strain)
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
              DATEDIFF(a.tanggal, d.tanggal_mulai) as umur,
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
        //   echo $getdataharian_query;exit;
        $getdataharian = $this->MData->customresult($getdataharian_query);
        return $getdataharian;
    }

    function getdoctable()
    {
        $tokenstatus = $this->MThirdApp->validatetoken();
        if ($tokenstatus['status']) {
            $kandangperiode = explode("|", $this->input->post('kandangperiode'));
            $idkandang = $kandangperiode[0];
            $periode = $kandangperiode[1];
            $getactivitydetail_join = $this->MData->customresult("SELECT *, populasi_awal*harga_doc as harga_tot FROM kandang_activity LEFT JOIN kandang ON kandang.id = kandang_activity.id_kandang where id_kandang = '{$idkandang}' AND periode ='{$periode}' ORDER BY kandang_activity.created_at DESC");
            echo json_encode($getactivitydetail_join);
        } else {
            echo json_encode(['status' => FALSE, 'message' => 'Wrong Token']);
        }
    }
    public function dataresumetop()
    {
        if ($this->input->post()) {
            if ($this->input->post('token')) {
                $validatetoken = $this->MThirdApp->validateToken($this->input->post('token'));
                if ($validatetoken['status']) {
                    $kandangperiode = explode("|", $this->input->post('kandangperiode'));
                    $idkandang = $kandangperiode[0];
                    $periode = $kandangperiode[1];
                    $getdataharian = $this->getactivitydetail_join($idkandang, $periode);
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
    public function dataharianpakan()
    {
        if ($this->input->post()) {
            // if ($this->input->post('token')) {
            //     $validatetoken = $this->MThirdApp->validateToken($this->input->post('token'));
            // if ($validatetoken['status']) {
            $kandangperiode = explode("|", $this->input->post('kandangperiode'));
            $idkandang = $kandangperiode[0];
            $periode = $kandangperiode[1];
            $getdataharianpakan_query = "SELECT
                                            a.tanggal_kandang_activity_log as tanggal,
                                            DATEDIFF(a.tanggal_kandang_activity_log, c.tanggal_mulai) as umur,
                                            a.harga, a.qty, b.brand as jenis, a.id, round(a.harga*a.qty,0) as harga_tot
                                            FROM `kandang_activity_log_sapronak` as a
                                            LEFT JOIN pakan as b on a.id_this = b.id
                                            LEFT JOIN kandang_activity as c on a.id_kandang = c.id_kandang and a.periode = c.periode
                                            WHERE type_sapronak = 'pakan' and method_sapronak = 'use' and a.id_kandang = '{$idkandang}' AND a.periode = '{$periode}' ORDER BY a.tanggal_kandang_activity_log DESC";
            $getdataharianpakan = $this->MData->customresult($getdataharianpakan_query);
            echo json_encode($getdataharianpakan);
            //     } else {
            //         echo json_encode(['status' => 'error', 'message' => 'Token Salah']);
            //     }
            // } else {
            //     echo json_encode(['status' => 'error', 'message' => 'Token Kosong']);
            // }
        } else {
            //
            echo json_encode(['status' => 'error', 'message' => 'Invalid token']);
        }
    }
    public function dataharianovk()
    {
        if ($this->input->post()) {
            // if ($this->input->post('token')) {
            //     $validatetoken = $this->MThirdApp->validateToken($this->input->post('token'));
            //     if ($validatetoken['status']) {
            $kandangperiode = explode("|", $this->input->post('kandangperiode'));
            $idkandang = $kandangperiode[0];
            $periode = $kandangperiode[1];
            $getdataharianovk_query = "SELECT
                                                a.tanggal_kandang_activity_log as tanggal,
                                                DATEDIFF(a.tanggal_kandang_activity_log, c.tanggal_mulai) as umur,
                                                a.harga, a.qty, b.brand as jenis, a.id, round(a.harga*a.qty,0) as harga_tot
                                                FROM `kandang_activity_log_sapronak` as a
                                                LEFT JOIN obat as b on a.id_this = b.id
                                                LEFT JOIN kandang_activity as c on a.id_kandang = c.id_kandang and a.periode = c.periode
                                                WHERE type_sapronak = 'ovk' and method_sapronak = 'use' and a.id_kandang = '{$idkandang}' AND a.periode = '{$periode}' ORDER BY a.tanggal_kandang_activity_log DESC";
            $getdataharianovk = $this->MData->customresult($getdataharianovk_query);
            echo json_encode($getdataharianovk);
            //     } else {
            //         echo json_encode(['status' => 'error', 'message' => 'Token Salah']);
            //     }
            // } else {
            //     echo json_encode(['status' => 'error', 'message' => 'Token Kosong']);
            // }
        } else {
            //
            echo json_encode(['status' => 'error', 'message' => 'Invalid token']);
        }
    }
    public function datahariangeneral()
    {
        if ($this->input->post()) {
            // if ($this->input->post('token')) {
            //     $validatetoken = $this->MThirdApp->validateToken($this->input->post('token'));
            //     if ($validatetoken['status']) {
            $kandangperiode = explode("|", $this->input->post('kandangperiode'));
            $idkandang = $kandangperiode[0];
            $periode = $kandangperiode[1];
            $getdatahariangeneral_query = "SELECT
                                                    a.tanggal_kandang_activity_log as tanggal,
                                                    DATEDIFF(a.tanggal_kandang_activity_log, c.tanggal_mulai) as umur,
                                                    a.harga, a.qty, b.brand as jenis, a.id, round(a.harga*a.qty,0) as harga_tot, b.satuan
                                                    FROM `kandang_activity_log_sapronak` as a
                                                    LEFT JOIN general as b on a.id_this = b.id
                                                    LEFT JOIN kandang_activity as c on a.id_kandang = c.id_kandang and a.periode = c.periode
                                                    WHERE type_sapronak = 'general' and method_sapronak = 'use' and a.id_kandang = '{$idkandang}' AND a.periode = '{$periode}' ORDER BY a.tanggal_kandang_activity_log DESC";
            $getdatahariangeneral = $this->MData->customresult($getdatahariangeneral_query);
            echo json_encode($getdatahariangeneral);
            //     } else {
            //         echo json_encode(['status' => 'error', 'message' => 'Token Salah']);
            //     }
            // } else {
            //     echo json_encode(['status' => 'error', 'message' => 'Token Kosong']);
            // }
        } else {
            //
            echo json_encode(['status' => 'error', 'message' => 'Invalid token']);
        }
    }
    public function datapanendo()
    {
        if ($this->input->post()) {
            if ($this->input->post('token')) {
                // $validatetoken = $this->MThirdApp->validateToken($this->input->post('token'));
                // if ($validatetoken['status']) {
                $kandangperiode = explode("|", $this->input->post('kandangperiode'));
                $idkandang = $kandangperiode[0];
                $periode = $kandangperiode[1];
                $getdatapanendo_query = "SELECT 
                                            a.harga,  a.ttdpenimbang, a.ttdpembeli,
                                            ifNull(round((sum(a.qty_kg) - ifNull(a.susut,0) - ifNull(a.beratkeranjang,0)),3) * a.harga,0) as harga_tot,
                                            a.tanggal, sum(a.qty_ekor) as total_ayam, 
                                            round(sum(a.qty_kg),3) as bruto, 
                                            a.susut, a.beratkeranjang, a.nomornota, 
                                            a.nomorDO, a.nomor_mobil, a.namapembeli, a.kondisiayam, a.namapenimbang, b.kode_do, concat(b.kode_do,a.nomorDO) as do,
                                            DATEDIFF(a.tanggal, c.tanggal_mulai) as umur, 
                                            round((sum(a.qty_kg) - ifNull(a.susut,0) - ifNull(a.beratkeranjang,0)),3) as nett,
                                            round(ifNull(round((sum(a.qty_kg) - ifNull(a.susut,0) - ifNull(a.beratkeranjang,0)),3)/ sum(a.qty_ekor) ,0),3) as rata
                                            FROM `kandang_activity_log_panen` as a
                                            Left join kandang as b on b.id = a.id_kandang
                                            LEFT JOIN kandang_activity as c on a.id_kandang = c.id_kandang and a.periode = c.periode
                                            WHERE a.id_kandang = '{$idkandang}' AND a.periode = '{$periode}' GROUP BY a.nomorDO ORDER BY a.tanggal DESC";
                $getdatapanendo = $this->MData->customresult($getdatapanendo_query);
                echo json_encode($getdatapanendo);
                // } else {
                //     echo json_encode(['status' => 'error', 'message' => 'Token Salah']);
                // }
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Token Kosong']);
            }
        } else {
            //
            echo json_encode(['status' => 'error', 'message' => 'Invalid token']);
        }
    }
    public function datapanendetail()
    {
        if ($this->input->post()) {
            if ($this->input->post('token')) {
                $validatetoken = $this->MThirdApp->validateToken($this->input->post('token'));
                if ($validatetoken['status']) {
                    $kandangperiode = explode("|", $this->input->post('kandangperiode'));
                    $idkandang = $kandangperiode[0];
                    $periode = $kandangperiode[1];
                    $nomordo = $this->input->post('nomordo');
                    $type_input = $this->input->post('type_input');
                    if ($type_input == 'edit') {
                        $getdatapanen_query = "SELECT
                                        a.tanggal,
                                        a.harga, a.qty_ekor, a.qty_kg, round(a.harga*a.qty_kg,0) as harga_tot, a.id
                                        FROM `kandang_activity_log_panen` as a
                                        WHERE a.id_kandang = '{$idkandang}' AND a.periode = '{$periode}' AND a.nomorDO = '{$nomordo}' ORDER BY a.created_at ASC";
                        $getdatapanen = $this->MData->customresult($getdatapanen_query);
                        $getdatapanendo_query = "SELECT 
                                                a.harga, a.ttdpenimbang, a.ttdpembeli,
                                                ifNull(round((sum(a.qty_kg) - ifNull(a.susut,0) - ifNull(a.beratkeranjang,0)),3) * a.harga,0) as harga_tot,
                                                a.tanggal, sum(a.qty_ekor) as total_ayam, 
                                                round(sum(a.qty_kg),3) as bruto, 
                                                a.susut, a.beratkeranjang, a.nomornota, 
                                                a.nomorDO, a.nomor_mobil, a.namapembeli, a.kondisiayam, a.namapenimbang, b.kode_do, concat(b.kode_do,a.nomorDO) as do,
                                                DATEDIFF(a.tanggal, c.tanggal_mulai) as umur, 
                                                round((sum(a.qty_kg) - ifNull(a.susut,0) - ifNull(a.beratkeranjang,0)),3) as nett,
                                                round(ifNull(round((sum(a.qty_kg) - ifNull(a.susut,0) - ifNull(a.beratkeranjang,0)),3)/ sum(a.qty_ekor) ,0),3) as rata
                                                FROM `kandang_activity_log_panen` as a
                                                Left join kandang as b on b.id = a.id_kandang
                                                LEFT JOIN kandang_activity as c on a.id_kandang = c.id_kandang and a.periode = c.periode
                                                WHERE a.id_kandang = '{$idkandang}' AND a.periode = '{$periode}' AND a.nomorDO = '{$nomordo}' GROUP BY a.nomorDO ORDER BY a.tanggal DESC";
                        $getdatapanendo = $this->MData->customrow($getdatapanendo_query);
                        $data = array(
                            "tanggal" => $getdatapanendo->tanggal,
                            "nomor_mobil" => $getdatapanendo->nomor_mobil,
                            "namapembeli" => $getdatapanendo->namapembeli,
                            "namapenimbang" => $getdatapanendo->namapenimbang,
                            "nomornota" => $getdatapanendo->nomornota,
                            "beratkeranjang" => $getdatapanendo->beratkeranjang,
                            "susut" => $getdatapanendo->susut,
                            "do" => $getdatapanendo->do,
                            "nomorDO" => $getdatapanendo->nomorDO,
                            "kondisiayam" => $getdatapanendo->kondisiayam,
                            "ttdpembeli" =>  $getdatapanendo->ttdpembeli ? $getdatapanendo->ttdpembeli : 'https://peternak.id/assets/mobile/img/bg-img/kandangdefault.png',
                            "ttdpenimbang" => $getdatapanendo->ttdpenimbang ? $getdatapanendo->ttdpenimbang : 'https://peternak.id/assets/mobile/img/bg-img/kandangdefault.png',
                            "datapanen" => $getdatapanen,
                            "type_input" => $type_input,
                            // $condition ? $value_if_true : $value_if_false
                        );
                    } else {
                        $getnomordo_query = "SELECT MAX(a.nomorDO) + 1 as nomorDO, concat(b.kode_do,MAX(a.nomorDO) + 1) as do FROM `kandang_activity_log_panen` as a
                                            Left join kandang as b on b.id = a.id_kandang
                                             WHERE a.id_kandang = '{$idkandang}' AND a.periode = '{$periode}'";
                        $getnomordo = $this->MData->customrow($getnomordo_query);
                        $data = array(
                            "tanggal" => '',
                            "nomor_mobil" => '',
                            "namapembeli" => '',
                            "namapenimbang" => '',
                            "nomornota" => '',
                            "beratkeranjang" => '',
                            "susut" => '',
                            "do" => $getnomordo->do,
                            "nomorDO" => $getnomordo->nomorDO,
                            "kondisiayam" => '',
                            "ttdpembeli" => 'https://peternak.id/assets/mobile/img/bg-img/kandangdefault.png',
                            "ttdpenimbang" => 'https://peternak.id/assets/mobile/img/bg-img/kandangdefault.png',
                            "datapanen" => '',
                            "type_input" => $type_input,
                        );
                    }
                    echo json_encode($data);
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
    function getpakantable()
    {
        $tokenstatus = $this->MThirdApp->validatetoken();
        if ($tokenstatus['status']) {
            $kandangperiode = explode("|", $this->input->post('kandangperiode'));
            $idkandang = $kandangperiode[0];
            $periode = $kandangperiode[1];
            $datapakan = $this->MData->selectdatawhereresult('final_item', ['id_kandang' => $idkandang, 'periode' => $periode, 'type_item' => 'pakan']) == FALSE ? $this->MSql->getstock('pakan', $idkandang, $periode) : $this->MData->selectdatawhereresult('final_item', ['id_kandang' => $idkandang, 'periode' => $periode, 'type_item' => 'pakan']);

            if ($datapakan) {
                for ($i = 0; $i < count($datapakan); $i++) {
                    $datapakan[$i]->btn =
                        "<div class='btn-group' role='group' aria-label='Grouping button'>
                        <a href='javascript:void(0);' class='btn btn-edit btn-primary btn-sm'><i class='fas fa-edit'></i></a>
                        <a href='javascript:void(0);' class='btn btn-hapus btn-danger btn-sm'><i class='fas fa-trash'></i></a>
                    </div>";
                }
            }
            echo json_encode($datapakan);
        } else {
            echo json_encode(['status' => FALSE, 'message' => 'Wrong Token']);
        }
    }
    function getovktable()
    {
        $tokenstatus = $this->MThirdApp->validatetoken();
        if ($tokenstatus['status']) {
            $kandangperiode = explode("|", $this->input->post('kandangperiode'));
            $idkandang = $kandangperiode[0];
            $periode = $kandangperiode[1];
            $dataovk = $this->MData->selectdatawhereresult('final_item', ['id_kandang' => $idkandang, 'periode' => $periode, 'type_item' => 'ovk']) == FALSE ? $this->MSql->getstock('ovk', $idkandang, $periode) : $this->MData->selectdatawhereresult('final_item', ['id_kandang' => $idkandang, 'periode' => $periode, 'type_item' => 'ovk']);
            if ($dataovk) {
                for ($i = 0; $i < count($dataovk); $i++) {
                    $dataovk[$i]->btn =
                        "<div class='btn-group' role='group' aria-label='Grouping button'>
                        <a href='javascript:void(0);' class='btn btn-edit btn-primary btn-sm'><i class='fas fa-edit'></i></a>
                        <a href='javascript:void(0);' class='btn btn-hapus btn-danger btn-sm'><i class='fas fa-trash'></i></a>
                    </div>";
                }
            }
            echo json_encode($dataovk);
        } else {
            echo json_encode(['status' => FALSE, 'message' => 'Wrong Token']);
        }
    }
    function getgeneraltable()
    {
        $tokenstatus = $this->MThirdApp->validatetoken();
        if ($tokenstatus['status']) {
            $kandangperiode = explode("|", $this->input->post('kandangperiode'));
            $idkandang = $kandangperiode[0];
            $periode = $kandangperiode[1];
            $datageneral = $this->MData->selectdatawhereresult('final_item', ['id_kandang' => $idkandang, 'periode' => $periode, 'type_item' => 'general']) == FALSE ? $this->MSql->getstock('general', $idkandang, $periode) : $this->MData->selectdatawhereresult('final_item', ['id_kandang' => $idkandang, 'periode' => $periode, 'type_item' => 'general']);
            if ($datageneral) {
                for ($i = 0; $i < count($datageneral); $i++) {
                    $datageneral[$i]->btn =
                        "<div class='btn-group' role='group' aria-label='Grouping button'>
                        <a href='javascript:void(0);' class='btn btn-edit btn-primary btn-sm'><i class='fas fa-edit'></i></a>
                        <a href='javascript:void(0);' class='btn btn-hapus btn-danger btn-sm'><i class='fas fa-trash'></i></a>
                    </div>";
                }
            }
            echo json_encode($datageneral);
        } else {
            echo json_encode(['status' => FALSE, 'message' => 'Wrong Token']);
        }
    }
    function hapuskonsumsiharian()
    {
        if ($this->input->post()) {
            if ($this->input->post('token')) {
                $validatetoken = $this->MThirdApp->validateToken($this->input->post('token'));
                if ($validatetoken['status']) {
                    unset($_POST['token']);
                    $this->MData->delete('kandang_activity_log_sapronak', $this->input->post());
                    echo json_encode(['status' => true, 'message' => 'Data berhasil dihapus']);
                } else {
                    echo json_encode(['status' => false, 'message' => 'Token Salah']);
                }
            } else {
                echo json_encode(['status' => false, 'message' => 'Token Kosong']);
            }
        } else {
            echo json_encode(['status' => false, 'message' => 'Invalid token']);
        }
    }
    function inputkonsumsiharian()
    {
        if ($this->input->post()) {
            if ($this->input->post('token')) {
                $validatetoken = $this->MThirdApp->validateToken($this->input->post('token'));
                if ($validatetoken['status']) {
                    $idperiode = explode("|", $this->input->post('idkandangperiode'));
                    $_POST['id_kandang'] = $idperiode[0];
                    $_POST['periode'] = $idperiode[1];
                    $type_input = $this->input->post('type_input');
                    unset($_POST['token'], $_POST['idkandangperiode'], $_POST['type_input']);
                    if ($type_input == "edit") {
                        $edit = $this->MData->edit(['id' => $this->input->post('id')], 'kandang_activity_log_sapronak', $this->input->post());
                        if ($edit) {
                            echo json_encode(['status' => true, 'message' => 'Data berhasil diubah']);
                        } else {
                            echo json_encode(['status' => false, 'message' => 'Data gagal diubah']);
                        }
                    } else {
                        unset($_POST['id']);
                        $save = $this->MData->tambah('kandang_activity_log_sapronak', $this->input->post());
                        if ($save) {
                            echo json_encode(['status' => true, 'message' => 'Data berhasil disimpan']);
                        } else {
                            echo json_encode(['status' => false, 'message' => 'Data gagal disimpan']);
                        }
                    }
                } else {
                    echo json_encode(['status' => false, 'message' => 'Token Salah']);
                }
            } else {
                echo json_encode(['status' => false, 'message' => 'Token Kosong']);
            }
        } else {
            echo json_encode(['status' => false, 'message' => 'Invalid token']);
        }
    }
    function hapusdataharian()
    {
        if ($this->input->post()) {
            if ($this->input->post('token')) {
                $validatetoken = $this->MThirdApp->validateToken($this->input->post('token'));
                if ($validatetoken['status']) {
                    unset($_POST['token']);
                    $this->MData->delete('kandang_activity_log', $this->input->post());
                    echo json_encode(['status' => true, 'message' => 'Data berhasil dihapus']);
                } else {
                    echo json_encode(['status' => false, 'message' => 'Token Salah']);
                }
            } else {
                echo json_encode(['status' => false, 'message' => 'Token Kosong']);
            }
        } else {
            echo json_encode(['status' => false, 'message' => 'Invalid token']);
        }
    }
    function inputdataharian()
    {
        if ($this->input->post()) {
            if ($this->input->post('token')) {
                $validatetoken = $this->MThirdApp->validateToken($this->input->post('token'));
                if ($validatetoken['status']) {
                    $idperiode = explode("|", $this->input->post('idkandangperiode'));
                    $_POST['id_kandang'] = $idperiode[0];
                    $_POST['periode'] = $idperiode[1];
                    $getactivitydetail = $this->MData->customrow("SELECT * FROM kandang_activity where id_kandang = '{$idperiode[0]}' AND periode ='{$idperiode[1]}' ORDER BY created_at DESC");
                    $_POST['tanggal_chickin'] = $getactivitydetail->tanggal_mulai;
                    $type_input = $this->input->post('type_input');
                    unset($_POST['token'], $_POST['idkandangperiode'], $_POST['type_input']);
                    if ($type_input == "edit") {
                        $edit = $this->MData->edit(['id' => $this->input->post('id')], 'kandang_activity_log', $this->input->post());
                        if ($edit) {
                            echo json_encode(['status' => true, 'message' => 'Data berhasil diubah']);
                        } else {
                            echo json_encode(['status' => false, 'message' => 'Data gagal diubah']);
                        }
                    } else {
                        unset($_POST['id']);
                        $cek_tanggal = $this->MData->customrow("SELECT * FROM kandang_activity_log where id_kandang = '{$idperiode[0]}' AND periode ='{$idperiode[1]}' and tanggal ='{$_POST['tanggal']}'");
                        if ($cek_tanggal) {
                            echo json_encode(['status' => false, 'message' => 'Data gagal disimpan tanggal sudah terisi']);
                        } else {
                            $save = $this->MData->tambah('kandang_activity_log', $this->input->post());
                            if ($save) {
                                echo json_encode(['status' => true, 'message' => 'Data berhasil disimpan']);
                            } else {
                                echo json_encode(['status' => false, 'message' => 'Data gagal disimpan']);
                            }
                        }
                    }
                } else {
                    echo json_encode(['status' => false, 'message' => 'Token Salah']);
                }
            } else {
                echo json_encode(['status' => false, 'message' => 'Token Kosong']);
            }
        } else {
            echo json_encode(['status' => false, 'message' => 'Invalid token']);
        }
    }
    function inputews()
    {
        if ($this->input->post()) {
            if ($this->input->post('token')) {
                $validatetoken = $this->MThirdApp->validateToken($this->input->post('token'));
                if ($validatetoken['status']) {
                    $idperiode = explode("|", $this->input->post('idkandangperiode'));
                    $_POST['id_kandang'] = $idperiode[0];
                    $_POST['periode'] = $idperiode[1];
                    $type_input = $this->input->post('type_input');
                    unset($_POST['token'], $_POST['idkandangperiode'], $_POST['type_input']);
                    if ($type_input == "edit") {
                        $edit = $this->MData->edit(['id' => $this->input->post('id')], 'kandang_activity_log_ews', $this->input->post());
                        if ($edit) {
                            $data_input = $this->MData->customrow("SELECT a.*,  DATEDIFF(a.tanggal, b.tanggal_mulai) as umur, a.id as id_ket FROM kandang_activity_log_ews as a left join `kandang_activity` as b on a.id_kandang = b.id_kandang and a.periode = b.periode where a.id_kandang = '{$idperiode[0]}' AND a.periode ='{$idperiode[1]}' and a.tanggal ='{$_POST['tanggal']}'");
                            echo json_encode(['status' => true, 'message' => 'Data berhasil diubah', 'data' => $data_input]);
                        } else {
                            echo json_encode(['status' => false, 'message' => 'Data gagal diubah']);
                        }
                    } else {
                        unset($_POST['id']);
                        $save = $this->MData->tambah('kandang_activity_log_ews', $this->input->post());

                        if ($save) {
                            $data_input = $this->MData->customrow("SELECT a.*,  DATEDIFF(a.tanggal, b.tanggal_mulai) as umur, a.id as id_ket FROM kandang_activity_log_ews as a left join `kandang_activity` as b on a.id_kandang = b.id_kandang and a.periode = b.periode where a.id_kandang = '{$idperiode[0]}' AND a.periode ='{$idperiode[1]}' and a.tanggal ='{$_POST['tanggal']}'");
                            echo json_encode(['status' => true, 'message' => 'Data berhasil disimpan', 'data' => $data_input]);
                        } else {
                            echo json_encode(['status' => false, 'message' => 'Data gagal disimpan']);
                        }
                    }
                } else {
                    echo json_encode(['status' => false, 'message' => 'Token Salah']);
                }
            } else {
                echo json_encode(['status' => false, 'message' => 'Token Kosong']);
            }
        } else {
            echo json_encode(['status' => false, 'message' => 'Invalid token']);
        }
    }
    function inputdatapanen()
    {
        if ($this->input->post()) {
            if ($this->input->post('token')) {
                $validatetoken = $this->MThirdApp->validateToken($this->input->post('token'));
                if ($validatetoken['status']) {
                    $idperiode = explode("|", $this->input->post('idkandangperiode'));
                    $_POST['id_kandang'] = $idperiode[0];
                    $_POST['periode'] = $idperiode[1];
                    $type_input = $this->input->post('type_input');
                    $getdatapanen_query = "SELECT
                                        a.tanggal,
                                        a.harga, a.qty_ekor, a.qty_kg, round(a.harga*a.qty_kg,0) as harga_tot, a.id
                                        FROM `kandang_activity_log_panen` as a
                                        WHERE a.id_kandang = '{$idperiode[0]}' AND a.periode = '{$idperiode[1]}' AND a.nomorDO = '{$_POST['nomorDO']}' ORDER BY a.created_at ASC";
                    $getdatapanendo_query = "SELECT 
                                                a.harga,  a.ttdpenimbang, a.ttdpembeli,
                                                ifNull(round((sum(a.qty_kg) - ifNull(a.susut,0) - ifNull(a.beratkeranjang,0)),3) * a.harga,0) as harga_tot,
                                                a.tanggal, sum(a.qty_ekor) as total_ayam, 
                                                round(sum(a.qty_kg),3) as bruto, 
                                                a.susut, a.beratkeranjang, a.nomornota, 
                                                a.nomorDO, a.nomor_mobil, a.namapembeli, a.kondisiayam, a.namapenimbang, b.kode_do, concat(b.kode_do,a.nomorDO) as do,
                                                DATEDIFF(a.tanggal, c.tanggal_mulai) as umur, 
                                                round((sum(a.qty_kg) - ifNull(a.susut,0) - ifNull(a.beratkeranjang,0)),3) as nett,
                                                round(ifNull(round((sum(a.qty_kg) - ifNull(a.susut,0) - ifNull(a.beratkeranjang,0)),3)/ sum(a.qty_ekor) ,0),3) as rata
                                                FROM `kandang_activity_log_panen` as a
                                                Left join kandang as b on b.id = a.id_kandang
                                                LEFT JOIN kandang_activity as c on a.id_kandang = c.id_kandang and a.periode = c.periode
                                                WHERE a.id_kandang = '{$idperiode[0]}' AND a.periode = '{$idperiode[1]}' AND a.nomorDO = '{$_POST['nomorDO']}' GROUP BY a.nomorDO ORDER BY a.tanggal DESC";

                    unset($_POST['token'], $_POST['idkandangperiode'], $_POST['type_input']);
                    if ($type_input == "edit") {
                        $edit = $this->MData->edit(['id' => $this->input->post('id')], 'kandang_activity_log_panen', $this->input->post());
                        if ($edit) {
                            $getdatapanen = $this->MData->customresult($getdatapanen_query);
                            $getdatapanendo = $this->MData->customrow($getdatapanendo_query);
                            echo json_encode(['status' => true, 'message' => 'Data berhasil diubah', 'datapanen' => $getdatapanen, 'datapanendo' => $getdatapanendo]);
                        } else {
                            echo json_encode(['status' => false, 'message' => 'Data gagal diubah']);
                        }
                    } else {
                        unset($_POST['id']);
                        $save = $this->MData->tambah('kandang_activity_log_panen', $this->input->post());
                        if ($save) {
                            $getdatapanen = $this->MData->customresult($getdatapanen_query);
                            $getdatapanendo = $this->MData->customrow($getdatapanendo_query);
                            echo json_encode(['status' => true, 'message' => 'Data berhasil disimpan', 'datapanen' => $getdatapanen, 'datapanendo' => $getdatapanendo]);
                        } else {
                            echo json_encode(['status' => false, 'message' => 'Data gagal disimpan']);
                        }
                    }
                } else {
                    echo json_encode(['status' => false, 'message' => 'Token Salah']);
                }
            } else {
                echo json_encode(['status' => false, 'message' => 'Token Kosong']);
            }
        } else {
            echo json_encode(['status' => false, 'message' => 'Invalid token']);
        }
    }
    function hapusdatatimbang()
    {
        if ($this->input->post()) {
            if ($this->input->post('token')) {
                $validatetoken = $this->MThirdApp->validateToken($this->input->post('token'));
                if ($validatetoken['status']) {
                    unset($_POST['token']);
                    $data_query = "select * from kandang_activity_log_panen where id = '{$_POST['id']}'";
                    $getdatapanendetail = $this->MData->customrow($data_query);
                    $getdatapanen_query = "SELECT
                                        a.tanggal,
                                        a.harga, a.qty_ekor, a.qty_kg, round(a.harga*a.qty_kg,0) as harga_tot, a.id
                                        FROM `kandang_activity_log_panen` as a
                                        WHERE a.id_kandang = '{$getdatapanendetail->id_kandang}' AND a.periode = '{$getdatapanendetail->periode}' AND a.nomorDO = '{$getdatapanendetail->nomorDO}' ORDER BY a.created_at ASC";
                    $getdatapanendo_query = "SELECT 
                                                a.harga,  a.ttdpenimbang, a.ttdpembeli,
                                                ifNull(round((sum(a.qty_kg) - ifNull(a.susut,0) - ifNull(a.beratkeranjang,0)),3) * a.harga,0) as harga_tot,
                                                a.tanggal, sum(a.qty_ekor) as total_ayam, 
                                                round(sum(a.qty_kg),3) as bruto, 
                                                a.susut, a.beratkeranjang, a.nomornota, 
                                                a.nomorDO, a.nomor_mobil, a.namapembeli, a.kondisiayam, a.namapenimbang, b.kode_do, concat(b.kode_do,a.nomorDO) as do,
                                                DATEDIFF(a.tanggal, c.tanggal_mulai) as umur, 
                                                round((sum(a.qty_kg) - ifNull(a.susut,0) - ifNull(a.beratkeranjang,0)),3) as nett,
                                                round(ifNull(round((sum(a.qty_kg) - ifNull(a.susut,0) - ifNull(a.beratkeranjang,0)),3)/ sum(a.qty_ekor) ,0),3) as rata
                                                FROM `kandang_activity_log_panen` as a
                                                Left join kandang as b on b.id = a.id_kandang
                                                LEFT JOIN kandang_activity as c on a.id_kandang = c.id_kandang and a.periode = c.periode
                                                WHERE a.id_kandang = '{$getdatapanendetail->id_kandang}' AND a.periode = '{$getdatapanendetail->periode}' AND a.nomorDO = '{$getdatapanendetail->nomorDO}' GROUP BY a.nomorDO ORDER BY a.tanggal DESC";

                    $this->MData->delete('kandang_activity_log_panen', $this->input->post());
                    $getdatapanen = $this->MData->customresult($getdatapanen_query);
                    $getdatapanendo = $this->MData->customrow($getdatapanendo_query);
                    echo json_encode(['status' => true, 'message' => 'Data berhasil dihapus', 'datapanen' => $getdatapanen, 'datapanendo' => $getdatapanendo]);
                } else {
                    echo json_encode(['status' => false, 'message' => 'Token Salah']);
                }
            } else {
                echo json_encode(['status' => false, 'message' => 'Token Kosong']);
            }
        } else {
            echo json_encode(['status' => false, 'message' => 'Invalid token']);
        }
    }
    function data_transaksi_update()
    {
        if ($this->input->post()) {
            if ($this->input->post('token')) {
                $validatetoken = $this->MThirdApp->validateToken($this->input->post('token'));
                if ($validatetoken['status']) {
                    $idperiode = explode("|", $this->input->post('idkandangperiode'));
                    $_POST['id_kandang'] = $idperiode[0];
                    $_POST['periode'] = $idperiode[1];

                    $getdatapanendo_query = "SELECT 
                                                a.harga,  a.ttdpenimbang, a.ttdpembeli,
                                                ifNull(round((sum(a.qty_kg) - ifNull(a.susut,0) - ifNull(a.beratkeranjang,0)),3) * a.harga,0) as harga_tot,
                                                a.tanggal, sum(a.qty_ekor) as total_ayam, 
                                                round(sum(a.qty_kg),3) as bruto, 
                                                a.susut, a.beratkeranjang, a.nomornota, 
                                                a.nomorDO, a.nomor_mobil, a.namapembeli, a.kondisiayam, a.namapenimbang, b.kode_do, concat(b.kode_do,a.nomorDO) as do,
                                                DATEDIFF(a.tanggal, c.tanggal_mulai) as umur, 
                                                round((sum(a.qty_kg) - ifNull(a.susut,0) - ifNull(a.beratkeranjang,0)),3) as nett,
                                                round(ifNull(round((sum(a.qty_kg) - ifNull(a.susut,0) - ifNull(a.beratkeranjang,0)),3)/ sum(a.qty_ekor) ,0),3) as rata
                                                FROM `kandang_activity_log_panen` as a
                                                Left join kandang as b on b.id = a.id_kandang
                                                LEFT JOIN kandang_activity as c on a.id_kandang = c.id_kandang and a.periode = c.periode
                                                WHERE a.id_kandang = '{$idperiode[0]}' AND a.periode = '{$idperiode[1]}' AND a.nomorDO = '{$_POST['nomorDO']}' GROUP BY a.nomorDO ORDER BY a.tanggal DESC";

                    unset($_POST['token'], $_POST['idkandangperiode'], $_POST['type_input']);

                    $edit = $this->MData->edit(['nomorDO' => $this->input->post('nomorDO'), 'id_kandang' => $idperiode[0], 'periode' => $idperiode[1]], 'kandang_activity_log_panen', $this->input->post());
                    if ($edit) {
                        $getdatapanendo = $this->MData->customrow($getdatapanendo_query);
                        echo json_encode(['status' => true, 'message' => 'Data berhasil diubah', 'datapanendo' => $getdatapanendo]);
                    } else {
                        echo json_encode(['status' => false, 'message' => 'Data gagal diubah']);
                    }
                } else {
                    echo json_encode(['status' => false, 'message' => 'Token Salah']);
                }
            } else {
                echo json_encode(['status' => false, 'message' => 'Token Kosong']);
            }
        } else {
            echo json_encode(['status' => false, 'message' => 'Invalid token']);
        }
    }
    function hapusdatapanen()
    {
        if ($this->input->post()) {
            if ($this->input->post('token')) {
                $validatetoken = $this->MThirdApp->validateToken($this->input->post('token'));
                if ($validatetoken['status']) {
                    $idperiode = explode("|", $this->input->post('kandangperiode'));
                    unset($_POST['kandangperiode']);
                    unset($_POST['token']);
                    $_POST['id_kandang'] = $idperiode[0];
                    $_POST['periode'] = $idperiode[1];
                    $this->MData->delete('kandang_activity_log_panen', $this->input->post());
                    echo json_encode(['status' => true, 'message' => 'Data berhasil dihapus']);
                } else {
                    echo json_encode(['status' => false, 'message' => 'Token Salah']);
                }
            } else {
                echo json_encode(['status' => false, 'message' => 'Token Kosong']);
            }
        } else {
            echo json_encode(['status' => false, 'message' => 'Invalid token']);
        }
    }
    function data_ttd_update()
    {
        if ($this->input->post()) {
            if ($this->input->post('token')) {
                $validatetoken = $this->MThirdApp->validateToken($this->input->post('token'));
                if ($validatetoken['status']) {
                    $idperiode = explode("|", $this->input->post('idkandangperiode'));
                    unset($_POST['idkandangperiode']);
                    unset($_POST['token']);
                    $_POST['id_kandang'] = $idperiode[0];
                    $_POST['periode'] = $idperiode[1];

                    $idkandang = $idperiode[0];
                    $periode = $idperiode[1];
                    $nomordo = $this->input->post('nomorDO');

                    $getdata_query = "SELECT * FROM `kandang_activity_log_panen` where id_kandang = '{$idkandang}' and periode = '{$periode}' and nomorDO = '{$nomordo}'";
                    $getdata = $this->MData->customrow($getdata_query);

                    if ($getdata) {
                        $data_penimbang = $this->input->post('image_penimbang');
                        $data_pembeli = $this->input->post('image_pembeli');
                        // Penimbang
                        list($type, $data_penimbang) = explode(';', $data_penimbang);
                        list(, $data_penimbang
                        )      = explode(',', $data_penimbang);
                        $filename_penimbang = "ttdpenimbang_{$idkandang}_{$periode}_{$nomordo}" . date('Ymdhis') . ".png";
                        $data_penimbang = base64_decode($data_penimbang);
                        $pathpenimbang = str_replace('peternak_api/application/', 'peternak/assets/mobile/img/ttd/', APPPATH) . $filename_penimbang;
                        file_put_contents($pathpenimbang, $data_penimbang);
                        // Pembeli
                        list($type, $data_pembeli) = explode(';', $data_pembeli);
                        list(, $data_pembeli
                        )      = explode(',', $data_pembeli);
                        $data_pembeli = base64_decode($data_pembeli);
                        $filename_pembeli = "ttdpembeli_{$idkandang}_{$periode}_{$nomordo}" . date('Ymdhis') . ".png";
                        $pathpembeli = str_replace('peternak_api/application/', 'peternak/assets/mobile/img/ttd/', APPPATH) . $filename_pembeli;
                        file_put_contents($pathpembeli, $data_pembeli);
                        $this->MData->edit(array('id_kandang' => $idkandang, 'periode' => $periode, 'nomorDO' => $nomordo), 'kandang_activity_log_panen', array('ttdpembeli' =>  'https://app.peternak.id/assets/mobile/img/ttd/' . $filename_pembeli, 'ttdpenimbang' =>  'https://app.peternak.id/assets/mobile/img/ttd/' . $filename_penimbang));
                        echo json_encode(['status' => true, 'message' => 'Data berhasil diupdate', 'pathpembeli' => $pathpembeli, 'pathpenimbang' => $pathpenimbang]);
                    } else {
                        echo json_encode(['status' => false, 'message' => 'Data Timbang Kosong']);
                    }
                } else {
                    echo json_encode(['status' => false, 'message' => 'Token Salah']);
                }
            } else {
                echo json_encode(['status' => false, 'message' => 'Token Kosong']);
            }
        } else {
            echo json_encode(['status' => false, 'message' => 'Invalid token']);
        }
    }
}
