<?php
    require '../vendor/autoload.php';
    
    // Connect
    $client = new MongoDB\Client("mongodb://localhost:27017");
    echo "Connection successful" . "<br/>";

    $collection = $client->bookstore->books;

    $result = $collection->find( [ 'author' => 'Brandon Sanderson'] );

    // Get Array Key
    foreach ($result as $document) {
        $keys = array_keys($document->getArrayCopy());
        foreach ($keys as $key) {
            echo $key, "<br/>";
        }
    }

    // Print all attributes
    foreach ($result as $document) {
        get_object_value($document);
        echo "</br>";
    }

    function get_object_value($arr) {
        if ($arr instanceof MongoDB\Model\BSONArray || $arr instanceof MongoDB\Model\BSONDocument) {
            $arr = json_decode(json_encode($arr), true);
        }

        foreach ($arr as $key => $val) {
            if (is_array($val)) {
                get_object_value($val);
            } else {
                echo "$key = $val <br/>";
            }
        }     
    }
?>

