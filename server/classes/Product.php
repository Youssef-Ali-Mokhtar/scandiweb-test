<?php
    require_once "Database.php";

    abstract class Product{
        protected $sku;
        protected $name;
        protected $price;
        protected $productType;

        protected function __construct($sku, $name, $price, $productType){
            $this->setSku($sku);
            $this->setName($name);
            $this->setPrice($price);
            $this->setProductType($productType);
        }

        protected function getSku(){
            return $this->sku;
        }

        protected function getName(){
            return $this->name;
        }

        protected function getPrice(){
            return $this->price;
        }

        protected function getProductType(){
            return $this->productType;
        }

        protected function setSku($sku){
            $this->sku = $sku;
        }

        protected function setName($name){
            $this->name = $name;
        }

        protected function setPrice($price){
            $this->price = $price;
        }

        protected function setProductType($setProductType){
            $this->productType = $setProductType;
        }

        //Abstract method to add product differently across subclasses
        protected abstract function addProduct();

        //Delete all products that $data hold it's sku in $tables
        public static function deleteProducts($data, $tables){            
            foreach($tables as $table){
                $sql = "DELETE FROM " .$table. " WHERE sku IN ('". implode("','",$data) ."'); ";
                $database = new Database();
                $database->removeProducts($sql, $table);
            }
        }

        //In case you want to display all products, you need to pass them to the method
        //(I can't specify the tables here, since the parent class shouldn't know how many subclasses are there)
        //It has to be as scalable as possible
        public static function displayProducts($tables){
            Database::resetDisplaySql();
            foreach($tables as $table){
                Database::updateDisplaySql($table['class'], $table['attributes']);
            }
            $database = new Database();
            $database->fetchProducts();
        }
        
    }
?>