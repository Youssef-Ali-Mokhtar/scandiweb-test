<?php
    require_once './classes/Book.php';
    require_once './classes/Furniture.php';
    require_once './classes/DVD.php';
	require_once './classes/Product.php';
    require_once './utility/Validation.php';

    class ProductController{
        public function addProduct($data){
            //Common properties across all product types
            $sku = validate($data['sku'], 'sku');
			$name = validate($data['name'], 'name');
			$price = validate($data['price'], 'price');
			$productType = validate($data['product_type'], 'product_type');
            
            //Applying polymorphism to assign the right object to $product based on the entered product type
            if ($productType === 'Furniture') {
                $height = validate($data['height'], 'height');
                $width = validate($data['width'], 'width');
                $length = validate($data['length'], 'length');
				$product = new Furniture($sku, $name, $price, $height, $width, $length);
                
			} elseif ($productType === 'DVD') {
                $size = validate($data['size'], 'size');
				$product = new DVD($sku, $name, $price, $size);

			} elseif ($productType === 'Book') {
                $weight = validate($data['weight'], 'weight');
				$product = new Book($sku, $name, $price, $weight);

			} else {
				// Invalid product type
				die('Invalid product type');
			}
            
			$product->addProduct();
        }
    }
?>