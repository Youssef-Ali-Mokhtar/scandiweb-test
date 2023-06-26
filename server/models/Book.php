<?php
    require_once 'database/Database.php';
    require_once 'Product.php';
    require_once './utility/Validation.php';
    
    class Book extends Product {
        private $weight;

        public function __construct($data) {
            parent::__construct($data);
            $this->setWeight(validate($data['weight'], 'weight'));
        }

        public function getWeight() {
            return $this->weight;
        }

        public function setWeight($weight) {
            $this->weight = $weight;
        }

        /**
         * Adds book to database
         */
        public function addProduct() {
            $sql = "INSERT INTO product VALUES('" . $this->getSku() . "', '" . $this->getName() . "', " . $this->getPrice() . ", '" . $this->getProductType() . "');";
            $sql .= "INSERT INTO book VALUES('" . $this->getSku() . "', " . $this->getWeight() . ");";
            $database = new Database();
            $database->saveProduct($sql);
        }

    }
?>