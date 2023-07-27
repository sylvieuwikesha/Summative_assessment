<?php
if (isset($_GET['flightOffer'])) {
    // Retrieve the Base64-encoded flight offer data from the query parameter
    $base64FlightOfferData = $_GET['flightOffer'];
    // Decode the Base64 data to obtain the flight offer details
    $flightOfferData = json_decode(base64_decode(urldecode($base64FlightOfferData)), true);
} else {
    // Redirect the user back to the flight search page if the flight offer data is missing
    header('Location: flight_search.html');
    exit();
}

// Function to send a request to the book_price endpoint
function fetchBookPriceData($flightOfferData) {
    $endpoint = 'http://localhost/a_flight/book_price.php';
    $queryParam = 'flightOffer=' . urlencode(urldecode($flightOfferData));
    $url = $endpoint . '?' . $queryParam;

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    curl_close($ch);

    return $response;
}

// Call the book_price endpoint and get the booking data in JSON format
$bookingDataJson = fetchBookPriceData($base64FlightOfferData);
$bookingData = json_decode($bookingDataJson, true);
?>

<!DOCTYPE html>
<html>
<head>
    <title>AirlinesFresh Book - Booking Confirmation</title>
    <!-- Add Bootstrap CSS link -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h1 class="my-4">Booking Confirmation</h1>
        <div class="card">
            <div class="card-body">
                <h2>Flight Details:</h2>
                <p><strong>Airline:</strong> <?php echo $flightOfferData['validatingAirlineCodes'][0]; ?></p>
                <p><strong>Departure City:</strong> <?php echo $bookingData['data']['flightOffers'][0]['itineraries'][0]['segments'][0]['departure']['iataCode']; ?></p>
                <p><strong>Destination City:</strong> <?php echo $bookingData['data']['flightOffers'][0]['itineraries'][0]['segments'][1]['arrival']['iataCode']; ?></p>
                <p><strong>Departure Date:</strong> <?php echo $bookingData['data']['flightOffers'][0]['itineraries'][0]['segments'][0]['departure']['at']; ?></p>
                <p><strong>Return Date:</strong> <?php echo $bookingData['data']['flightOffers'][0]['itineraries'][1]['segments'][0]['departure']['at']; ?></p>
                <p><strong>Total Price:</strong> <?php echo $bookingData['data']['flightOffers'][0]['price']['currency'] . ' ' . $bookingData['data']['flightOffers'][0]['price']['total']; ?></p>
            </div>
        </div>

        <!-- Passenger details form -->
        <form id="bookingForm" method="POST" action="/make_order.php" class="my-4">
            <!-- Hidden input field to store the Base64-encoded flight offer data -->
            <input type="hidden" name="flightOfferPrice_data" value="<?php echo base64_encode(json_encode($bookingData['data'])); ?>">

            <h2 class="my-4">Passenger 1</h2>
            <!-- Add other fields for passenger details here -->
            <div class="form-group">
                <label for="firstName">First Name:</label>
                <input type="text" class="form-control" id="firstName" name="travelers[0][name][firstName]" required>
            </div>

            <div class="form-group">
                <label for="lastName">Last Name:</label>
                <input type="text" class="form-control" id="lastName" name="travelers[0][name][lastName]" required>
            </div>

            <div class="form-group">
                <label for="dateOfBirth">Date of Birth:</label>
                <input type="date" class="form-control" id="dateOfBirth" name="travelers[0][dateOfBirth]" required>
            </div>

            <div class="form-group">
                <label for="gender">Gender:</label>
                <select class="form-control" id="gender" name="travelers[0][gender]" required>
                    <option value="MALE">Male</option>
                    <option value="FEMALE">Female</option>
                    <option value="OTHER">Other</option>
                </select>
            </div>

            <div class="form-group">
                <label for="emailAddress">Email Address:</label>
                <input type="email" class="form-control" id="emailAddress" name="travelers[0][contact][emailAddress]" required>
            </div>

            <div class="form-group">
                <label for="phoneNumber">Phone Number:</label>
                <input type="tel" class="form-control" id="phoneNumber" name="travelers[0][contact][phones][0][number]" required>
            </div>

            <div class="form-group">
                <label for="documentType">Document Type (e.g., Passport):</label>
                <input type="text" class="form-control" id="documentType" name="travelers[0][documents][0][documentType]" required>
            </div>

            <div class="form-group">
                <label for="birthPlace">Place of Birth:</label>
                <input type="text" class="form-control" id="birthPlace" name="travelers[0][documents][0][birthPlace]" required>
            </div>

            <div class="form-group">
                <label for="issuanceLocation">Issuance Location:</label>
                <input type="text" class="form-control" id="issuanceLocation" name="travelers[0][documents][0][issuanceLocation]" required>
            </div>

            <div class="form-group">
                <label for="issuanceDate">Issuance Date:</label>
                <input type="date" class="form-control" id="issuanceDate" name="travelers[0][documents][0][issuanceDate]" required>
            </div>

            <div class="form-group">
                <label for="expiryDate">Expiry Date:</label>
                <input type="date" class="form-control" id="expiryDate" name="travelers[0][documents][0][expiryDate]" required>
            </div>

            <!-- Add other fields or additional passengers' details here, if needed -->

            <!-- Button to confirm the booking -->
            <button type="submit" class="btn btn-primary">Confirm Booking</button>
        </form>
    </div>

    <!-- Add Bootstrap JS link -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
