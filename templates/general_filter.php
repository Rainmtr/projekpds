<?php
require '../vendor/autoload.php';

$client = new MongoDB\Client("mongodb://localhost:27017");
$collection = $client->projek_pds->transaction_list;
$transactions = $collection->find()->toArray();
?>

<!-- <script>
    // Assuming you have the MongoDB query result stored in the `transactionsJson` variable
    var transactions =  ;

    // Filter transactions based on date range (last 7 days)
    var currentDate = new Date('2010-12-08');
    var sevenDaysAgo = new Date(currentDate.getTime() - 7 * 24 * 60 * 60 * 1000);

    var filteredTransactions = transactions.filter(function(transaction) {
        var transactionDateParts = transaction.date.split('/');
        var transactionDate = new Date(
            transactionDateParts[2],
            transactionDateParts[1] - 1,
            transactionDateParts[0]
        );
        return transactionDate >= sevenDaysAgo && transactionDate <= currentDate;
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

    console.log(top5Customers);
</script> -->

<a class="dropdown-item" href="javascript:void(0);" id="lastWeekButton">Last 1 week</a>
<a class="dropdown-item" href="javascript:void(0);" id="allTimeButton">Show all</a>

<ul id="customerList"></ul>

<script>
    // Assuming you have the MongoDB query result stored in the `transactionsJson` variable
    var transactions = <?php echo json_encode($transactions); ?>;

    function filterTransactions(filter) {
        // Filter transactions based on date range
        var currentDate = new Date('2010-12-08');
        var sevenDaysAgo = new Date(currentDate.getTime() - 7 * 24 * 60 * 60 * 1000);

        var filteredTransactions;
        if (filter === 'lastWeek') {
            filteredTransactions = transactions.filter(function(transaction) {
                var transactionDateParts = transaction.date.split('/');
                var transactionDate = new Date(
                    transactionDateParts[2],
                    transactionDateParts[1] - 1,
                    transactionDateParts[0]
                );
                return transactionDate >= sevenDaysAgo && transactionDate <= currentDate;
            });
            console.log(filteredTransactions);
        } else {
            filteredTransactions = transactions;
            console.log(filteredTransactions);
        }

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

    // Initialize the customer list with the last 7 days filter
    filterTransactions('lastWeek');

    // Add event listeners to the buttons
    var lastWeekButton = document.getElementById("lastWeekButton");
    var allTimeButton = document.getElementById("allTimeButton");

    lastWeekButton.addEventListener("click", function() {
        filterTransactions('lastWeek');
    });

    allTimeButton.addEventListener("click", function() {
        filterTransactions('allTime');
    });
</script>

