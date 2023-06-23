<?php 

    $regEx = [
        'sku'=>"/^[a-zA-Z0-9_-]{3,}$/",
        'name'=>"/^[a-zA-Z]+(([',. -][a-zA-Z ])?[a-zA-Z]*)*$/",
        'price'=>"/^\d+(\.\d{1,2})?$/",
        'size'=>"/^\d+$/",
        'product_type'=>"/(Book|Furniture|DVD)/i",
        'weight'=>"/^\d+$/",
        'height'=>"/^\d+$/",
        'width'=>"/^\d+$/",
        'length'=>"/^\d+$/"
    ];

    function validate($data, $key){
        if(empty($data)){
            echo json_encode("Please, submit " . $key);
            exit(0);
        }else{
            return htmlspecialchars($data);
        }
    }
?>
