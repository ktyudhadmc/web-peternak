<?php

defined('BASEPATH') or exit('No direct script access allowed');
Sentry\init(['dsn' => 'https://4dba7b441a7ff5576bdc44cf8098b987@o4504875505483776.ingest.sentry.io/4506318591950848']);
class Home extends CI_Controller
{
    public $cookiex;
    public function __construct()
    {
        parent::__construct();
        $this->load->model('MData');
        $this->load->model('MThirdApp');
        $this->MThirdApp->checksession();
        $this->cookiex = getcookienya('user_data');
        // echo('1'); exit;
        // echo json_encodE($_SESSION); exit;
    }
    
    public function index()
    {
        $getlayanan = $this->MData->selectdatawhereresult('layanan', array('layanan_status' => 1));
        $data = array(
            'title' => 'Dashboard',
            'content' => 'index',
            'datalayanan' => $getlayanan
        );
        $this->load->view('main/template', $data);
    }
    public function getdataOld()
    {
        if ($this->input->post()) {
            $iduser = $this->input->post('user_id');
            $role = $this->input->post('role');
        } else {
            $iduser = $this->cookiex['user_id'];
            $role = $this->cookiex['role'];
        }
        switch ($role) {
            case '1':
                $findset = null;
                break;

            default:
                $findset = "FIND_IN_SET('{$iduser}', k.user_id_sharing) AND";
                break;
        }
        $getdata = "
        SELECT
            k.id,
            k.nama,
            ka.periode,
            kal.tanggal AS update_at,
            SUM(kal2.mati) AS total_mati,
            SUM(SUM(kal2.mati)) OVER (PARTITION BY kal.tanggal) AS deplesi
        FROM
            kandang_activity_log kal
        INNER JOIN kandang_activity ka ON ka.id_kandang = kal.id_kandang
        INNER JOIN kandang k ON ka.id_kandang = k.id
        INNER JOIN kandang_activity_log kal2 ON k.id = kal2.id_kandang AND kal2.tanggal = kal.tanggal
        WHERE
        {$findset}
        ka.status_kandang_activity IN ('AKTIF')
            AND kal.tanggal >= CURDATE() - INTERVAL DAYOFWEEK(CURDATE()) + 6 DAY
            AND kal.tanggal < CURDATE() - INTERVAL DAYOFWEEK(CURDATE()) - 1 DAY
        GROUP BY
            k.id,
            k.nama,
            ka.periode,
            kal.tanggal
        ORDER BY
            kal.tanggal ASC";
        
            $dataquery = $this->MData->customresult($getdata);
            // echo json_encode($dataquery); exit;
        $tanggal = NULL;
        $dataoutput = array();
        if ($dataquery) {
            foreach ($dataquery as $dataquerys) {
                if ($tanggal !== NULL) {
                    if ($tanggal !== date("Y-m-d", strtotime($dataquerys->update_at))) {
                        $dataoutput[] = [
                            'tgl' => date("Y-m-d", strtotime($dataquerys->update_at)),
                        ];
                        $tanggal = date("Y-m-d", strtotime($dataquerys->update_at));
                    }
                } else {
                    $dataoutput[] = [
                        'tgl' => date("Y-m-d", strtotime($dataquerys->update_at))
                    ];
                    $tanggal = date("Y-m-d", strtotime($dataquerys->update_at));
                }
            }
        }
        // $tanggalset = NULL;
        $countmati = 0;
        $countdeplesi = 0;
        $datafinal = array();
        if (count($dataoutput) > 0) {
            // $tgl = (int)date('d', strtotime($dataoutput[0]['tgl']));
            foreach ($dataoutput as $datatgl) {
                foreach ($dataquery as $dataquerys) {
                    if ($datatgl['tgl'] == date("Y-m-d", strtotime($dataquerys->update_at))) {
                        $countmati += $dataquerys->total_mati;
                        $countdeplesi += $dataquerys->deplesi;
                    }
                }
                $datafinal[] = [
                    'tgl' => date('d M', strtotime($datatgl['tgl'])),
                    'mati' => $countmati,
                    'deplesi' => $countdeplesi
                ];
                $countmati = 0;
                $countdeplesi = 0;
            }
            $myDates = $datafinal;
            $missingDates = array();

            $dateStart = date_create(date('Y-m-d', strtotime($dataoutput[0]['tgl'])));
            $dateEnd   = date_create(date('Y-m-d', strtotime("+1 day", strtotime($dataoutput[count($datafinal) - 1]['tgl']))));
            $interval  = new DateInterval('P1D');
            $period    = new DatePeriod($dateStart, $interval, $dateEnd);
            foreach ($period as $day) {
                $formatted = $day->format("Y-m-d");
                if (array_search($formatted, array_column($myDates, 'tgl')) == false) {
                    $missingDates[] = $formatted;
                }
            }

            echo json_encode($datafinal);
            exit;
        }
        echo json_encode(['tgl' => date('d M'), 'mati' => null, 'deplesi' => null]);
        exit;
    }

    public function getdata()
    {
        $endpoint = '/dist/web/getdata';
        $url = $_ENV['APP_API_URL_V1'] . $endpoint;
        $withToken = true;

        if ($this->input->post()) {
            $userId = $this->input->post('user_id');
            $role = $this->input->post('role');
        } else {
            $userId = $this->cookiex['user_id'];
            $role = $this->cookiex['role'];
        }

        $payload["userId"] = $userId;
        $payload["role"] = $role;


        $response = call_api("POST", $url, $payload, $withToken);

        echo json_encode($response);
        exit;
    }
}
