<?php

namespace App\Services\Validation;

class Validation
{

  public static function validate(array $data)
  {
    if (empty($data['message']) && empty($data['title'])) {
      $respons = [
        'status' => false,
        'mainMessage'  => "Field can't be null",
        'titleMessage' => "",
        'bodyMessage'  => "",
      ];
    } elseif ((strlen($_POST['title']) < 10 || strlen($_POST['title']) > 32) && empty($data['message'])) {
      $respons = [
        'status' => false,
        'mainMessage'  => "",
        'titleMessage' => "Title must be 10 to 32 characters long",
        'bodyMessage'  => "Field can't be null",
      ];
    } elseif ((strlen($_POST['message']) < 10 || strlen($_POST['message']) > 32) && empty($data['title'])) {
      $respons = [
        'status' => false,
        'mainMessage'  => "",
        'titleMessage' => "Field can't be null",
        'bodyMessage'  => "Message must be 10 to 200 characters long",
      ];
    } elseif ((strlen($_POST['title']) < 10 || strlen($_POST['title']) > 32) && (strlen($_POST['message']) < 10 || strlen($_POST['message']) > 200)) {
      $respons = [
        'status' => false,
        'mainMessage'  => "",
        'titleMessage' => "Title must be 10 to 32 characters long",
        'bodyMessage'  => "Message must be 10 to 200 characters long",
      ];
    } else {
      $respons = [
        'status' => true,
        'message' => "Success",
      ];
    }

    return $respons;
  }
}
