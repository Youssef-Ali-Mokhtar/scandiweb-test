<?php
    class Database {
        private $conn;
        private static $sqlDisplay = 'SELECT p.sku, p.name, p.price, p.product_type FROM product AS p';

        public function __construct() {
            $this->connect();
        }

        /**
         * Connects to database
         */
        private function connect() {
            //local machine configuration
			$servername = 'localhost';
			$username = 'youssef';
			$password = 'ScandiTest';
			$dbname = 'scandiweb_test';

            // Create connection
            $this->conn = new mysqli($servername, $username, $password, $dbname);
            // Check connection
            if ($this->conn->connect_error) {
                die("Connection failed: " . $this->conn->connect_error);
            }
        }

        /**
         * Injects table attributes for SELECT and concatenates table names for JOIN to construct 
         * the mysql query used to fetch from the database the products needed to be listed
         *
         * @param string $class The name of the table.
         * @param array $attributes The array that holds the columns name.
         */
        public static function updateDisplaySql($class, $attributes) {
            $prefixedAttributes = array_map(function ($attribute) use ($class) {
                return $class['0'] . '.' . $attribute;
            }, $attributes);
            
            self::$sqlDisplay = substr_replace(self::$sqlDisplay, ", " . implode(", ", $prefixedAttributes), 45, 0);
        
            self::$sqlDisplay .= " LEFT JOIN  ". $class . " AS " . $class[0] . " ON p.sku = " . $class[0] . ".sku";
        }


        /**
         * Adds product to database
         * @param string $sql The constructed query to add a product to the database
         */
        public function saveProduct($sql) {
            try {
                if ($this->conn->multi_query($sql) === TRUE) {
                    echo json_encode($sql);
                } else {
                    echo json_encode("An error occurred: " . $e->getMessage());
                }
                
            } catch (Exception $e) {
                echo json_encode("An error occurred: " . $e->getMessage());
            } finally {
                $this->conn->close();
            }
        }
             
        /**
         * //Deletes products from database
         */
        public function removeProducts($sql, $table) {
            try {
                if ($this->conn->multi_query($sql) === TRUE) {
                    if($table === 'product'){
                        echo json_encode("Record has been deleted successfully!");
                    }
                } else {
                    echo json_encode("An error occurred: " . $e->getMessage());
                }
            } catch (Exception $e) {
                echo json_encode("An error occurred: " . $e->getMessage());
            } finally {
                $this->conn->close();
            }
        }

        /**
         * Fetches products from database
         */
        public function fetchProducts() {
            try {
                $result = $this->conn->query(self::$sqlDisplay);
                $products = $result->fetch_all(MYSQLI_ASSOC);

                if ($products > 0) {
                    echo json_encode($products);
                } else {
                    echo json_encode("Nothing to display");
                }
            } catch (Exception $e) {
                echo json_encode("An error occurred: " . $e->getMessage());
            } finally {
                $this->conn->close();
            }
        }
    }
?>