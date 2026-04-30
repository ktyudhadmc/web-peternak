<?php
// For Public
$this->load->view('public/_partials/head');
$this->load->view('public/_partials/header');
$this->load->view("public/{$content}");
$this->load->view('public/_partials/footer');
