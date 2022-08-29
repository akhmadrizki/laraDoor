<?php

use App\Controller\HomePageController;

require '../vendor/autoload.php';

if (isset($_POST['send'])) {
  (new HomePageController)->store();
}
(new HomePageController)->index();
