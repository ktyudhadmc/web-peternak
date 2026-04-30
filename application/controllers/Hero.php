<?php

defined('BASEPATH') or exit('No direct script access allowed');
Sentry\init(['dsn' => 'https://4dba7b441a7ff5576bdc44cf8098b987@o4504875505483776.ingest.sentry.io/4506318591950848']);
class Hero extends CI_Controller
{

    public function index()
    {
        $data = array(
            'title' => "Sebaiknya pakai ini deh",
        );
        $this->load->view('errors/herolanding', $data);
    }
}
