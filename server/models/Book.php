<?php
    namespace models;
    use \ProductRepository;
    use \models\Product;
    use \utility\Validation;

    class Book extends Product{
        private $weight;

        public function __construct($data) {
            parent::__construct($data);
            $this->setWeight(Validation::validate($data['weight'], 'weight'));
        }

        public function getWeight() {
            return $this->weight;
        }

        public function setWeight($weight) {
            $this->weight = $weight;
        }

        public function getChildProperties(){
            return [$this->sku, $this->weight];
        }

        /**
         * Adds book to database
         */
        public function addProduct() {
            $productRepository = new ProductRepository();
            $productRepository->addProductToDatabase('book', $this->getParentProperties(), $this->getChildProperties());
        }

    }
?>