<?php

defined('BASEPATH') or exit('No direct script access allowed');
Sentry\init(['dsn' => 'https://4dba7b441a7ff5576bdc44cf8098b987@o4504875505483776.ingest.sentry.io/4506318591950848']);
class Fcr extends CI_Controller
{
    public $cookiex;
    public function __construct()
    {
        parent::__construct();
        $this->load->model('MData');
        $this->load->model('MThirdApp');
        // $this->MThirdApp->checksession();
        $this->load->library('Dummy');
        $this->cookiex = getcookienya('user_data');
    }

    public function index()
    {
        $id_user = $this->cookiex['user_id'];
        // $getdatauser = $this->MData->customresult("SELECT a.id,a.periode,a.status_kandang_activity as status, b.nama, b.nama as first_name FROM `kandang_activity` as a left join kandang as b on a.id_kandang = b.id ORDER BY b.nama,a.periode ASC");
        $getdatauser = $this->MThirdApp->listkandang_new($id_user);
        // echo('asdas'); exit;
        $getdatauser_kandang = $this->MData->customresult("SELECT a.id,a.periode,a.status_kandang_activity as status, b.nama, b.nama as first_name FROM `kandang_activity` as a left join kandang as b on a.id_kandang = b.id ORDER BY b.nama,a.periode ASC");


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
            'title' => 'FCR All',
            'content' => 'fcr',
            'getdatauser' => isset($result) ? (object)$result : null,
            'getdatauser_kandang' => $getdatauser_kandang,

        );
        // echo json_encode($getdatauser);
        $this->load->view('main/template', $data);
    }

    public function calculate()
    {
        $result = []; // Array untuk menyimpan hasil JSON
        $summary = [];
        $detail = [];
        $all_ids = array_merge(...array_map(function ($item) {
            return explode(',', $item); // Pisahkan setiap string dengan koma dan ubah menjadi array
        }, $_POST['id']));
        $id_kandang_list = implode(",", array_map('intval', $all_ids));

        // Ubah nilai dalam array menjadi integer
        switch ($_POST['status']) {
            case 'open':
                $status = "and status_kandang_activity = 'OPEN'";
                break;
            case 'close':
                $status = "and status_kandang_activity = 'CLOSE'";
                break;
            case 'all':
                $status = "";
                break;
            default:
                echo ('salah status kandang');
                exit;
                break;
        }
        $tahun_mulai = $_POST['tahun_mulai'];
        $tahun_akhir = $_POST['tahun_akhir'];

        if ($tahun_akhir < $tahun_mulai) {
            echo ('salah pilih tahun');
            exit;
        }

        $query_id_activity = "SELECT id FROM `kandang_activity` WHERE id_kandang in ($id_kandang_list) $status AND YEAR(tanggal_mulai) BETWEEN '$tahun_mulai' AND '$tahun_akhir'";
        // echo($query_id_activity); exit;
        $id_activity = $this->MData->customresult($query_id_activity);
        if (empty($id_activity)) {
            echo ('data tidak ditemukan');
            exit;
        }

        //ini buat dummy test
        // $id_kandang_list = '6388, 6389, 6355';
        // $lokasi = "SELECT c.first_name AS first_name FROM `kandang_activity` AS a JOIN kandang AS b ON a.id_kandang = b.id JOIN users as c on b.user_id = c.id WHERE a.id IN ($id_kandang_list) GROUP BY c.first_name";

        //ini buat real, id nya sesuai id_kandang
        $lokasi = "SELECT b.location FROM `kandang` a join company_sub as b on a.id_lokasi = b.id WHERE a.id IN ($id_kandang_list) group by b.location";
        $q_lokasi = $this->MData->customarray($lokasi);

        $ids = array_map(function ($item) {
            return $item->id; // Ambil nilai 'id' dari objek
        }, $id_activity);
        $id_list = implode(",", $ids);
        $panen_kg = "(SELECT round(sum(tot_kg) - sum(beratkeranjang) - sum(susut),3) as kg from (SELECT aaa.susut, aaa.beratkeranjang, sum(aaa.qty_kg) as tot_kg, aaa.id_kandang, aaa.periode  FROM `kandang_activity_log_panen` as aaa GROUP by aaa.nomorDO,aaa.id_kandang,aaa.periode) as tot where tot.id_kandang = aa.id_kandang and tot.periode = aa.periode)";

        $query = "SELECT gg.location as location,
                    aa.id_kandang, aa.strain,
                    aa.periode,
                    bb.nama AS nama_kandang,
                    IFNULL(ROUND(SUM(cc.deplesi) / SUM(cc.populasi_awal) * 100, 2), 0) AS deplesi,
                    SUM(cc.populasi_awal) AS populasi_awal,
                    IFNULL(SUM(dd.qty) * 50, 0) AS pakan,
                    IFNULL(SUM(ee.panen_ekor), 0) AS panen_ekor,
                    round({$panen_kg},3) as panen_kg,
                    IFNULL(ROUND(SUM(ff.umur_x_panen_ekor) / NULLIF(SUM(ff.panen_ekor), 0)), 0) AS umur_panen,
                    ff.umur_x_panen_ekor as umur_x_panen_ekor
                FROM kandang_activity AS aa
                LEFT JOIN kandang AS bb 
                    ON aa.id_kandang = bb.id
                LEFT JOIN (
                    SELECT
                        a.id,
                        a.id_kandang,
                        a.periode,
                        SUM(b.culling + b.mati) AS deplesi,
                        a.populasi_awal
                    FROM kandang_activity AS a
                    LEFT JOIN kandang_activity_log AS b 
                        ON a.id_kandang = b.id_kandang 
                        AND a.periode = b.periode
                    GROUP BY a.id
                ) AS cc 
                    ON aa.id = cc.id
                LEFT JOIN (
                    SELECT 
                        id_kandang, 
                        periode, 
                        SUM(qty) AS qty 
                    FROM kandang_activity_log_sapronak 
                    WHERE type_sapronak = 'pakan' 
                    AND method_sapronak = 'use' 
                    GROUP BY id_kandang, periode
                ) AS dd 
                    ON aa.id_kandang = dd.id_kandang 
                    AND aa.periode = dd.periode
                LEFT JOIN (
                    SELECT 
                        id_kandang, 
                        periode, 
                        SUM(qty_ekor) AS panen_ekor, 
                        SUM(qty_kg) AS panen_kg, 
                        SUM(beratkeranjang) AS beratkeranjang, 
                        SUM(susut) AS susut
                    FROM kandang_activity_log_panen
                    GROUP BY id_kandang, periode
                ) AS ee 
                    ON aa.id_kandang = ee.id_kandang 
                    AND aa.periode = ee.periode
                LEFT JOIN (
                    SELECT 
                        a.id_kandang, 
                        a.periode, 
                        SUM(DATEDIFF(b.tanggal, a.tanggal_mulai) * b.qty_ekor) AS umur_x_panen_ekor, 
                        SUM(b.qty_ekor) AS panen_ekor
                    FROM kandang_activity AS a 
                    LEFT JOIN kandang_activity_log_panen AS b 
                        ON b.id_kandang = a.id_kandang 
                        AND b.periode = a.periode 
                    GROUP BY a.id_kandang, a.periode
                ) AS ff 
                    ON aa.id_kandang = ff.id_kandang 
                    AND aa.periode = ff.periode
                LEFT JOIN company_sub as gg ON bb.id_lokasi = gg.id
                WHERE aa.id IN ($id_list)
                GROUP BY aa.id 
                ORDER BY bb.nama, aa.periode ASC;
                ";

        // echo ($query);
        // exit;

        $q = $this->MData->customresult($query);

        $array_lokasi = json_decode(json_encode($q_lokasi), true);
        foreach ($array_lokasi as $lokasi) {
            $total_data = 0;
            $total_bw = 0;
            $total_pakan = 0;
            $total_panen_ekor = 0;
            $total_panen_kg = 0;
            $total_fcr_act = 0;
            $total_fcr_std = 0;
            $total_diff_fcr = 0;
            $total_populasi_awal = 0;
            $total_deplesi = 0;
            $total_umur_panen = 0;
            $total_daya_hidup = 0;
            $total_ip = 0;
            $strain = [];
            $detail = [];
            $strain_unique = [];
            foreach ($q as $data) {
                if ($data->location === $lokasi['location']) {
                    $total_data++;
                    $total_pakan += $data->pakan;
                    $total_panen_ekor += $data->panen_ekor;
                    $total_panen_kg += $data->panen_kg;
                    $total_populasi_awal += $data->populasi_awal;
                    $total_deplesi += $data->deplesi;
                    $strain[$data->strain] = true;

                    // Perhitungan BW
                    $bw = round((float)($data->panen_kg ?? 0) * 1000 / max((float)($data->panen_ekor ?? 1), 1), 0);
                    $total_bw += $bw;
                    // Query Standar FCR
                    $query_std = "SELECT fcr FROM std WHERE strain = '{$data->strain}' AND bw = '{$bw}'";
                    $datastd = $this->MData->customrow($query_std);

                    // Perhitungan FCR
                    $fcr_act = round(($data->pakan ?? 0) / max(($data->panen_kg ?? 1), 1), 3);
                    $total_fcr_act += $fcr_act;

                    $fcr_std = round(($datastd->fcr ?? 0), 3);
                    $total_fcr_std += $fcr_std;

                    // Perhitungan Diff FCR
                    $diff_fcr = round((($fcr_act / max($fcr_std, 1)) - 1) * 100, 2);
                    $total_diff_fcr += $diff_fcr;

                    // Perhitungan Daya Hidup
                    $daya_hidup = round(100 - ($data->deplesi ?? 0), 2);
                    $total_daya_hidup += $daya_hidup;
                    // Perhitungan Umur Panen (sudah di query)
                    $umur_panen = $data->umur_panen;
                    $total_umur_panen += $data->umur_panen;

                    // Perhitungan IP (Indeks Performa)
                    $ip = round($daya_hidup * $bw / 1000 / max($umur_panen, 1) / max($fcr_act, 1) * 100, 2);
                    $total_ip += $ip;
                    $strain_unique = array_keys($strain);
                    $detail[] = [
                        'loc' => $data->location,
                        'nama_kandang' => $data->nama_kandang,
                        'periode' => $data->periode,
                        'data' => [
                            'pakan' => $data->pakan ? number_format($data->pakan) : 0,
                            'panen_ekor' => $data->panen_ekor ? number_format($data->panen_ekor) : 0,
                            'panen_kg' => $data->panen_kg ? number_format($data->panen_kg) : 0,
                            'bw' =>  $bw ? number_format($bw) : 0,
                            'fcr_act' => $fcr_act,
                            'fcr_std' => $fcr_std,
                            'diff_fcr' => $diff_fcr,
                            'strain' => $data->strain ?? 'Unknown',
                            'populasi' => $data->populasi_awal ? number_format($data->populasi_awal) : 0,
                            'deplesi' => $data->deplesi ?? 0,
                            'umur_panen' => $umur_panen,
                            'daya_hidup' => $daya_hidup,
                            'ip' => $ip
                        ]
                    ];
                }
                $avg_bw = $total_data > 0 ? round($total_bw / $total_data, 2) : 0;
                $avg_fcr_act = $total_data > 0 ? round($total_fcr_act / $total_data, 2) : 0;
                $avg_fcr_std = $total_data > 0 ? round($total_fcr_std / $total_data, 2) : 0;
                $avg_diff_fcr = $total_data > 0 ? round($total_diff_fcr / $total_data, 2) : 0;
                $avg_deplesi = $total_data > 0 ? round($total_deplesi / $total_data, 2) : 0;
                $avg_umur_panen = $total_data > 0 ? round($total_umur_panen / $total_data, 2) : 0;
                $avg_daya_hidup = $total_data > 0 ? round($total_daya_hidup / $total_data, 2) : 0;
                $avg_ip = $total_data > 0 ? round($total_ip / $total_data, 2) : 0;
                if (count($strain_unique) === 1) {
                    $strain_akhir = $strain_unique[0];
                } elseif (count($strain_unique) === 2) {
                    $strain_akhir = implode(" dan ", $strain_unique);
                } else {
                    $strain_akhir = implode(", ", array_slice($strain_unique, 0, -1)) . " dan " . end($strain_unique);
                }
                $summary = [
                    'pakan' => $total_pakan ? number_format($total_pakan) : 0,
                    'panen_ekor' => $total_panen_ekor ? number_format($total_panen_ekor) : 0,
                    'panen_kg' => $total_panen_kg ? number_format($total_panen_kg) : 0,
                    'bw' => $avg_bw ? number_format($avg_bw) : 0,
                    'fcr_act' => $avg_fcr_act,
                    'fcr_std' => $avg_fcr_std,
                    'diff_fcr' => $avg_diff_fcr,
                    'strain' => $strain_akhir,
                    // 'strain' => 'asd',
                    'populasi' => $total_populasi_awal ? number_format($total_populasi_awal) : 0,
                    'deplesi' => $avg_deplesi ?? 0,
                    'umur_panen' => $avg_umur_panen,
                    'daya_hidup' => $avg_daya_hidup,
                    'ip' => $avg_ip
                ];
            }
            if (!empty($detail)) {
                $result[] = [
                    'lokasi' => $lokasi['location'],
                    'summary' => $summary,
                    'detail' => $detail
                ];
            }
        }

        echo json_encode($result);
    }

    public function calculate_by_kandang()
    {
        $id = $_POST['id'];
        $id_value = implode(",", $id);
        $query_populasi = "SELECT ifNULL(round(sum(aa.deplesi)/sum(aa.populasi_awal)*100,2),0) as deplesi,
                            sum(aa.populasi_awal) as populasi_awal  FROM
                            (SELECT sum(b.culling + b.mati) as deplesi, a.populasi_awal FROM `kandang_activity` as a
                            left join kandang_activity_log as b on a.id_kandang = b.id_kandang and a.periode = b.periode
                            where a.id in ({$id_value}) group by a.periode,a.id_kandang) as aa";
        $datapopulasi = $this->MData->customrow($query_populasi);
        $query_pakan = "SELECT sum(b.qty)*50 as pakan FROM `kandang_activity` as a left join kandang_activity_log_sapronak as b on a.id_kandang = b.id_kandang and a.periode = b.periode and b.type_sapronak = 'pakan' and b.method_sapronak = 'use' where a.id in ({$id_value})";
        $datapakan = $this->MData->customrow($query_pakan);
        $query_panen = "SELECT sum(b.qty_ekor) as panen_ekor, (round(sum(b.qty_kg) - sum(b.beratkeranjang) - sum(b.susut),3)) as panen_kg FROM `kandang_activity` as a
                      left join ((SELECT sum(qty_ekor) as qty_ekor, sum(qty_kg) as qty_kg, id_kandang, periode, susut, beratkeranjang FROM `kandang_activity_log_panen` GROUP by nomorDO,id_kandang,periode)) as b on a.id_kandang = b.id_kandang and a.periode = b.periode
                      where a.id in ({$id_value})";
        $datapanen = $this->MData->customrow($query_panen);
        $query_strain = "SELECT strain, SUM(populasi_awal) AS total_populasi FROM kandang_activity WHERE id IN ({$id_value}) GROUP BY strain ORDER BY total_populasi DESC LIMIT 1";
        $datastrain = $this->MData->customrow($query_strain);
        $query_umur_panen = "SELECT a.id_kandang, a.periode,a.tanggal_mulai, b.tanggal,DATEDIFF(b.tanggal, a.tanggal_mulai) as umur, sum(b.qty_ekor) as panen_ekor, DATEDIFF(b.tanggal, a.tanggal_mulai)* sum(b.qty_ekor) as umur_x_panen_ekor, b.tanggal  FROM `kandang_activity` as a 
                        LEFT join kandang_activity_log_panen as b on b.id_kandang = a.id_kandang and b.periode = a.periode 
                        where a.id in ({$id_value}) GROUP by b.tanggal,a.periode,a.id_kandang";
        $dataumur_panen = $this->MData->customresult($query_umur_panen);
        $bw = round((float)$datapanen->panen_kg * 1000 / (float)$datapanen->panen_ekor, 0);
        $query_std = "SELECT fcr from std where strain = '{$datastrain->strain}' and bw = '{$bw}'";
        $datastd = $this->MData->customrow($query_std);
        $fcr_act = round($datapakan->pakan / $datapanen->panen_kg, 3);
        $fcr_std = round($datastd->fcr, 3);
        // diff global : ((fcr act global/fcr std global)-1)x100
        $diff_fcr = round((($fcr_act / $fcr_std) - 1) * 100, 2);
        $daya_hidup = 100 -  $datapopulasi->deplesi;

        // Umur Panen
        $umur_panen = 0;
        if (is_array($dataumur_panen) || is_object($dataumur_panen)) {
            $sum_panen = 0;
            $sum_umur_x_panen = 0;
            foreach ($dataumur_panen as $dataumur_panens) {
                $sum_panen += $dataumur_panens->panen_ekor;
                $sum_umur_x_panen += $dataumur_panens->umur_x_panen_ekor;
            }
            $umur_panen = round($sum_umur_x_panen / $sum_panen, 0);
        }
        $ip = round($daya_hidup * $bw / 1000 / $umur_panen / $fcr_act * 100, 2);

        $data = array(
            'pakan' => number_format($datapakan->pakan ?? 0),
            'panen_ekor' => number_format($datapanen->panen_ekor ?? 0),
            'panen_kg' => $datapanen->panen_kg ?? 0,
            'bw' => number_format($bw ?? 0),
            'fcr_act' => $fcr_act,
            'fcr_std' => $fcr_std,
            'diff_fcr' => $diff_fcr,
            'strain' => $datastrain->strain,
            'populasi' => number_format($datapopulasi->populasi_awal ?? 0),
            'deplesi' => $datapopulasi->deplesi,
            'umur_panen' => $umur_panen,
            'daya_hidup' => $daya_hidup,
            'ip' => $ip,
        );
        echo json_encode($data);
    }
}
