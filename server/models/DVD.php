<?php
    namespace models;
    use \ProductRepository;
    use \models\Product;
    use \utility\Validation;

    class DVD extends Product{
        private $size;

        public function __construct($data) {
            parent::__construct($data);
            $this->setSize(Validation::validate($data['size'], 'size'));
        }

        public function getSize() {
            return $this->size;
        }

        public function setSize($size) {
            $this->size = $size;
        }

        public function getChildProperties(){
            return [$this->sku, $this->size];
        }

        /**
         * Adds book to database
         */
        public function addProduct() {
            $productRepository = new ProductRepository();
            $productRepository->addProductToDatabase('dvd', $this->getParentProperties(), $this->getChildProperties());
        }

    }
?>