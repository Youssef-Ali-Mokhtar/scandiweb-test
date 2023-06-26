<?php 
    require_once "./models/Product.php";
    class DeleteController {
        /**
         * Passes table names that will have products deleted from
         * (No need to use a factory method here to create the list of table names that will be used for the
         * mysql query deletion)
         * 
         * @param array $data The SKUs of the products that need to be deleted
         */
        public function dropProducts($data) { 
            $tables = ['dvd', 'furniture', 'book', 'product'];
            Product::deleteProducts($data, $tables);
        }
    }
?>