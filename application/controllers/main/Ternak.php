<?php

defined('BASEPATH') or exit('No direct script access allowed');
Sentry\init(['dsn' => 'https://4dba7b441a7ff5576bdc44cf8098b987@o4504875505483776.ingest.sentry.io/4506318591950848']);
class Ternak extends CI_Controller
{
    public $cookiex;
    public function __construct()
    {
        parent::__construct();
        $this->load->model('MData');
        $this->load->model('MThirdApp');
        $this->load->model('MSql');
        // $this->MThirdApp->checksession();
        $this->load->library('Dummy');
        $this->cookiex = getcookienya('user_data');
    }

    public function index()
    {
        redirect('main', 'refresh');
    }
    public function view($mode = NULL)
    {
        if ($mode == NULL) {
            redirect('main', 'refresh');
            exit;
        }

        $data = array(
            'title' => 'Ternak',
            'content' => 'ternak_view',
        );
        $this->load->view('main/template', $data);
    }
    public function rollingternak($from = null, $config = null)
    {
        $datanya = array();
        if ($config == null || $config == "") {
            $usinglimt = NULL;
        } else {
            $usinglimt =  "LIMIT {$from},{$config}";
        }
        $iduser = $this->cookiex['user_id'];
        switch ($this->cookiex['role']) {
            case '1':
                $datanya['groupingkandangrehat'] = $this->MData->customresult("SELECT k.user_id as owner,u.first_name as nama_user,u.id_company, c.nama_company as company FROM `kandang` k INNER JOIN users u ON k.user_id = u.id LEFT JOIN company c ON c.id = u.id_company WHERE `status_kandang` in ('REHAT','CLOSE') GROUP BY  `user_id` {$usinglimt}");
                $datanya['groupingkandangaktif'] = $this->MData->customresult("SELECT k.user_id as owner,u.first_name as nama_user,u.id_company, c.nama_company as company FROM `kandang` k INNER JOIN users u ON k.user_id = u.id LEFT JOIN company c ON c.id = u.id_company WHERE `status_kandang` in ('REHAT','CLOSE','AKTIF') GROUP BY  `user_id`{$usinglimt}");
                $datanya['kandangaktif'] = $this->MData->customresult("SELECT *,users.first_name FROM kandang  LEFT JOIN kandang_activity ON kandang.id = kandang_activity.id_kandang LEFT JOIN users on kandang.user_id = users.id where status_kandang in ('AKTIF','REHAT','CLOSE') AND status_kandang_activity in ('AKTIF','REHAT','CLOSE') ORDER BY kandang.nama ASC {$usinglimt}");
                $datanya['kandangrehat'] = $this->MData->customresult("SELECT *,users.first_name FROM `kandang` LEFT JOIN kandang_activity ON kandang.id = kandang_activity.id_kandang LEFT JOIN users on kandang.user_id = users.id WHERE `status_kandang` in ('REHAT','CLOSE') ORDER BY kandang.nama ASC {$usinglimt}");
                $datanya['data_ternak_aktif'] = $this->MData->customresult("
            SELECT *, a.nama, a.foto, b.id_kandang, b.periode, c.deplesi, b.populasi_awal - ifnull(c.deplesi,0) - ifnull(f.panen_ekor,0) as populasi, d.tot_feed FROM kandang as a LEFT JOIN kandang_activity as b ON a.id = b.id_kandang LEFT JOIN (SELECT sum(total_mati) as deplesi, periode, id_kandang FROM kandang_activity_log GROUP by periode, id_kandang) as c on c.periode = b.periode and c.id_kandang = b.id_kandang LEFT JOIN (SELECT sum(qty) as tot_feed, periode, id_kandang FROM kandang_activity_log_sapronak where type_sapronak = 'pakan' and method_sapronak = 'use' GROUP by periode, id_kandang) as d on d.periode = b.periode and d.id_kandang = b.id_kandang LEFT JOIN (SELECT sum(qty_ekor) as panen_ekor, sum(qty_kg) as panen_kg, periode, id_kandang from kandang_activity_log_panen GROUP by id_kandang,periode) as f on f.periode = b.periode and f.id_kandang = b.id_kandang where a.status_kandang = 'AKTIF' AND b.status_kandang_activity = 'AKTIF'  {$usinglimt}");
                break;
            case '4';
                $datanya['groupingkandangrehat'] = $this->MData->customresult("SELECT k.user_id as owner,u.id_company, u.first_name as nama_user, c.nama_company as company FROM `kandang` k INNER JOIN users u ON k.user_id = u.id LEFT JOIN company c ON c.id = u.id_company WHERE `status_kandang` in ('REHAT','CLOSE') and FIND_IN_SET('{$this->cookiex['user_id']} ', k.user_id_sharing) GROUP BY  `user_id` {$usinglimt}");
                $datanya['groupingkandangaktif'] = $this->MData->customresult("SELECT k.user_id as owner,u.id_company, u.first_name as nama_user, c.nama_company as company FROM `kandang` k INNER JOIN users u ON k.user_id = u.id LEFT JOIN company c ON c.id = u.id_company WHERE `status_kandang` in ('AKTIF') AND FIND_IN_SET('{$this->cookiex['user_id']}', k.user_id_sharing) GROUP BY  `user_id` {$usinglimt}");
                $datanya['kandangaktif'] = $this->MData->customresult("SELECT *,users.first_name FROM kandang LEFT JOIN kandang_activity ON kandang.id = kandang_activity.id_kandang LEFT JOIN users on kandang.user_id = users.id where FIND_IN_SET('{$iduser}', user_id_sharing) AND status_kandang = 'AKTIF' AND status_kandang_activity = 'AKTIF' ORDER BY kandang.nama ASC {$usinglimt}");
                $datanya['kandangrehat'] = $this->MData->customresult("SELECT *,users.first_name FROM `kandang` LEFT JOIN users on kandang.user_id = users.id WHERE FIND_IN_SET('{$iduser}', user_id_sharing) AND `status_kandang` in ('REHAT','CLOSE') ORDER BY kandang.nama ASC  {$usinglimt}");
                $datanya['data_ternak_aktif'] = $this->MData->customresult("
        SELECT *, a.nama, a.foto, b.id_kandang, b.periode, c.deplesi, b.populasi_awal - ifnull(c.deplesi,0) - ifnull(f.panen_ekor,0) as populasi, d.tot_feed FROM kandang as a LEFT JOIN kandang_activity as b ON a.id = b.id_kandang LEFT JOIN (SELECT sum(total_mati) as deplesi, periode, id_kandang FROM kandang_activity_log GROUP by periode, id_kandang) as c on c.periode = b.periode and c.id_kandang = b.id_kandang LEFT JOIN (SELECT sum(qty) as tot_feed, periode, id_kandang FROM kandang_activity_log_sapronak where type_sapronak = 'pakan' and method_sapronak = 'use' GROUP by periode, id_kandang) as d on d.periode = b.periode and d.id_kandang = b.id_kandang LEFT JOIN (SELECT sum(qty_ekor) as panen_ekor, sum(qty_kg) as panen_kg, periode, id_kandang from kandang_activity_log_panen GROUP by id_kandang,periode) as f on f.periode = b.periode and f.id_kandang = b.id_kandang where FIND_IN_SET('{$iduser}', a.user_id_sharing) AND a.status_kandang = 'AKTIF' AND b.status_kandang_activity = 'AKTIF' {$usinglimt}");
                break;
            case '5 ';
                $datanya['groupingkandangrehat'] = $this->MData->customresult("SELECT k.user_id as owner,u.id_company, u.first_name as nama_user, c.nama_company as company FROM `kandang` k INNER JOIN users u ON k.user_id = u.id LEFT JOIN company c ON c.id = u.id_company WHERE `status_kandang` in ('REHAT','CLOSE') and user_id ='{$this->cookiex['user_master']}' GROUP BY  `user_id` {$usinglimt}");
                $datanya['groupingkandangaktif'] = $this->MData->customresult("SELECT k.user_id as owner,u.id_company, u.first_name as nama_user, c.nama_company as company FROM `kandang` k INNER JOIN users u ON k.user_id = u.id LEFT JOIN company c ON c.id = u.id_company WHERE `status_kandang` in ('AKTIF') and user_id ='{$this->cookiex['user_master']} ' GROUP BY  `user_id` {$usinglimt}");
                $datanya['kandangaktif'] = $this->MData->customresult("SELECT * FROM kandang LEFT JOIN kandang_activity ON kandang.id = kandang_activity.id_kandang LEFT JOIN users on kandang.user_id = users.id where user_id ='{$this->cookiex['user_master']}' AND status_kandang = 'AKTIF' AND status_kandang_activity = 'AKTIF' ORDER BY kandang.nama ASC {$usinglimt}");
                $datanya['kandangrehat'] = $this->MData->customresult("SELECT *,users.first_name FROM `kandang` LEFT JOIN users on kandang.user_id = users.id WHERE `user_id` = '{$this->cookiex['user_master']}' AND `status_kandang` in ('REHAT','CLOSE ') ORDER BY kandang.nama ASC {$usinglimt}");
                $datanya['data_ternak_aktif'] = $this->MData->customresult("
            SELECT *, a.nama, a.foto, b.id_kandang, b.periode, c.deplesi, b.populasi_awal - ifnull(c.deplesi,0) - ifnull(f.panen_ekor,0) as populasi, d.tot_feed FROM kandang as a LEFT JOIN kandang_activity as b ON a.id = b.id_kandang LEFT JOIN (SELECT sum(total_mati) as deplesi, periode, id_kandang FROM kandang_activity_log GROUP by periode, id_kandang) as c on c.periode = b.periode and c.id_kandang = b.id_kandang LEFT JOIN (SELECT sum(qty) as tot_feed, periode, id_kandang FROM kandang_activity_log_sapronak where type_sapronak = 'pakan' and method_sapronak = 'use' GROUP by periode, id_kandang) as d on d.periode = b.periode and d.id_kandang = b.id_kandang LEFT JOIN (SELECT sum(qty_ekor) as panen_ekor, sum(qty_kg) as panen_kg, periode, id_kandang from kandang_activity_log_panen GROUP by id_kandang,periode) as f on f.periode = b.periode and f.id_kandang = b.id_kandang where a.user_id ='{$this->cookiex['user_master']}' AND a.status_kandang = 'AKTIF' AND b.status_kandang_activity = 'AKTIF'");
                break;
            default:
                $datanya['groupingkandangrehat'] = $this->MData->customresult("SELECT k.user_id as owner,u.id_company, u.first_name as nama_user, c.nama_company as company FROM `kandang` k INNER JOIN users u ON k.user_id = u.id LEFT JOIN company c ON c.id = u.id_company WHERE `status_kandang` in ('REHAT','CLOSE') and user_id ='{$this->cookiex['user_id']}' GROUP BY  `user_id` {$usinglimt}");
                $datanya['groupingkandangaktif'] = $this->MData->customresult("SELECT k.user_id as owner,u.id_company, u.first_name as nama_user, c.nama_company as company FROM `kandang` k INNER JOIN users u ON k.user_id = u.id LEFT JOIN company c ON c.id = u.id_company WHERE `status_kandang` in ('AKTIF')  and user_id ='{$this->cookiex['user_id']}' GROUP BY  `user_id` {$usinglimt}");
                $datanya['kandangaktif'] = $this->MData->customresult("SELECT * FROM kandang LEFT JOIN kandang_activity ON kandang.id = kandang_activity.id_kandang LEFT JOIN users on kandang.user_id = users.id where user_id ='{$this->cookiex['user_id']}' AND status_kandang = 'AKTIF' AND status_kandang_activity = 'AKTIF' ORDER BY kandang.nama ASC {$usinglimt}");
                $datanya['kandangrehat'] = $this->MData->customresult("SELECT *,users.first_name FROM `kandang` LEFT JOIN users on kandang.user_id = users.id WHERE `user_id` = '{$iduser}' AND `status_kandang` in ('REHAT','CLOSE') ORDER BY kandang.nama ASC {$usinglimt}");
                $datanya['data_ternak_aktif'] = $this->MData->customresult("
            SELECT *, a.nama, a.foto, b.id_kandang, b.periode, c.deplesi, b.populasi_awal - ifnull(c.deplesi,0) - ifnull(f.panen_ekor,0) as populasi, d.tot_feed FROM kandang as a LEFT JOIN kandang_activity as b ON a.id = b.id_kandang LEFT JOIN (SELECT sum(total_mati) as deplesi, periode, id_kandang FROM kandang_activity_log GROUP by periode, id_kandang) as c on c.periode = b.periode and c.id_kandang = b.id_kandang LEFT JOIN (SELECT sum(qty) as tot_feed, periode, id_kandang FROM kandang_activity_log_sapronak where type_sapronak = 'pakan' and method_sapronak = 'use' GROUP by periode, id_kandang) as d on d.periode = b.periode and d.id_kandang = b.id_kandang LEFT JOIN (SELECT sum(qty_ekor) as panen_ekor, sum(qty_kg) as panen_kg, periode, id_kandang from kandang_activity_log_panen GROUP by id_kandang,periode) as f on f.periode = b.periode and f.id_kandang = b.id_kandang where a.user_id ='{$this->cookiex['user_id']}' AND a.status_kandang = 'AKTIF' AND b.status_kandang_activity = 'AKTIF' {$usinglimt}");
                break;
        }
        return $datanya;
        // return $usinglimt;
    }
    public function detail($status = "rehat", $idkandang, $periode = NULL)
    {
        $data = array(
            'title' => "Detail Ternak $idkandang | $periode",
            'content' => 'ternak_detail',
            'idkandang' => $idkandang,
            'status_kandang' => $status,
            'periode' =>  $periode,
        );
        $this->load->view('main/template', $data);
    }
}
