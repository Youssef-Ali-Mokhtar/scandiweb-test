<?php
	require_once "controllers/DeleteProducts.php";
	require_once "controllers/ProductController.php";
	require_once "controllers/ViewProducts.php";

    function requestData(){
		
	//Couldn't use DELETE request method for deletion because 000webhost only allows GET and POST with the 
	//free plan so I used POST for both submitting and deleting products 
		if($_SERVER["REQUEST_METHOD"]==="POST"){
			$jsonData = json_decode(file_get_contents("php://input"), TRUE);
			
			if(isset($jsonData['submit'])){ 
				// POST request to add data submitted by client
				$prodCont = new ProductController();
				$prodCont->addProduct($jsonData['submit']);

			}else if(isset($jsonData['delete'])){
				// POST request to get an array of SKUs from client to delete data 
				$delProd = new DeleteProducts();
				$delProd->dropProducts($jsonData['delete']);

			}else{
				echo json_encode("Not working!");
			}

		}else if($_SERVER["REQUEST_METHOD"]==="GET"){ 
			// GET request to retreive data from database then send to client
			$viewProd = new ViewProducts();
			$viewProd->showProducts();
		}
	}
    requestData();

?>