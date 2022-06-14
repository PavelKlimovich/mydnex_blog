<?php

use Dotenv\Dotenv;
use Src\Database\Database;

require_once "../vendor/autoload.php";

$dotenv = Dotenv::createImmutable("../",'.env');
$dotenv->load();
$db = new Database($_ENV['DB_HOST'], $_ENV['DB_DATABASE'], $_ENV['DB_USERNAME'], $_ENV['DB_PASSWORD']);

require_once "../routes/web.php";
