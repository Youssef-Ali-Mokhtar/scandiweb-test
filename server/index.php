<?php
	require_once "controllers/DeleteController.php";
	require_once "controllers/AddController.php";
	require_once "controllers/ViewController.php";

	/**
	 * Deals with request methods since it's the endpoint
	 */
    function requestData() {
	/**
	 * Couldn't use DELETE request method for deletion because 000webhost only allows GET and POST with the 
	 * free plan so I used POST for both submitting and deleting products
	 */
	
		if($_SERVER["REQUEST_METHOD"]==="POST") {
			$jsonData = json_decode(file_get_contents("php://input"), TRUE);
			
			if(isset($jsonData['submit'])) { 
				// POST request to add data submitted by client
				$addController = new AddController();
				$addController->addProduct($jsonData['submit']);

			} elseif(isset($jsonData['delete'])) {
				// POST request to get an array of SKUs from client to delete data 
				$delController = new DeleteController();
				$delController->dropProducts($jsonData['delete']);

			} else {
				echo json_encode("Unrecogonized input");
			}

		} elseif ($_SERVER["REQUEST_METHOD"]==="GET") { 
			// GET request to retreive data from database then send to client
			$viewController = new ViewController();
			$viewController->showProducts();
		}
	}

    requestData();

?>