<?php
    require_once "database/Database.php";
    require_once './utility/Validation.php';
    
    abstract class Product {
        protected $sku;
        protected $name;
        protected $price;
        protected $productType;

        protected function __construct($data) {
            $this->setSku(validate($data['sku'], 'sku'));
            $this->setName(validate($data['name'], 'name'));
            $this->setPrice(validate($data['price'], 'price'));
            $this->setProductType(validate($data['product_type'], 'product_type'));
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
            foreach($tables as $table) {
                $sql = "DELETE FROM " .$table. " WHERE sku IN ('". implode("','",$arrSku) ."'); ";
                $database = new Database();
                $database->removeProducts($sql, $table);
            }
        }

        /**
         * Fetches all the products in the passed product types
         * 
         * @param array $tables Associative array of product types (key) and their exclusive properties (value)
         */
        public static function displayProducts($tables) {

            //Inject table attirbutes and table names into sql query
            foreach($tables as $key => $value) {
                Database::updateDisplaySql($key, $value);
            }

            //Fetch the tables after constructing the query
            $database = new Database();
            $database->fetchProducts();
        }
        
    }
?>