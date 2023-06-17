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

<ul id="customerList"></ul>

<script>
    // Assuming you have the MongoDB query result stored in the `transactionsJson` variable
    var transactions = <?php echo json_encode($transactions); ?>;

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


        // Calculate total transaction value for each customer ID
        var customerTransactions = {};

        filteredTransactions.forEach(function(transaction) {
            var customerId = transaction.cust_id;
            var totalPrice = transaction.total_price;
            if (customerTransactions[customerId]) {
                customerTransactions[customerId] += totalPrice;
            } else {
                customerTransactions[customerId] = totalPrice;
            }
        });

        // Sort customer transactions by value in descending order
        var sortedCustomerTransactions = Object.entries(customerTransactions).sort(function(a, b) {
            return b[1] - a[1];
        });

        // Get top 5 customer IDs with their total transaction value
        var top5Customers = sortedCustomerTransactions.slice(0, 5).map(function(entry) {
            return {
                customerId: entry[0],
                totalTransactionValue: entry[1]
            };
        });

        // Display the customer list
        var customerList = document.getElementById("customerList");
        customerList.innerHTML = "";

        top5Customers.forEach(function(customer) {
            var listItem = document.createElement("li");
            listItem.textContent = "Customer ID: " + customer.customerId + ", Total Transaction Value: " + customer.totalTransactionValue;
            customerList.appendChild(listItem);
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

