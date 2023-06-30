<?php
    namespace models;
    use \ProductRepository;
    use \utility\Validation;
    
    abstract class Product {
        protected $sku;
        protected $name;
        protected $price;
        protected $productType;

        protected function __construct($data) {
            $this->setSku(Validation::validate($data['sku'], 'sku'));
            $this->setName(Validation::validate($data['name'], 'name'));
            $this->setPrice(Validation::validate($data['price'], 'price'));
            $this->setProductType(Validation::validate($data['product_type'], 'product_type'));
        }

        protected function getSku() {
            return $this->sku;
        }

        protected function getName() {
            return $this->name;
        }

        protected function getPrice() {
            return $this->price;
        }

        protected function getProductType() {
            return $this->productType;
        }

        protected function setSku($sku) {
            $this->sku = $sku;
        }

        protected function setName($name) {
            $this->name = $name;
        }

        protected function setPrice($price) {
            $this->price = $price;
        }

        protected function setProductType($setProductType) {
            $this->productType = $setProductType;
        }

        protected function getParentProperties() {
            return [$this->sku, $this->name, $this->price, $this->productType];
        }

        protected abstract function getChildProperties();

        /**
         * Adds different products with different queries depending on the subclass
         */
        protected abstract function addProduct();

        /**
         * Deletes all products in $tables that have the SKUs in $arrSku
         * 
         * @param array $arrSku SKUs of the products that have to be deleted 
         * @param array $tables Database tables that we will delete from
         */
        public static function deleteProducts($arrSku, $tables) {
            $productRepository = new ProductRepository();
            $productRepository->deleteProductsFromDatabase($arrSku, $tables);
        }

        /**
         * Fetches all the products through the passed product types
         * 
         * @param array $tables Associative array of product types (key) and their exclusive properties (value)
         */
        public static function displayProducts($tables) {
            //Inject table attirbutes and table names into sql query
            $productRepository = new ProductRepository();
            $productRepository->viewProductsFromDatabase($tables);
        }
        
    }
?>