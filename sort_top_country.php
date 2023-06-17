<?php
require '../vendor/autoload.php';

$client = new MongoDB\Client("mongodb://localhost:27017");
$collection = $client->projek_pds->new_list;
$transactions = $collection->find()->toArray();

?>

<a id="last7DaysButton" class="dropdown-item" href="javascript:void(0);">Last 7 Days</a>
<a id="last4WeeksButton" class="dropdown-item" href="javascript:void(0);">Last 4 Weeks</a>
<a id="last8WeeksButton" class="dropdown-item" href="javascript:void(0);">Last 8 Weeks</a>
<a id="allTimeButton" class="dropdown-item" href="javascript:void(0);">Show All</a>

<ul id="countryList"></ul>

<script>
    // Assuming you have the MongoDB query result stored in the `transactions` variable
    var transactions = <?php echo json_encode($transactions); ?>;
    var filteredTransactions = []; // Initialize as an empty array

    function filterTransactions(filter) {
        var currentDate = new Date('2011-01-10');
        var startDate;

        if (filter === 'last7days') {
            startDate = new Date(currentDate.getTime() - 7 * 24 * 60 * 60 * 1000);
            console.log(startDate);
        } else if (filter === 'last4weeks') {
            startDate = new Date(currentDate.getTime() - 4 * 7 * 24 * 60 * 60 * 1000);
            console.log(startDate);
        } else if (filter === 'last8weeks') {
            startDate = new Date(currentDate.getTime() - 8 * 7 * 24 * 60 * 60 * 1000);
            console.log(startDate);
        } else if (filter === 'allTime') {
            startDate = new Date(2010, 0, 1);
        } else {
            console.log('Invalid filter');
            return;
        }

        // Filter the transactions based on the date range
        filteredTransactions = transactions.filter(function(transaction) {
            var transactionDateParts = transaction.date.split('/');
            var transactionDate = new Date(
                transactionDateParts[2],
                transactionDateParts[1] - 1,
                transactionDateParts[0]
            );
            return transactionDate >= startDate && transactionDate <= currentDate;
        });

        // Calculate country transaction counts
        var countryCounts = {};

        filteredTransactions.forEach(function(transaction) {
            var country = transaction.ship_country;

            if (countryCounts[country]) {
                countryCounts[country]++;
            } else {
                countryCounts[country] = 1;
            }
        });

        // Sort country counts in descending order
        var sortedCountryCounts = Object.entries(countryCounts).sort(function(a, b) {
            return b[1] - a[1];
        });

        // Get top 5 country destinations
        var top5Countries = sortedCountryCounts.slice(0, 5).map(function(entry) {
            return {
                country: entry[0],
                count: entry[1]
            };
        });

        // Update the country list in the HTML
        var countryList = document.getElementById('countryList');
        countryList.innerHTML = ''; // Clear previous list

        top5Countries.forEach(function(country) {
            var li = document.createElement('li');
            li.innerText = 'Country: ' + country.country + ', Transaction Count: ' + country.count;
            countryList.appendChild(li);
        });
    }

    // Button event listeners
    var last7DaysButton = document.getElementById('last7DaysButton');
    last7DaysButton.addEventListener('click', function() {
        filterTransactions('last7days');
    });

    var last4WeeksButton = document.getElementById('last4WeeksButton');
    last4WeeksButton.addEventListener('click', function() {
        filterTransactions('last4weeks');
    });

    var last8WeeksButton = document.getElementById('last8WeeksButton');
    last8WeeksButton.addEventListener('click', function() {
        filterTransactions('last8weeks');
    });

    var allTimeButton = document.getElementById('allTimeButton');
    allTimeButton.addEventListener('click', function() {
        filterTransactions('allTime');
    });

    // Initially filter for the last 7 days
    filterTransactions('last7days');
</script>