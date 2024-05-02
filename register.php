<?php
// Database connection
$servername = "sdb-m.hosting.stackcp.net";
$username = "user_registration-31393525fb";
$password = "a3y2zc1ilg";
$database = "user_registration-31393525fb";

$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $name = $_POST['name'];
    $surname = $_POST['surname'];
    $email = $_POST['email'];
    $organization = $_POST['organization'];
    $country = $_POST['country'];

    // Handle file upload
    $proof_of_payment_filename = "";
    if (isset($_FILES['proof_of_payment']) && $_FILES['proof_of_payment']['error'] === UPLOAD_ERR_OK) {
        $upload_directory = "uploads/";
        $proof_of_payment_filename = uniqid() . '_' . $_FILES['proof_of_payment']['name'];
        move_uploaded_file($_FILES['proof_of_payment']['tmp_name'], $upload_directory . $proof_of_payment_filename);
    }

    // Prepare and bind SQL statement
    $sql = "INSERT INTO registrations (name, surname, email, organization, country, proof_of_payment) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssss", $name, $surname, $email, $organization, $country, $proof_of_payment_filename);

    // Execute SQL statement
    if ($stmt->execute() === TRUE) {
        // Registration successful
        header("Location: success.html"); // Redirect to success page
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Close statement and connection
    $stmt->close();
    $conn->close();
}
?>
