<?php

use App\Controller\HomePageController;
use App\Services\Request\Request;

require '../vendor/autoload.php';

// Session start
session_start();

$request = new Request();

if ($request->isPost()) {
	(new HomePageController)->store($request);
}

(new HomePageController)->index();

// Session unset/destroy
session()->forget('old');
session()->forget('errors');
