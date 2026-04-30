<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Resume_close extends CI_Controller
{

    public $cookiex;
    public function __construct()
    {
        parent::__construct();
        $this->load->model('MData');
        $this->load->model('MThirdApp');
        $this->MThirdApp->checksession();
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
            $result[] = array(
                "nama_user" => $lastdata,
                "id_kandang" => $data,
            );
        }
        $gettahun = $this->MData->customresult("SELECT  Year(tanggal_mulai) as tahun FROM `kandang_activity` GROUP by year(tanggal_mulai)");
        $data = array(
            'title' => 'Resume Close',
            'content' => 'resume_close',
            // 'getdatauser' => $getdatauser,
            'getdatauser' => (object)$result,
            'gettahun' => $gettahun,
        );
        $this->load->view('main/template', $data);
    }
    public function get_data_resume_close()
    {
        // $panen_kg = "(SELECT sum(qty_kg) as panen_kg from kandang_activity_log_panen where periode = b.periode and id_kandang = b.id_kandang)";
        $id_user = $_POST['id_user'];
        $id_user_value = implode(",", $id_user);
        $filterdate = $_POST['tahun'];
        list($startDate, $endDate) = array_map(function ($date) {
            return date("Y-m-d", strtotime($date));
        }, explode(" - ", $filterdate));
        $resultArray = compact('startDate', 'endDate');

        // $tahun = $_POST['tahun'];
        $deplesi = "(SELECT sum(total_mati) as deplesi FROM kandang_activity_log where periode = b.periode and id_kandang = b.id_kandang)";
        $tot_feed = "(SELECT sum(qty) as tot_feed FROM kandang_activity_log_sapronak where type_sapronak = 'pakan' and method_sapronak = 'use' and periode = b.periode and id_kandang = b.id_kandang)";
        $tot_sekam = "(SELECT sum(qty) as tot_sekam FROM kandang_activity_log_sapronak where type_sapronak = 'general' and method_sapronak = 'use' and id_this in (3,4) and periode = b.periode and id_kandang = b.id_kandang) as total_sekam,";
        $tot_lpg = "(SELECT sum(qty) as tot_lpg FROM kandang_activity_log_sapronak where type_sapronak = 'general' and method_sapronak = 'use'  and id_this in (1,2) and periode = b.periode and id_kandang = b.id_kandang) as total_lpg,";
        $panen_ekor = "(SELECT sum(qty_ekor) as panen_ekor from kandang_activity_log_panen where periode = b.periode and id_kandang = b.id_kandang)";
        $panen_kg = "(SELECT round(sum(tot_kg) - sum(beratkeranjang) - sum(susut),3) as kg from (SELECT aaa.susut, aaa.beratkeranjang, sum(aaa.qty_kg) as tot_kg, aaa.id_kandang, aaa.periode  FROM `kandang_activity_log_panen` as aaa GROUP by aaa.nomorDO,aaa.id_kandang,aaa.periode) as tot where tot.id_kandang = b.id_kandang and tot.periode = b.periode)";
        $std_fcr = "round((SELECT fcr FROM `std` Where bw = IFNULL(round({$panen_kg}/{$panen_ekor}*1000,0),0) and strain = b.strain),3)";
        $tgl_awal_panen = "(SELECT min(tanggal) as tgl_awal_panen FROM kandang_activity_log_panen where periode = b.periode and id_kandang = b.id_kandang)";
        $tgl_akhir_panen = "(SELECT max(tanggal) as tgl_akhir_panen FROM kandang_activity_log_panen where periode = b.periode and id_kandang = b.id_kandang)";
        $umur_rata_panen = "(SELECT round(sum(DATEDIFF(bb.tanggal, (SELECT tanggal_chickin from kandang_activity_log WHERE periode = bb.periode and id_kandang = bb.id_kandang order by id DESC limit 1 ))*qty_ekor)/sum(qty_ekor),0) as umur_rata_panen  FROM `kandang_activity_log_panen` as bb where bb.periode = b.periode and bb.id_kandang = b.id_kandang)";
        $bw3 = "(SELECT bw FROM `kandang_activity_log` WHERE periode = b.periode and id_kandang = b.id_kandang and tanggal = tanggal_chickin + INTERVAL 3 DAY)";
        $bw7 = "(SELECT bw FROM `kandang_activity_log` WHERE periode = b.periode and id_kandang = b.id_kandang and tanggal = tanggal_chickin + INTERVAL 7 DAY)";
        $bw0 = "(SELECT bw FROM `kandang_activity_log` WHERE periode = b.periode and id_kandang = b.id_kandang and tanggal = tanggal_chickin)";
        $queryresume = "SELECT
    b.id as status_id,
    b.populasi_awal,
    b.tanggal_mulai as tanggal_chickin,
    b.status_kandang_activity as status_kandang,
    a.nama,
    a.foto,
    b.id_kandang,
    b.periode,
    b.strain,
    {$deplesi} as deplesi,
    round({$deplesi}/b.populasi_awal*100,2) as deplesi_persent,
    {$tot_feed} as tot_feed,
    {$tot_sekam}
    {$tot_lpg}
    {$panen_ekor} as panen_ekor,
    round({$panen_kg},3) as panen_kg,
    IFNULL(round({$panen_kg}/{$panen_ekor}*1000,0),0) as bw,
    IFNULL(round({$tot_feed} * 50 / {$panen_kg},3),0) as act_fcr,
    IFNULL(round((({$bw3}-{$bw0})/{$bw0}*100),0),0) as rg3,
    IFNULL(round((({$bw7}-{$bw0})/{$bw0}*100),0),0) as rg7,
    {$std_fcr} as std_fcr,
    round(((IFNULL(round({$tot_feed} * 50 / {$panen_kg},3),0) / {$std_fcr}) - 1) * 100,2) as diff_fcr,
    {$tgl_awal_panen} as tgl_awal_panen,
    {$tgl_akhir_panen} as tgl_akhir_panen,
    {$umur_rata_panen} as umur_rata_panen,
    100 - round({$deplesi}/b.populasi_awal*100,2) as daya_hidup,
    IFNULL(round(((100 - round({$deplesi}/b.populasi_awal*100,2))*{$panen_kg}/{$panen_ekor}*100)/(round({$tot_feed} * 50 / {$panen_kg},3)*{$umur_rata_panen}),0),0) as ip
    FROM kandang as a
    LEFT JOIN kandang_activity as b ON a.id = b.id_kandang
    where a.id in ({$id_user_value}) AND b.status_kandang_activity = 'CLOSE' 
    and b.tanggal_mulai between '{$resultArray['startDate']}' and '{$resultArray['endDate']}'";
        $dataresumeclose = $this->MData->customresult($queryresume);
        echo json_encode($dataresumeclose);
    }


    public function openkandang()
    {
        if (isset($_POST['status_id'])) {
            $id = $_POST['status_id'];
            $id_kandang = $_POST['id_kandang'];
            $this->MData->edit(array('id_kandang' => $id_kandang), 'kandang_activity', array('status_kandang_activity' => 'CLOSE'));
            $this->MData->edit(array('id' => $id), 'kandang_activity', array('status_kandang_activity' => 'AKTIF'));
            $this->MData->edit(array('id' => $id_kandang), 'kandang', array('status_kandang' => 'AKTIF'));
            $status = 'success';
            $comment = 'Data berhasil diupdate';
        } else {
            $status = 'error';
            $comment = 'Gagal update Data';
        }


        $result = array(
            "status" => $status,
            "comment" => $comment,
        );
        echo json_encode($result);
    }
}
