<?php

defined('BASEPATH') or exit('No direct script access allowed');
Sentry\init(['dsn' => 'https://4dba7b441a7ff5576bdc44cf8098b987@o4504875505483776.ingest.sentry.io/4506318591950848']);
class Error404 extends CI_Controller
{

    public function index()
    {
        $data = array(
            'title' => "404"
        );
        $this->load->view('errors/error404', $data);
    }
}
