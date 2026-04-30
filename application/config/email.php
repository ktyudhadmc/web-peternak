<?php defined('BASEPATH') or exit('No direct script access allowed');


$config = array(
    'protocol' => 'smtp', // 'mail', 'sendmail', or 'smtp'
    'smtp_host' => 'mail.dmcfarm.online',
    'smtp_port' => '465',
    'smtp_user' => 'no-reply@dmcfarm.online',
    'smtp_pass' => 'dmc2020DMC',
    'smtp_crypto' => 'starttls', //can be 'ssl' or 'tls' for example
    'mailtype' => 'text', //plaintext 'text' mails or 'html'
    'smtp_timeout' => '4', //in seconds
    'charset' => 'iso-8859-1',
    'wordwrap' => TRUE,
    'newline' => "\r\n",
    // '_smtp_auth' => true
    // 'SMTPDebug' => 2
);
// $config = array();
// $config['protocol']    = 'smtp';
// $config['smtp_host']    = 'mail.dmcfarm.online';
// $config['smtp_port']    = '587'; //465 or 587
// $config['smtp_timeout'] = '7';
// $config['smtp_user']    = 'no-reply@dmcfarm.online';
// $config['smtp_pass']    = 'dmc2020DMC';
// $config['charset']    = 'utf-8';
// $config['newline']    = "\r\n";
// $config['mailtype'] = 'text'; // or html
// $config['validation'] = TRUE; // bool whether to validate email or not      
