<?php
    require_once 'Database.php';
    require_once 'Product.php';
    class Furniture extends Product{
        private $height;
        private $width;
        private $length;

        public function __construct($sku, $name, $price, $height, $width, $length){
            parent::__construct($sku, $name, $price, 'Furniture');
            $this->setHeight($height);
            $this->setWidth($width);
            $this->setLength($length);
        }

        public function getHeight(){
            return $this->height;
        }

        public function getWidth(){
            return $this->width;
        }

        public function getLength(){
            return $this->length;
        }

        public function setHeight($height){
            $this->height = $height;
        }

        public function setWidth($width){
            $this->width = $width;
        }

        public function setLength($length){
            $this->length = $length;
        }

        //Add furniture to database
        public function addProduct(){
            $sql = "INSERT INTO product VALUES('" . $this->getSku() . "', '" . $this->getName() . "', " . $this->getPrice() . ", '" . $this->getProductType() . "');";
            $sql .= "INSERT INTO furniture VALUES('" . $this->getSku() . "', " . $this->getHeight() . ", " . $this->getWidth() . ", " . $this->getLength() . ");";
            $database = new Database();
            $database->saveProduct($sql);
        }
    }
?>