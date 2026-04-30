<?php
defined('BASEPATH') or exit('No direct script access allowed');

class ReCaptcha
{

    private $dataSitekey = "6LcimukeAAAAAF11JOn4Tjk_fib9M2LrDixAT_vw"; //Your SiteKey
    private $lang = "en";
    public $secret = '6LcimukeAAAAAA4oEwSccn9u2_eLJKgPlAVpmhD7'; //Secret

    public function render()
    {
        $return = '<div class="g-recaptcha" data-sitekey="' . $this->dataSitekey . '"></div>
            <script src="https://www.google.com/recaptcha/api.js?hl=' . $this->lang . '" async defer></script>';
        return $return;
    }
}
