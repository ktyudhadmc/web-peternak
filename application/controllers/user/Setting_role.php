<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Setting_role extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('MThirdApp');
        $this->load->model('MData');
        $this->MThirdApp->checksession();
    }
    public function index()
    {
        $datarole = $this->MData->customresult("select * from users_role order by id asc");
        $data = array(
            'title' => 'Setting Role',
            'content' => 'setting_role',
            'datarole' => $datarole,
        );
        $this->load->view('main/template', $data);
    }
}
