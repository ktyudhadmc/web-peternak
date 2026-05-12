<?php
defined('BASEPATH') or exit('No direct script access allowed');

// Induk untuk Controller yang butuh Login
class Api_Controller extends CI_Controller
{
    public $user_data;

    public function __construct()
    {
        parent::__construct();
        $this->load->library('jwt_auth');
        $this->load->library('General/General_service');

        // Semua yang pakai Api_Controller WAJIB punya token
        $this->user_data = $this->jwt_auth->validate();
    }
}
