<?php 

    /**
     * Validates the input by checking if it's empty then returns the value wrapped in
     * htmlspecialchars() functions to protect the server from XSS attacks
     * 
     * @param string $data The value of a property submitted
     * @param string $key The key of the value submitted
     */
    function validate($data, $key) {
        if(empty($data)) {
            echo json_encode("Please, submit " . $key);
            exit(0);
        } else {
            return htmlspecialchars($data);
        }
    }
?>
