<?php 
    require_once "./classes/Product.php";
    class DeleteProducts{
        public function dropProducts($data){ 
            $tables = ['dvd', 'furniture', 'book', 'product'];
            Product::deleteProducts($data, $tables);
        }
    }
?>