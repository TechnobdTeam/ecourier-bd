# eCourier Bangaldesh General API v.3 - Usuages


# Installation [Development version]
composer require technobd/ecourierbd:dev-master --ignore-platform-reqs

# Installation [stable version]
composer require technobd/ecourierbd

# Remove
composer remove technobd/ecourierbd --ignore-platform-reqs


# CodeIgniter v4.0 example

<?php namespace App\Controllers;

use CodeIgniter\Controller;
use technobd\ecourierbd\ECourierBD;

class Home extends Controller
{
    public function index(){
        $eCourier = new ECourierBD();
    }
}