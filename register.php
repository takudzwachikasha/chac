<?php

// Database connection
$servername = "sdb-69.hosting.stackcp.net";
$username = "con_registration-35303531df4e"; // Change this if your XAMPP username is different
$password = "8heou12un7"; // Change this if your XAMPP password is set
$database = "con_registration-35303531df4e";

$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Prepare data for insertion
$name = $_POST['name'];
$surname = $_POST['surname'];
$email = $_POST['email'];
$organization = $_POST['organization'];
$country = $_POST['country'];
$track = $_POST['track'];

// Generate unique ID
$query = "SELECT COUNT(*) as count FROM registrations";
$result = $conn->query($query);
$row = $result->fetch_assoc();
$count = $row['count'] + 1;
$id = "CHACA" . str_pad($count, 3, '0', STR_PAD_LEFT);

// Insert data into database
$insert_query = "INSERT INTO registrations (id, name, surname, email, organization, country, track) 
                 VALUES ('$id', '$name', '$surname', '$email', '$organization', '$country', '$track')";

if ($conn->query($insert_query) === TRUE) {
    echo "Registration Successful";
} else {
    echo "Error: " . $insert_query . "<br>" . $conn->error;
}

$to = $email;
    $subject = 'Registration Confirmation';
    $message = 'Dear ' . $name . ',<br><br>Your registration for the conference has been successfully submitted.<br><br>Thank you for registering!<br><br>Best regards,<br>Conference Team';

    $headers = "From: chacregistration@climatehealthconf.africa\r\n";
    $headers .= "Reply-To: chacregistration@climatehealthconf.africa\r\n";
    $headers .= "Content-type: text/html\r\n";

    if (mail($to, $subject, $message, $headers)) {
        echo "<script>alert('Successful registration. Confirmation email sent to your mailbox.');</script>";
    } else {
        echo "<script>alert('Registration successful, but confirmation email could not be sent.');</script>";
    }

$conn->close();

?>
