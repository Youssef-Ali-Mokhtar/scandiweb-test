<?php
    require_once 'Book.php';
    require_once 'Furniture.php';
    require_once 'DVD.php';
    require_once 'Product.php';
    require_once './utility/Validation.php';


    class ProductFactory {
        /**
         * A factory method that creates an object based on the product type
         */
        public static function createProduct($data) {
            $productType = validate($data['product_type'], 'product_type');

            //Applying polymorphism to assign the right object to $product based on the entered product type
            if ($productType === 'Furniture') {
				return new Furniture($data);

			} elseif ($productType === 'DVD') {
				return new DVD($data);

			} elseif ($productType === 'Book') {
				return new Book($data);

			} else {
				// Invalid product type
				die('Invalid product type');
			}
        }
    }
?>