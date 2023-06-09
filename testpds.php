<?php
    require '../vendor/autoload.php';
    
    // Connect
    $client = new MongoDB\Client("mongodb://localhost:27017");
    echo "Connection successful" . "<br/>";

    $collection = $client->bookstore->books;

    $result = $collection->find( [ 'author' => 'Brandon Sanderson'] );

    foreach ($result as $document) {
        echo $document['title'], "</br>";
    }
?>

