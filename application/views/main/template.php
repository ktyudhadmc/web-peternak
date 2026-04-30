<?php
$this->load->view('main/_partials/head');
$this->load->view('main/_partials/sidebar');
$this->load->view('main/_partials/navbar');
$this->load->view("main/content/{$content}");
$this->load->view('main/_partials/footer');
$this->load->view('main/_partials/drawermodal');
$this->load->view('main/_partials/js');
