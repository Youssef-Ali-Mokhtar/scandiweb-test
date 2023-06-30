<?php
    namespace models;

    class DisplayFactory {

        /**
         * A factory method that creates the array below
         * 
         * @param array $classes an associative array that has class name as key and properties
         * as it's values to be sent to Product class and be used for constructing mysql query
         */
        public static function createProductProperties($classes) {
            $tables = [];
            foreach($classes as $class) {
                if($class === 'book') {
                    $tables[$class] = ['weight'];
                } elseif($class === 'dvd') {
                    $tables[$class] = ['size'];
                } elseif($class === 'furniture') {
                    $tables[$class] = ['height', 'width', 'length'];
                } else {
                    die("Invalid product type");
                }
            }
            return $tables;
        }
    }
?>

