<?php
    namespace controllers;
    use \models\ProductFactory;

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