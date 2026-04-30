<?php
defined('BASEPATH') or exit('No direct script access allowed');
require 'vendor/autoload.php';
// inisialisasi faker

class Dummy
{
    public function create($parameter)
    {
        $faker = Faker\Factory::create('id_ID');
        // generate data nama, alamat
        return $faker->$parameter;
    }
}

/* End of file Dummy    .php */
