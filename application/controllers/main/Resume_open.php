<?php

defined('BASEPATH') or exit('No direct script access allowed');
Sentry\init(['dsn' => 'https://4dba7b441a7ff5576bdc44cf8098b987@o4504875505483776.ingest.sentry.io/4506318591950848']);
class Resume_open extends CI_Controller
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
        $result = [];
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
        $data = array(
            'title' => 'Resume Open',
            'content' => 'resume_open',
            // 'getdatauser' => $getdatauser,
            'getdatauser' => (object)$result,
            'session2' => $this->cookiex['role'],
        );
        $this->load->view('main/template', $data);
    }
    public function get_data_resume_open()
    {
        $id_user = $_POST['id_user'];
        $id_user_value = implode(",", $id_user);
        // var_dump($id_user_value);

        $tanggal_chickin = "(SELECT tanggal_mulai FROM `kandang_activity` where id_kandang = a.id and periode = b.periode)";
        $bw3 = "(SELECT bw FROM `kandang_activity_log` WHERE periode = b.periode and id_kandang = b.id_kandang and tanggal = tanggal_chickin + INTERVAL 3 DAY)";
        $bw7 = "(SELECT bw FROM `kandang_activity_log` WHERE periode = b.periode and id_kandang = b.id_kandang and tanggal = tanggal_chickin + INTERVAL 7 DAY)";
        $bw0 = "(SELECT bw FROM `kandang_activity_log` WHERE periode = b.periode and id_kandang = b.id_kandang and tanggal = tanggal_chickin)";
        $panen_kg = "(SELECT round(sum(tot_kg) - sum(beratkeranjang) - sum(susut),3) as kg from (SELECT aaa.susut, aaa.beratkeranjang, sum(aaa.qty_kg) as tot_kg, aaa.id_kandang, aaa.periode  FROM `kandang_activity_log_panen` as aaa GROUP by aaa.nomorDO,aaa.id_kandang,aaa.periode) as tot where tot.id_kandang = b.id_kandang and tot.periode = b.periode)";
        $act_fcr = "IFNULL(round(tot_feed * 50000 / (((b.populasi_awal - IFNULL(c.deplesi,0) - IFNULL(f.panen_ekor,0)) * e.bw) + + (IFNULL({$panen_kg},0) * 1000)),3),0)";
        $queryresume = "SELECT
    DATEDIFF(e.tanggal, {$tanggal_chickin}) as umur,
    DATEDIFF(now(), {$tanggal_chickin}) as umur_saat_ini,
    {$tanggal_chickin} as tanggal_chickin,
    a.nama,
    b.status_kandang_activity as status_kandang,
    b.id as status_id,
    b.id_kandang,
    b.strain,
    b.periode,
    c.deplesi,
    IFNULL(ROUND(c.deplesi/b.populasi_awal*100,2),0) as deplesi_persent,
    b.populasi_awal - IFNULL(c.deplesi,0) - IFNULL(f.panen_ekor,0) as populasi,
    d.tot_feed,
    e.bw as bw,
    IFNULL(round((({$bw3}-{$bw0})/{$bw0}*100),0),0) as rg3,
    IFNULL(round((({$bw7}-{$bw0})/{$bw0}*100),0),0) as rg7,
    {$act_fcr} as act_fcr,
    IFNULL(round(e.bw / DATEDIFF(e.tanggal, e.tanggal_chickin)), 0) as act_adg,
    IFNULL(round(((100 - round(c.deplesi/b.populasi_awal*100,2)) * (round(e.bw/1000,3)) * 100)/ (round(tot_feed * 50000 / (b.populasi_awal - c.deplesi) / e.bw,3) * DATEDIFF(e.tanggal, e.tanggal_chickin)),0),0) as ip,
     b.pic,
    if(a.id_lokasi != 0, g.location, h.first_name) as lokasi_kandang
    FROM kandang as a
    LEFT JOIN kandang_activity as b ON a.id = b.id_kandang
    LEFT JOIN (SELECT sum(total_mati) as deplesi, periode, id_kandang FROM kandang_activity_log GROUP by periode, id_kandang) as c on c.periode = b.periode and c.id_kandang = b.id_kandang
    LEFT JOIN (SELECT sum(qty) as tot_feed, periode, id_kandang FROM kandang_activity_log_sapronak where type_sapronak = 'pakan' and method_sapronak = 'use' GROUP by periode, id_kandang) as d on d.periode = b.periode and d.id_kandang = b.id_kandang
    LEFT JOIN (SELECT aa.* from kandang_activity_log as aa where tanggal = ( SELECT max(tanggal) FROM kandang_activity_log WHERE periode = aa.periode and id_kandang = aa.id_kandang) GROUP by aa.id_kandang, aa.periode) as e on e.periode = b.periode and e.id_kandang = b.id_kandang
    LEFT JOIN (SELECT sum(qty_ekor) as panen_ekor, sum(qty_kg) as panen_kg, periode, id_kandang from kandang_activity_log_panen GROUP by id_kandang,periode) as f on f.periode = b.periode and f.id_kandang = b.id_kandang
    LEFT JOIN `company_sub` as g on a.id_lokasi = g.id
    LEFT JOIN `users` as h on a.user_id = h.id
    where a.id in ({$id_user_value}) AND b.status_kandang_activity = 'AKTIF'";
        // echo $queryresume;
        // exit;
        $dataresumeopen = $this->MData->customresult($queryresume);
        echo json_encode($dataresumeopen);
    }

    public function closekandang()
    {
        if (isset($_POST['status_id'])) {
            $id = $_POST['status_id'];
            $id_kandang = $_POST['id_kandang'];
            // $this->MData->edit(array('id_kandang' => $id_kandang), 'kandang_activity', array('status_kandang_activity' => 'CLOSE'));
            $this->MData->edit(array('id' => $id), 'kandang_activity', array('status_kandang_activity' => 'CLOSE'));
            $this->MData->edit(array('id' => $id_kandang), 'kandang', array('status_kandang' => 'CLOSE'));
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
