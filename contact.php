<?php
// 1. Replace these variables with your InfinityFree Database details
$servername = "YOUR_DB_HOST";       // e.g., sql123.infinityfree.com
$username   = "YOUR_DB_USERNAME";   // e.g., if0_12345678
$password   = "YOUR_DB_PASSWORD";   // Your cPanel/vPanel password
$dbname     = "YOUR_DB_NAME";       // e.g., if0_12345678_portfolio

// 2. Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// 3. Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// 4. Process the form data when submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Sanitize input to prevent malicious code
    $name = htmlspecialchars(strip_tags($_POST['name']));
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $message = htmlspecialchars(strip_tags($_POST['message']));

    // 5. Use Prepared Statements to prevent SQL Injection (Best Practice)
    $stmt = $conn->prepare("INSERT INTO contact_messages (name, email, message) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $name, $email, $message);

    // 6. Execute and check if successful
    if ($stmt->execute()) {
        // Success: Show alert and redirect back to home page
        echo "<script>
                alert('Thank you, $name! Your message has been sent successfully.');
                window.location.href = 'index.html';
              </script>";
    } else {
        // Error handling
        echo "<script>
                alert('Oops! Something went wrong. Please try again later.');
                window.location.href = 'index.html';
              </script>";
    }

    // Close the statement
    $stmt->close();
}

// Close the connection
$conn->close();
?>