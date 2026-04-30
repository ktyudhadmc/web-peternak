<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Get_data_listuser extends CI_Controller
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
        $datauser = $this->MData->customresult("select *,r.role_nm as role_nm,u.id as id_user from users u left join users_role r on u.role = r.id order by u.created_at desc");
        echo json_encode($datauser);
    }
}
