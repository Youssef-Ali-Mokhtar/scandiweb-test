<?php
    namespace models;
    use \utility\Validation;
    use \models\Book;
    use \models\DVD;
    use \models\Furniture;
    use \models\Product;

    class ProductFactory {
        /**
         * A factory method that creates an object based on the product type
         */
        public static function createProduct($data) {
            $productType = Validation::validate($data['product_type'], 'product_type');

            //Applying polymorphism to assign the right object to $product based on the entered product type

            $productClasses = [
                'Furniture' => 'Furniture',
                'DVD' => 'DVD',
                'Book' => 'Book',
                // Add more product types and corresponding class names as needed
            ];
    
            $className = $productClasses[$productType] ?? null;
            
            $className = "\models" . '\\'. $className;
            if ($className) {
                return new $className($data);
            } else {
                // Invalid product type
                die('Invalid product type');
            }

        }
    }
?>