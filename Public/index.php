<?php

namespace App\Public;

use App\Autoload;
use App\Core\Main;

define('ROOT', dirname(__DIR__));
require_once ROOT . '/Autoload.php';

// on appelle la fonction d'autoload
Autoload::register();

// on instancie le router 
$main = new Main();

// on demarre le router
$main->start();
