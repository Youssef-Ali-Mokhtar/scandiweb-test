<?php 
    namespace controllers;
    use \models\DisplayFactory;
    use \models\Product;

    class ViewController {

        /**
         * Uses a factory class to create an associative array that has table names as keys and attributes 
         * as values and passes them to to Product class to construct the mysql query for listing products
         */
        public function showProducts() {

            /**
             * The products names are mentioned here because Product class (parent) isn't supposed to know
             * about the subclasses and they were already specified in the requirments, but in a big project
             * they shouldn't be hardcoded here, they could be coming from a GET query parameter for example
            */
            $classes = ['book', 'dvd', 'furniture'];
            $tables = DisplayFactory::createProductProperties($classes);

            Product::displayProducts($tables);
        }
    }
?>