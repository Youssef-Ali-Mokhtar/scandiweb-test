<?php
    class Database{
        private $conn;
        public static $sqlDisplay = 'SELECT p.sku, p.name, p.price, p.product_type FROM product AS p';

        public function __construct() {
            $this->connect();
        }

        //Connect to database
        public function connect() {
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

        //A function to inject a new child to display sql query string
        public static function updateDisplaySql($class, $attributes) {
            $prefixedAttributes = array_map(function ($attribute) use ($class) {
                return $class['0'] . '.' . $attribute;
            }, $attributes);
            
            self::$sqlDisplay = substr_replace(self::$sqlDisplay, ", " . implode(", ", $prefixedAttributes), 45, 0);
        
            self::$sqlDisplay .= " LEFT JOIN  ". $class . " AS " . $class[0] . " ON p.sku = " . $class[0] . ".sku";
        }

        //To reset sqlDisplay to it's original form 
        //(in case I want to display only one table, I need to make sure the sqlDisplay is empty from other tables)
        public static function resetDisplaySql() {
            self::$sqlDisplay = 'SELECT p.sku, p.name, p.price, p.product_type FROM product AS p';
        }

        //Add product to database
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
             

        //Delete products from database
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

        //Get products from database
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