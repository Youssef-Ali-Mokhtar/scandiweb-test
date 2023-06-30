<?php

    use \database\Database;

    class ProductRepository {

        /**
         * Deletes products from Database that have SKUs in array $arrSKU from tables $tables
         * 
         * @param array $arrSku SKUs of the products that have to be deleted 
         * @param array $tables Database tables that we will delete from
         */

        public function deleteProductsFromDatabase($arrSku, $tables) {
            foreach ($tables as $table) {
                $sql = "DELETE FROM " . $table . " WHERE sku IN ('" . implode("','", $arrSku) . "'); ";
                $database = new Database();
                $database->removeProducts($sql, $table);
            }
        }

        /**
         * Views products from database
         * 
         * @param array $tables Associative array of product types (key) and their exclusive properties (value)
         */

        public function viewProductsFromDatabase($tables) {
            //Inject table attirbutes and table names into sql query
            foreach($tables as $key => $value) {
                Database::updateDisplaySql($key, $value);
            }
            //Fetch the tables after constructing the query
            $database = new Database();
            $database->fetchProducts();
        }

        /**
         * Adds a product to database
         * 
         * @param array $childAttributes Array of child specific properties
         * @param array $parentAttributes Array of parent common properties
         * @param string $productType The type of the submitted product
         */

        public function addProductToDatabase($productType, $parentAttributes, $childAttributes) {
            $sql = "INSERT INTO product VALUES('" . implode("', '", $parentAttributes) . "');";
            $sql .= "INSERT INTO " . $productType . " VALUES ('" . implode("', '", $childAttributes)  . "')";
            $database = new Database();
            $database->saveProduct($sql);
        }


    }
?>