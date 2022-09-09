<?php

namespace App\Controller;

use App\Services\Message\MessageService;
use App\Services\Pagination\Pagination;
use App\Services\Request\Request;
use App\Services\Validation\BetweenRule;
use App\Services\Validation\RequiredRule;
use App\Services\Validation\Validation;

class HomePageController
{
	public function index(Request $request)
	{
		$messService = new MessageService;

		$getRequest  = $request->query(Pagination::getUrlParam(), 1);

		if (!is_numeric($getRequest)) {
			$getRequest = 1;
		}

		$posts    = $messService->paginate(10, $getRequest, 2);

		return view('index', compact('posts'));
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

		$insert->store($data);

		return redirect('/');
	}
}
