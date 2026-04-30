<?php

defined('BASEPATH') or exit('No direct script access allowed');

class MSql extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('MData');
    }


    public function dataresume_api($kandangperiode, $token, $user_id)
    {
        $kandangperiode = explode("|", $this->input->post('kandangperiode'));
        $idkandang = $kandangperiode[0];
        $periode = $kandangperiode[1];
        $getdataharian = $this->getactivitydetail_join($idkandang, $periode);
        return json_encode($getdataharian);
    }
    private function getactivitydetail_join($idkandang, $periode)
    {
        $getactivitydetail_join = $this->MData->customrow("SELECT *, populasi_awal*harga_doc as harga_tot FROM kandang_activity LEFT JOIN kandang ON kandang.id = kandang_activity.id_kandang where id_kandang = '{$idkandang}' AND periode ='{$periode}' ORDER BY kandang_activity.created_at DESC");
        if ($getactivitydetail_join->status_kandang_activity != 'AKTIF' || $getactivitydetail_join->status_kandang != "AKTIF") {
            $deplesi = "(SELECT sum(total_mati) as deplesi FROM kandang_activity_log where periode = b.periode and id_kandang = b.id_kandang)";
            $tot_feed = "(SELECT sum(qty) as tot_feed FROM kandang_activity_log_sapronak where type_sapronak = 'pakan' and method_sapronak = 'use' and periode = b.periode and id_kandang = b.id_kandang)";
            $panen_ekor = "(SELECT sum(qty_ekor) as panen_ekor from kandang_activity_log_panen where periode = b.periode and id_kandang = b.id_kandang)";
            // $panen_kg = "(SELECT sum(qty_kg) as panen_kg from kandang_activity_log_panen where periode = b.periode and id_kandang = b.id_kandang)";
            $panen_kg = "(SELECT round(sum(tot_kg) - sum(beratkeranjang) - sum(susut),3) as kg from (SELECT aaa.susut, aaa.beratkeranjang, sum(aaa.qty_kg) as tot_kg  FROM `kandang_activity_log_panen` as aaa where aaa.id_kandang = '{$idkandang}' and aaa.periode = '{$periode}' GROUP by aaa.nomorDO) as tot)";
            $std_fcr = "round((SELECT fcr FROM `std` Where bw = IFNULL(round({$panen_kg}/{$panen_ekor}*1000,0),0) and strain = b.strain),3)";
            $tgl_awal_panen = "(SELECT min(tanggal) as tgl_awal_panen FROM kandang_activity_log_panen where periode = b.periode and id_kandang = b.id_kandang)";
            $tgl_akhir_panen = "(SELECT max(tanggal) as tgl_akhir_panen FROM kandang_activity_log_panen where periode = b.periode and id_kandang = b.id_kandang)";
            $umur_rata_panen = "(SELECT round(sum(DATEDIFF(bb.tanggal, (SELECT tanggal_chickin from kandang_activity_log WHERE periode = bb.periode and id_kandang = bb.id_kandang order by id DESC limit 1 ))*qty_ekor)/sum(qty_ekor),0) as umur_rata_panen  FROM `kandang_activity_log_panen` as bb where bb.periode = b.periode and bb.id_kandang = b.id_kandang)";
            $querydresumerehat = "SELECT
                              b.populasi_awal,
                              b.tanggal_mulai as tanggal_chickin,
                              a.nama,
                              a.foto,
                              b.id_kandang,
                              b.periode,
                              {$deplesi} as deplesi,
                              round({$deplesi}/b.populasi_awal*100,2) as deplesi_persent,
                              {$tot_feed} as tot_feed,
                              b.strain,
                              {$panen_ekor} as panen_ekor,
                              round({$panen_kg},3) as panen_kg,
                              IFNULL(round({$panen_kg}/{$panen_ekor}*1000,0),0) as bw,
                              IFNULL(round({$tot_feed} * 50 / {$panen_kg},3),0) as act_fcr,
                              {$std_fcr} as std_fcr,
                              round(((IFNULL(round({$tot_feed} * 50 / {$panen_kg},3),0) / {$std_fcr}) - 1) * 100,2) as diff_fcr,
                              {$tgl_awal_panen} as tgl_awal_panen,
                              {$tgl_akhir_panen} as tgl_akhir_panen,
                              {$umur_rata_panen} as umur_rata_panen,
                              100 - round({$deplesi}/b.populasi_awal*100,2) as daya_hidup,
                              IFNULL(round(((100 - round({$deplesi}/b.populasi_awal*100,2))*{$panen_kg}/{$panen_ekor}*100)/(round({$tot_feed} * 50 / {$panen_kg},3)*{$umur_rata_panen}),0),0) as ip
                              FROM kandang as a
                              LEFT JOIN kandang_activity as b ON a.id = b.id_kandang
                              where a.id ='{$idkandang}' AND b.periode = '{$periode}'";

            $dataresume = $this->MData->customrow($querydresumerehat);
        } else {
            $tanggal_chickin = "(SELECT tanggal_mulai FROM `kandang_activity` where id_kandang = a.id and periode = b.periode)";
            $bw3 = "(SELECT bw FROM `kandang_activity_log` WHERE periode = b.periode and id_kandang = b.id_kandang and tanggal = tanggal_chickin + INTERVAL 3 DAY)";
            $bw7 = "(SELECT bw FROM `kandang_activity_log` WHERE periode = b.periode and id_kandang = b.id_kandang and tanggal = tanggal_chickin + INTERVAL 7 DAY)";
            $bw0 = "(SELECT bw FROM `kandang_activity_log` WHERE periode = b.periode and id_kandang = b.id_kandang and tanggal = tanggal_chickin)";
            $panen_kg = "(SELECT round(sum(tot_kg) - sum(beratkeranjang) - sum(susut),3) as kg from (SELECT aaa.susut,aaa.beratkeranjang, sum(aaa.qty_kg) as tot_kg, aaa.id_kandang, aaa.periode   FROM `kandang_activity_log_panen` as aaa GROUP by aaa.nomorDO,aaa.id_kandang,aaa.periode) as tot where tot.id_kandang = b.id_kandang and tot.periode = b.periode)";
            $querydresume = "SELECT
                  DATEDIFF(e.tanggal, {$tanggal_chickin}) as umur,
                  {$tanggal_chickin} as tanggal_chickin,
                  b.id_kandang,
                  b.periode,
                  b.strain,
                  IFNULL(ROUND(c.deplesi/b.populasi_awal*100,2),0) as deplesi_persent,
                  c.deplesi,
                  b.populasi_awal - IFNULL(c.deplesi,0) - IFNULL(f.panen_ekor,0) as populasi,
                  d.tot_feed,
                  e.bw as bw,
                  IFNULL(round((({$bw3}-{$bw0})/{$bw0}*100),0),0) as rg3,
                  IFNULL(round((({$bw7}-{$bw0})/{$bw0}*100),0),0) as rg7,
                  IFNULL(round(tot_feed * 50000 / (((b.populasi_awal - IFNULL(c.deplesi,0) - IFNULL(f.panen_ekor,0)) * e.bw)  + {$panen_kg} * 1000),3),0) as act_fcr,
                  IFNULL(round(e.bw / DATEDIFF(e.tanggal, e.tanggal_chickin)), 0) as act_adg,
                  IFNULL(round(((100 - round(c.deplesi/b.populasi_awal*100,2)) * (round(e.bw/1000,3)) * 100)/ (round(tot_feed * 50000 / (b.populasi_awal - c.deplesi) / e.bw,3) * DATEDIFF(e.tanggal, e.tanggal_chickin)),0),0) as ip
                  FROM kandang as a
                  LEFT JOIN kandang_activity as b ON a.id = b.id_kandang
                  LEFT JOIN (SELECT sum(total_mati) as deplesi, periode, id_kandang FROM kandang_activity_log GROUP by periode, id_kandang) as c on c.periode = b.periode and c.id_kandang = b.id_kandang
                  LEFT JOIN (SELECT sum(qty) as tot_feed, periode, id_kandang FROM kandang_activity_log_sapronak where type_sapronak = 'pakan' and method_sapronak = 'use' GROUP by periode, id_kandang) as d on d.periode = b.periode and d.id_kandang = b.id_kandang
                  LEFT JOIN (SELECT aa.* from kandang_activity_log as aa where tanggal = ( SELECT max(tanggal) FROM kandang_activity_log WHERE periode = aa.periode and id_kandang = aa.id_kandang) GROUP by aa.id_kandang, aa.periode) as e on e.periode = b.periode and e.id_kandang = b.id_kandang
                  LEFT JOIN (SELECT sum(qty_ekor) as panen_ekor, sum(qty_kg) as panen_kg, periode, id_kandang from kandang_activity_log_panen GROUP by id_kandang,periode) as f on f.periode = b.periode and f.id_kandang = b.id_kandang
                  where a.id ='{$idkandang}' AND b.periode = '{$periode}'";
            $querydresume = "SELECT
            DATEDIFF(e.tanggal, k.tanggal_mulai) as umur,
            k.tanggal_mulai as tanggal_chickin,
            b.id_kandang,
            b.periode,
            b.strain,
            IFNULL(ROUND(c.deplesi/b.populasi_awal*100,2),0) as deplesi_persent,
            c.deplesi,
            b.populasi_awal - IFNULL(c.deplesi,0) - IFNULL(f.panen_ekor,0) as populasi,
            d.tot_feed,
            e.bw as bw,
            IFNULL(round((((kal3.bw - kal1.bw) / kal1.bw) * 100),0),0) as rg3,
            IFNULL(round((((kal7.bw - kal1.bw) / kal1.bw) * 100),0),0) as rg7,
            IFNULL(round((d.tot_feed * 50000) / (((b.populasi_awal - IFNULL(c.deplesi,0) - IFNULL(f.panen_ekor,0)) * e.bw)  + (tot.kg * 1000)),3),0) as act_fcr,
            IFNULL(round((e.bw / DATEDIFF(e.tanggal, e.tanggal_chickin)), 0),0) as act_adg,
            IFNULL(round(((100 - round(c.deplesi/b.populasi_awal*100,2)) * (round(e.bw/1000,3)) * 100) / (round((d.tot_feed * 50000) / (b.populasi_awal - c.deplesi) / e.bw,3) * DATEDIFF(e.tanggal, e.tanggal_chickin)),0),0) as ip
            FROM kandang as a
            LEFT JOIN kandang_activity as b ON a.id = b.id_kandang
            LEFT JOIN (SELECT sum(total_mati) as deplesi, periode, id_kandang FROM kandang_activity_log GROUP by periode, id_kandang) as c on c.periode = b.periode and c.id_kandang = b.id_kandang
            LEFT JOIN (SELECT sum(qty) as tot_feed, periode, id_kandang FROM kandang_activity_log_sapronak where type_sapronak = 'pakan' and method_sapronak = 'use' GROUP by periode, id_kandang) as d on d.periode = b.periode and d.id_kandang = b.id_kandang
            LEFT JOIN (SELECT id_kandang, periode, max(tanggal) as max_tanggal FROM kandang_activity_log GROUP by id_kandang, periode) as latest_log on latest_log.id_kandang = b.id_kandang and latest_log.periode = b.periode
            LEFT JOIN kandang_activity_log as kal1 on kal1.id_kandang = b.id_kandang and kal1.periode = b.periode and kal1.tanggal = latest_log.max_tanggal
            LEFT JOIN kandang_activity_log as kal3 on kal3.id_kandang = b.id_kandang and kal3.periode = b.periode and kal3.tanggal = DATE_ADD(latest_log.max_tanggal, INTERVAL 3 DAY)
            LEFT JOIN kandang_activity_log as kal7 on kal7.id_kandang = b.id_kandang and kal7.periode = b.periode and kal7.tanggal = DATE_ADD(latest_log.max_tanggal, INTERVAL 7 DAY)
            LEFT JOIN (SELECT sum(qty_kg) as kg, id_kandang, periode FROM kandang_activity_log_panen GROUP by id_kandang, periode) as tot on tot.id_kandang = b.id_kandang and tot.periode = b.periode
            LEFT JOIN (SELECT sum(qty_ekor) as panen_ekor, periode, id_kandang from kandang_activity_log_panen GROUP by id_kandang,periode) as f on f.periode = b.periode and f.id_kandang = b.id_kandang
            LEFT JOIN (SELECT id_kandang, periode, tanggal_chickin, bw, tanggal FROM kandang_activity_log) as e on e.periode = b.periode and e.id_kandang = b.id_kandang
            LEFT JOIN (SELECT id_kandang, periode, tanggal_mulai FROM kandang_activity) as k on k.id_kandang = b.id_kandang and k.periode = b.periode
            WHERE a.id = '{$idkandang}' AND b.periode = '{$periode}'";
            $dataresume = $this->MData->customrow($querydresume);
        }
        return $dataresume;
    }

    // public function dataresume_api($kandangperiode, $token, $user_id)
    // {
    //     $url = $this->config->item('api_url') . "ternak2/dataresumetop";

    //     $curl = curl_init();

    //     curl_setopt_array($curl, array(
    //         CURLOPT_URL => $url,
    //         CURLOPT_RETURNTRANSFER => true,
    //         CURLOPT_ENCODING => '',
    //         CURLOPT_MAXREDIRS => 10,
    //         CURLOPT_TIMEOUT => 30,
    //         // CURLOPT_FOLLOWLOCATION => true,
    //         CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    //         CURLOPT_CUSTOMREQUEST => 'POST',
    //         CURLOPT_POSTFIELDS => http_build_query(array('token' => $token, 'user_id' => $user_id, 'kandangperiode' => $kandangperiode)),
    //         CURLOPT_HTTPHEADER => array(
    //             "Accept: */*",
    //             "Content-Type: application/x-www-form-urlencoded",
    //             "User-Agent: Thunder Client (https://www.thunderclient.com)"
    //         ),
    //     ));

    //     $response = curl_exec($curl);
    //     return $response;
    //     curl_close($curl);
    // }
    public function getstock($stock, $idkandang, $periode)
    {
        switch ($stock) {
            case 'pakan':
                $getstokpakan = $this->MData->customresult("SELECT a.id,
                a.tanggal_kandang_activity_log as tanggal,
                a.harga, a.qty, b.brand as jenis, round(a.harga*a.qty,0) as harga_tot
                FROM `kandang_activity_log_sapronak` as a
                LEFT JOIN pakan as b on a.id_this = b.id
                WHERE type_sapronak = 'pakan' and method_sapronak = 'in' and a.id_kandang = '{$idkandang}' AND a.periode = '{$periode}' ORDER BY a.tanggal_kandang_activity_log DESC");
                return $getstokpakan;
                break;

            case 'ovk':
                $getstokovk = $this->MData->customresult("SELECT a.id,
                a.tanggal_kandang_activity_log as tanggal,
                a.harga, a.qty, b.brand as jenis, round(a.harga*a.qty,0) as harga_tot
                FROM `kandang_activity_log_sapronak` as a
                LEFT JOIN obat as b on a.id_this = b.id
                WHERE type_sapronak = 'ovk' and method_sapronak = 'in' and a.id_kandang = '{$idkandang}' AND a.periode = '{$periode}' ORDER BY a.tanggal_kandang_activity_log DESC");
                return $getstokovk;
                break;
            case 'general':
                $getstokgeneral = $this->MData->customresult("SELECT a.id,
                    a.tanggal_kandang_activity_log as tanggal,
                    a.harga, a.qty, b.brand as jenis, round(a.harga*a.qty,0) as harga_tot, b.satuan
                    FROM `kandang_activity_log_sapronak` as a
                    LEFT JOIN general as b on a.id_this = b.id
                    WHERE type_sapronak = 'general' and method_sapronak = 'in' and a.id_kandang = '{$idkandang}' AND a.periode = '{$periode}' ORDER BY a.tanggal_kandang_activity_log DESC");
                return $getstokgeneral;
                break;
            case 'bop':
                $getdatabop = $this->MData->customresult("SELECT
                        a.tanggal,
                        a.harga, a.qty, a.satuan, round(a.harga*a.qty,0) as harga_tot, a.id, a.ket
                        FROM `kandang_activity_log_bop` as a
                        WHERE a.id_kandang = '{$idkandang}' AND a.periode = '{$periode}' ORDER BY a.tanggal DESC");
                return $getdatabop;
                break;
            default:
                echo json_encode(['status' => false, 'message' => 'wrong command']);
                break;
        }
    }
    public function getdataharian()
    {
        $panen_kg = "IFNULL((SELECT sum(qty_kg) FROM `kandang_activity_log_panen` WHERE id_kandang = a.id_kandang and periode = a.periode and tanggal <= a.tanggal),0)";
        $panen_ekor = "IFNULL((SELECT sum(qty_ekor) FROM `kandang_activity_log_panen` WHERE id_kandang = a.id_kandang and periode = a.periode and tanggal <= a.tanggal),0)";
        $populasi = "((SELECT populasi_awal from kandang_activity WHERE id_kandang = a.id_kandang and periode = a.periode) - IFNULL((SELECT sum(total_mati) FROM `kandang_activity_log` WHERE id_kandang = a.id_kandang and periode = a.periode and tanggal <= a.tanggal),0) - {$panen_ekor})";
        $tot_feed = "((SELECT sum(qty) from kandang_activity_log_sapronak WHERE id_kandang = a.id_kandang and periode = a.periode and type_sapronak = 'pakan' and method_sapronak = 'use' and tanggal_kandang_activity_log = a.tanggal))";
        $tot_feed_fcr = "((SELECT sum(qty) from kandang_activity_log_sapronak WHERE id_kandang = a.id_kandang and periode = a.periode and type_sapronak = 'pakan' and method_sapronak = 'use' and tanggal_kandang_activity_log <= a.tanggal))";
        $std_bw_0_harian = "(SELECT bw FROM `std_bw` where strain = '{$getactivitydetail->strain}' AND day = 0)";
        $act_bw_0_harian = "(SELECT bw FROM `kandang_activity_log` where id_kandang = '{$idkandang}' AND periode = '{$periode}' AND tanggal = tanggal_chickin)";
        $nekropsidata = $this->MData->selectdatawhereresult('nekropsi', array('nekropsi_kandang' => $idkandang, 'nekropsi_periode' => $periode));
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
              ({$populasi}) as populasi,
              ({$tot_feed}) as qty_feed,
              IFNULL(round({$tot_feed_fcr} * 50000 / ({$populasi} + {$panen_ekor}) / a.bw,3), 0) as act_fcr_lama,
              IFNULL(round({$tot_feed_fcr} * 50000 / (({$populasi} * a.bw) + ({$panen_kg} *1000)) ,3), 0) as act_fcr,
              IFNULL(round(b.fcr,3), 0) as std_fcr,
              IFNULL(round({$tot_feed} * 50000 / {$populasi},3), 0) as act_feed_intake,
              IFNULL(round(c.feedintake,3), 0) as std_feed_intake,
              IFNULL(round(a.bw / DATEDIFF(a.tanggal, a.tanggal_chickin)), 0) as act_adg,
              IF(a.mati >= round(d.populasi_awal * 0.01 ,0),a.mati,NULL) as ews_mati,
              IF({$act_bw_0_harian}<{$std_bw_0_harian}, round(({$act_bw_0_harian} / {$std_bw_0_harian} * c.bw),0), c.bw) as std_bw,
              IFNULL(round(IF({$act_bw_0_harian}<{$std_bw_0_harian}, round(({$act_bw_0_harian} / {$std_bw_0_harian} * c.bw),0), c.bw)/DATEDIFF(a.tanggal, a.tanggal_chickin),2), 0) as std_adg,
              IFNULL((SELECT ket from kandang_activity_log_ews where type_ews = 'mati' and id_kandang = a.id_kandang and periode = a.periode and tanggal = a.tanggal ORDER by id desc limit 1),NULL) as ket_ews_mati,
              IFNULL((SELECT ket from kandang_activity_log_ews where type_ews = 'bw' and id_kandang = a.id_kandang and periode = a.periode and tanggal = a.tanggal ORDER by id desc limit 1),NULL) as ket_ews_bw,
              IFNULL((SELECT id from kandang_activity_log_ews where type_ews = 'mati' and id_kandang = a.id_kandang and periode = a.periode and tanggal = a.tanggal ORDER by id desc limit 1),NULL) as id_ews_mati,
              IFNULL((SELECT id from kandang_activity_log_ews where type_ews = 'bw' and id_kandang = a.id_kandang and periode = a.periode and tanggal = a.tanggal ORDER by id desc limit 1),NULL) as id_ews_bw
              FROM `kandang_activity_log` as a
              LEFT JOIN (SELECT * from std where strain = '{$getactivitydetail->strain}') as b on b.bw = a.bw
              LEFT JOIN (SELECT * from std_bw WHERE strain = '{$getactivitydetail->strain}') as c on c.day = DATEDIFF(a.tanggal, a.tanggal_chickin)
              LEFT JOIN kandang_activity as d on d.periode = a.periode and d.id_kandang = a.id_kandang
              WHERE a.id_kandang = '{$idkandang}' AND a.periode = '{$periode}' ORDER BY a.tanggal DESC";
        $getdataharian = $this->MData->customresult($getdataharian_query);
        return $getdataharian;
    }
}

/* End of file MSql.php */
