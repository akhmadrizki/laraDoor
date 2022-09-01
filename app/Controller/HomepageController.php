<?php

namespace App\Controller;

use App\Services\Database\QueryBuilder;
use App\Services\Message\MessageService;
use App\Services\Request\Request;
use App\Services\Validation\BetweenRule;
use App\Services\Validation\RequiredRule;
use App\Services\Validation\Validation;

class HomePageController
{
  public function index()
  {
    $messService = new MessageService;
    $posts       = $messService->get();

    $paginate = new QueryBuilder;
    $pages  = $paginate->get_pagination_number();
    $current = $paginate->current_page();

    return view('index', compact('posts', 'pages', 'current'));
  }

  public function store(Request $request)
  {
    $data = $request->only(['title', 'message']);

    $validation = Validation::make($data, [
      'title' => [
        new RequiredRule("Title can't be null"),
        new BetweenRule(10, 32, 'Title must be 10 to 32 characters long')
      ],
      'message' => [
        new RequiredRule("Message can't be null"),
        new BetweenRule(10, 200, 'Message must be 10 to 200 characters long')
      ],
    ]);

    if ($validation->fails()) {
      session()->put('errors', $validation->getErrors());
      session()->put('old', $data);

      return redirect('/');
    }

    $insert = new MessageService;
    $insert->store(['message' => $data['message'], 'title' => $data['title']]);
  }
}
