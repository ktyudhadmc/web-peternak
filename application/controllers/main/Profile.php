<?php

defined('BASEPATH') or exit('No direct script access allowed');
Sentry\init(['dsn' => 'https://4dba7b441a7ff5576bdc44cf8098b987@o4504875505483776.ingest.sentry.io/4506318591950848']);
class Profile extends CI_Controller
{
    public $cookiex;
    public function __construct()
    {
        parent::__construct();
        $this->load->model('MData');
        $this->load->model('MThirdApp');
        $this->MThirdApp->checksession();
        $this->load->library('Dummy');
        $this->db2 = $this->load->database('logger', TRUE);
        $this->cookiex = getcookienya('user_data');
    }

    public function index($id = NULL)
    {

        $iduser = $id == NULL ? $this->cookiex['user_id'] : $id;
        $getdata = $this->MData->selectdatawhere('users', ['id' => $iduser]);
        if ($getdata == FALSE) {
            redirect('main/profile', 'refresh');
            exit;
        }
        // $getlogger = $this->db2->query("SELECT * FROM logger where username = '{$iduser}' AND logger like '%[main]%' ORDER BY created_at DESC LIMIT 10");
        $getlogger = $this->db2->query("SELECT * FROM logger where username = '{$iduser}' ORDER BY created_at DESC LIMIT 10");
        $data = array(
            'title' => 'Profile',
            'content' => 'profile',
            'datauser' => $getdata,
            'datalogger' => $getlogger->num_rows() > 0 ? $getlogger->result() : false
        );
        $this->load->view('main/template', $data);
    }
}

/* End of file Public.php */
