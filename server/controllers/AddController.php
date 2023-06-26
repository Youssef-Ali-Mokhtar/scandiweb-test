<?php

    require_once './utility/Validation.php';
    require_once './models/ProductFactory.php';

    class AddController {
        /**
         * Uses ProductFactory to create the object that will be used to add the product using Product
         * (polymorphism is applied inside ProductFactory's factory method)
         * 
         * @param array $data The submited bu the user to add a product
         */
        public function addProduct($data) {
            $product = ProductFactory::createProduct($data);
            $product->addProduct();
        }
    }
?>