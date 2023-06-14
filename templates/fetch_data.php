<?php
require '../../vendor/autoload.php';

// Connect to MongoDB
$client = new MongoDB\Client("mongodb://localhost:27017");
$collection = $client->projek_pds->transaction_list;

// Fetch data from MongoDB
$result = $collection->aggregate([
    [
        '$group' => [
            '_id' => '$ship_country',
            'count' => ['$sum' => 1]
        ]
    ]
]);

// Prepare data for JavaScript
$data = [];
foreach ($result as $document) {
    $data[] = [
        'label' => $document->_id,
        'value' => $document->count
    ];
}

// Print the data as JSON
header('Content-Type: application/json');
echo json_encode($data);
?>