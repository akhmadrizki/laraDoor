<?php

namespace App\Controller;

use App\Services\Message\MessageService;
use App\Services\Validation\Validation;

class HomePageController
{
  public function index(): void
  {
    $messService = new MessageService;
    $posts = $messService->get();

    view('index', compact('posts'));
  }

  public function store(): void
  {

    $validasi = Validation::validate($_POST);
    if ($validasi['status'] == true) {
      $insert = new MessageService;
      $insert->store(['message' => $_POST['message'], 'title' => $_POST['title']]);
    } else {
      $_SESSION['error'] = $validasi['mainMessage'];
      $_SESSION['errorText'] = $validasi['bodyMessage'];
      $_SESSION['errorTitle'] = $validasi['titleMessage'];
    }

    // if (isset($_POST['send'])) {





    // if (empty($_POST['message']) || empty($_POST['title'])) {
    //   $_SESSION['error'] = "Field can't be null";
    // } elseif ((strlen($_POST['title']) < 10 || strlen($_POST['title']) > 32) && (strlen($_POST['message']) < 10 || strlen($_POST['message']) > 200)) {
    //   $_SESSION['errorTitle'] = "Title must be 10 to 32 characters long";
    //   $_SESSION['errorMessage'] = "Message must be 10 to 200 characters long";
    // } else {
    //   $insert = new MessageService;
    //   $insert->store(['message' => $_POST['message'], 'title' => $_POST['title']]);
    // }
    // }
  }
}
