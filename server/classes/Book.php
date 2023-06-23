<?php
    require_once 'Database.php';
    require_once 'Product.php';
    class Book extends Product {
        private $weight;

        public function __construct($sku, $name, $price, $weight) {
            parent::__construct($sku, $name, $price, 'Book');
            $this->setWeight($weight);
        }

        public function getWeight() {
            return $this->weight;
        }

        public function setWeight($weight) {
            $this->weight = $weight;
        }

        //Add a book to database
        public function addProduct() {
            $sql = "INSERT INTO product VALUES('" . $this->getSku() . "', '" . $this->getName() . "', " . $this->getPrice() . ", '" . $this->getProductType() . "');";
            $sql .= "INSERT INTO book VALUES('" . $this->getSku() . "', " . $this->getWeight() . ");";
            $database = new Database();
            $database->saveProduct($sql);
        }

    }
?>