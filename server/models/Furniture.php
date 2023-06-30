<?php
    namespace models;
    use \ProductRepository;
    use \models\Product;
    use \utility\Validation;
    
    class Furniture extends Product {
        private $height;
        private $width;
        private $length;

        public function __construct($data) {
            parent::__construct($data);
            $this->setHeight(Validation::validate($data['height'], 'height'));
            $this->setWidth(Validation::validate($data['width'], 'width'));
            $this->setLength(Validation::validate($data['length'], 'length'));
        }

        public function getHeight() {
            return $this->height;
        }

        public function getWidth() {
            return $this->width;
        }

        public function getLength() {
            return $this->length;
        }

        public function setHeight($height) {
            $this->height = $height;
        }

        public function setWidth($width) {
            $this->width = $width;
        }

        public function setLength($length) {
            $this->length = $length;
        }

        public function getChildProperties(){
            return [$this->sku, $this->height, $this->width, $this->length];
        }

        /**
         * Adds furniture to database
         */
        public function addProduct() {
            $productRepository = new ProductRepository();
            $productRepository->addProductToDatabase('furniture', $this->getParentProperties(), $this->getChildProperties());
        }
    }
?>