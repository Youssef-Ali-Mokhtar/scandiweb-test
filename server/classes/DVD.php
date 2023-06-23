<?php
    require_once 'Database.php';
    require_once 'Product.php';
    class DVD extends Product{
        private $size;

        public function __construct($sku, $name, $price, $size){
            parent::__construct($sku, $name, $price, 'DVD');
            $this->setSize($size);
        }

        public function getSize(){
            return $this->size;
        }

        public function setSize($size){
            $this->size = $size;
        }

        //Add a dvd to database
        public function addProduct(){
            $sql = "INSERT INTO product VALUES('" . $this->getSku() . "', '" . $this->getName() . "', " . $this->getPrice() . ", '" . $this->getProductType() . "');";
            $sql .= "INSERT INTO dvd VALUES('" . $this->getSku() . "', " . $this->getSize() . ");";
            $database = new Database();
            $database->saveProduct($sql);
        }
    }
?>