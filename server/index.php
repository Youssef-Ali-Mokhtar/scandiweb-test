<?php

	header("Access-Control-Allow-Origin: *");
	header("Content-Type: application/json; charset=UTF-8");
	header("Access-Control-Allow-Methods: OPTIONS,GET,POST,PUT,DELETE");
	header("Access-Control-Max-Age: 3600");
	header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

	require_once 'autoload.php';
	use \controllers\AddController;
	use \controllers\DeleteController;
	use \controllers\ViewController;

	/**
	 * Deals with request methods since it's the endpoint
	 */
    function requestData() {
	/**
	 * Couldn't use DELETE request method for deletion because 000webhost only allows GET and POST with the 
	 * free plan so I used POST for both submit and delete
	 */
	
		$requestMethod = $_SERVER['REQUEST_METHOD'];

		//Associative array indexing for GET and POST, POST has a nested indexing as well since
		//on 000webhost the DELETE request is not allowed
		
		$actions = [
			'POST' => function ($jsonData) {
				$submitActions = [
					'submit' => function ($jsonData) {
						$addController = new AddController();
						$addController->addProduct($jsonData['submit']);
					},
					'delete' => function ($jsonData) {
						$delController = new DeleteController();
						$delController->dropProducts($jsonData['delete']);
					}
				];
		
				$actionKey = array_key_exists('submit', $jsonData) ? 'submit' : 'delete';
				$action = $submitActions[$actionKey] ?? null;
		
				if ($action !== null) {
					$action($jsonData);
				} else {
					echo json_encode("Unrecognized input");
				}
			},
			'GET' => function () {
				$viewController = new ViewController();
				$viewController->showProducts();
			}
		];

		$action = $actions[$requestMethod] ?? null;

		if ($action !== null) {
			$jsonData = json_decode(file_get_contents("php://input"), true);
			$action($jsonData);
		}
	}

    requestData();


?>


