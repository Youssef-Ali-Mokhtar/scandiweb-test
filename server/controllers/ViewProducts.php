<?php 
    require_once "./classes/Product.php";
    require_once "./classes/Book.php";
    class ViewProducts{
        public function showProducts(){
            $tables = [
                ['class'=>'furniture', 'attributes'=>['height', 'width', 'length']],
                ['class'=>'book', 'attributes'=>['weight']],
                ['class'=>'dvd', 'attributes'=>['size']]
            ];

            Product::displayProducts($tables);
        }
    }
?>