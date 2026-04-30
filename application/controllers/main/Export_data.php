<?php

defined('BASEPATH') or exit('No direct script access allowed');
Sentry\init(['dsn' => 'https://4dba7b441a7ff5576bdc44cf8098b987@o4504875505483776.ingest.sentry.io/4506318591950848']);
class Export_data extends CI_Controller
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
        // $getdatauser = $this->MData->customresult("SELECT * FROM `kandang` LEFT JOIN users as a on kandang.user_id = a.id where a.id_company = 1  GROUP by user_id ORDER BY `a`.`first_name` ASC");
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
        // var_dump($result);
        // exit;
        $data = array(
            'title' => 'Export Data',
            'content' => 'export_data',
            'getdatauser' => isset($result) ? (object)$result : null,
        );
        $this->load->view('main/template', $data);
    }
    public function get_data_export_data_panen()
    {
        $id_user = $_POST['id_user'];
        $status = $_POST['status'];
        $tahun = $_POST['tahun'];
        $bulan = $_POST['bulan'];

        $id_user_value = implode(",", $id_user);
        $bulan_value = implode(",", $bulan);
        $select_id = "SELECT id FROM kandang_activity where id_kandang in ($id_user_value) and status_kandang_activity = '{$status}' and Year(tanggal_mulai) = {$tahun} and Month(tanggal_mulai) in ({$bulan_value})";
        $queryexport_data_panen = "SELECT b.tanggal, concat(c.kode_do,b.nomorDO) as nomorDO, b.nomor_mobil, c.nama, a.periode, b.kodebakul, b.namapembeli, b.totekor, b.nomornota,
        ifNULL(round(b.totgram - b.beratkeranjang,3),0) as totgram, b.susut, ifNULL(round(b.totgram - b.beratkeranjang- ifNULL(b.susut,0),3),0) as nett, b.kondisiayam from kandang_activity as a
    LEFT JOIN (SELECT *, SUM(qty_ekor) as totekor, SUM(qty_kg) as totgram FROM kandang_activity_log_panen group by id_kandang,periode,tanggal,nomorDO) as b on a.id_kandang = b.id_kandang and a.periode = b.periode
    LEFT JOIN kandang as c on a.id_kandang = c.id
    where a.id in ({$select_id})";
        // var_dump($queryexport_data_panen);
        // exit;
        $dataexport_data_panen = $this->MData->customresult($queryexport_data_panen);
        echo json_encode($dataexport_data_panen);
    }
    public function get_data_export_data_status()
    {
        $id_user = $_POST['id_user'];
        $status = $_POST['status'];
        $tahun = $_POST['tahun'];
        $bulan = $_POST['bulan'];

        $id_user_value = implode(",", $id_user);
        $bulan_value = implode(",", $bulan);
        $select_id = "SELECT id FROM kandang_activity where id_kandang in ($id_user_value) and status_kandang_activity = '{$status}' and Year(tanggal_mulai) = {$tahun} and Month(tanggal_mulai) in ({$bulan_value})";
        $queryexport_data = "SELECT * FROM `kandang_activity` as a
    LEFT JOIN kandang as b on a.id_kandang = b.id
    where a.id in ({$select_id})
    ORDER BY `id_kandang` ASC";
        $dataexport_data = $this->MData->customresult($queryexport_data);
        echo json_encode($dataexport_data);
    }
    public function get_data_export_data_lhk()
    {
        $id_user = $_POST['id_user'];
        $status = $_POST['status'];
        $tahun = $_POST['tahun'];
        $bulan = $_POST['bulan'];

        $id_user_value = implode(",", $id_user);
        $bulan_value = implode(",", $bulan);
        $select_id = "SELECT id FROM kandang_activity where id_kandang in ($id_user_value) and status_kandang_activity = '{$status}' and Year(tanggal_mulai) = {$tahun} and Month(tanggal_mulai) in ({$bulan_value})";
        $pakan_q = "(SELECT sum(qty) from kandang_activity_log_sapronak where id_kandang = a.id_kandang and periode = a.periode and tanggal_kandang_activity_log = b.tanggal and type_sapronak = 'pakan' and method_sapronak = 'use' and id_this = ";
        $pakan_other = "(SELECT sum(qty) from kandang_activity_log_sapronak where id_kandang = a.id_kandang and periode = a.periode and tanggal_kandang_activity_log = b.tanggal and type_sapronak = 'pakan' and method_sapronak = 'use' and id_this not in (34,37,40,43,46,49,52,55)) as other_feed ";
        $sb21cr = "{$pakan_q} 34) as sb21cr";
        $sb20 = "{$pakan_q} 37) as sb20";
        $br0 = "{$pakan_q} 40) as br0";
        $sb21p = "{$pakan_q} 43) as sb21p";
        $br1cr = "{$pakan_q} 46) as br1cr";
        $br1p = "{$pakan_q} 49) as br1p";
        $sb22 = "{$pakan_q} 52) as sb22";
        $br2 = "{$pakan_q} 55) as br2";
        $queryexport_data_lhk = "SELECT c.nama,a.periode,c.alamat,b.bw,b.mati,b.culling,
        {$sb21cr}, {$sb20}, {$br0}, {$sb21p}, {$br1cr}, {$br1p}, {$sb22}, {$br2}, {$pakan_other},
        DATEDIFF(b.tanggal, a.tanggal_mulai) as umur FROM kandang_activity as a
    left join kandang_activity_log as b on a.id_kandang = b.id_kandang and a.periode = b.periode
    LEFT JOIN kandang as c on a.id_kandang = c.id
    where a.id in ({$select_id})";
        // var_dump($queryexport_data_lhk) ;
        // exit;
        $dataexport_data_lhk = $this->MData->customresult($queryexport_data_lhk);
        echo json_encode($dataexport_data_lhk);
    }
}
