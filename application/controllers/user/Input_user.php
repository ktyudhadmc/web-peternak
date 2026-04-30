<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Input_user extends CI_Controller
{
    public $cookiex;

    public function __construct()
    {
        parent::__construct();
        $this->load->model('MData');
        $this->cookiex = getcookienya('user_data');
    }


    public function index()
    {
        $id = $this->cookiex['user_id'];
        // $getuser = $this->MData->customrow("SELECT *from users u INNER JOIN users_role ur ON u.role =  ur.id where u.id = '{$id}'");
        if ($this->input->post()) {
            // $_POST['foto'] = "assets/mobile/img/user/defaultuser.jpg";
            if (isset($_FILES['fileimg']['name'])) {
                $config['upload_path']          = str_replace('peternak_main/application', 'peternak/assets/mobile/img/user', APPPATH);
                $config['allowed_types']        = 'jpeg|jpg|png';
                $config['overwrite']            = true;
                $config['max_size']             = 100000; //100mb
                $config['remove_spaces'] = TRUE;
                $config['encrypt_name'] = TRUE;
                $this->load->library('upload', $config);
                if (!$this->upload->do_upload('fileimg')) {
                } else {
                    $_POST['foto'] = "assets/mobile/img/user/" . $this->upload->data('file_name');
                }
            }
            $this->MData->edit(array('id' => $id), 'users', $this->input->post());
            $this->session->set_flashdata('success_message', 'Data berhasil diupdate');
            echo json_encode(['status' => true, 'message' => 'Berhasil Edit Data']);
        } else {
            echo json_encode(['status' => false, 'message' => 'nodata']);
        }
    }
}

/* End of file Input_user.php */
