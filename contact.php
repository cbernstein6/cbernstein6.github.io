<?php
$servername = "localhost";
$username = "username";
$password = "password";
$dbname = "myDB";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // validate and sanitize input data
  $name = trim(filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING));
  $email = trim(filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL));
  $subject = trim(filter_input(INPUT_POST, 'subject', FILTER_SANITIZE_STRING));
  $message = trim(filter_input(INPUT_POST, 'message', FILTER_SANITIZE_STRING));

  // prepare and bind
  $stmt = $conn->prepare("INSERT INTO Contacts (name, email, subject, message) VALUES (?, ?, ?, ?)");
  $stmt->bind_param("ssss", $name, $email, $subject, $message);

  // set parameters and execute
  if ($stmt->execute()) {
    echo "New record created successfully";
  } else {
    echo "Error: " . $stmt->error;
  }

  $stmt->close();
} else {
  echo "No data received";
}

$conn->close();
?>
