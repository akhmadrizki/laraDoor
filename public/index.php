<?php

session_start();

use App\Controller\HomePageController;
use App\Services\Request\Request;

require '../vendor/autoload.php';

$request = new Request();

if ($request->isPost()) {
  (new HomePageController)->store($request);
}

(new HomePageController)->index();
