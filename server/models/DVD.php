<?php
    require_once 'database/Database.php';
    require_once 'Product.php';
    require_once './utility/Validation.php';
    
    class DVD extends Product {
        private $size;

        public function __construct($data){
            parent::__construct($data);
            $this->setSize(validate($data['size'], 'size'));
        }

        public function getSize() {
            return $this->size;
        }

        public function setSize($size) {
            $this->size = $size;
        }

        /**
         * Adds dvd to database
         */
        public function addProduct() {
            $sql = "INSERT INTO product VALUES('" . $this->getSku() . "', '" . $this->getName() . "', " . $this->getPrice() . ", '" . $this->getProductType() . "');";
            $sql .= "INSERT INTO dvd VALUES('" . $this->getSku() . "', " . $this->getSize() . ");";
            $database = new Database();
            $database->saveProduct($sql);
        }
    }
?>