<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Delete_user extends CI_Controller
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
        $id = $_POST['id'];
        if ($id != "0") {
            // $this->MData->edit(array('id' => $id), 'users', array('status' => 'delete'));
            $this->MData->delete('users', array('id' => $id));
            $status = 'success';
        } else {
            $status = 'error';
        }
        $result = array(
            "status" => $status,
        );
        echo json_encode($result);
    }
}
