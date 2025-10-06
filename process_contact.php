<?php
    // Database connection
    include 'config.php';

    // Check if form is submitted
    if(isset($_POST['submit'])) {
        // Get form data
        $name = mysqli_real_escape_string($conn, $_POST['name']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $message = mysqli_real_escape_string($conn, $_POST['message']);
        
        // Insert data into database
        $sql = "INSERT INTO contact_messages (name, email, message) 
                VALUES ('$name', '$email', '$message')";
        
        if(mysqli_query($conn, $sql)) {
            // Success message
            echo "<script>
                    alert('Thank you for your message. We will get back to you soon!');
                    window.location.href='index.php';
                  </script>";
        } else {
            // Error message
            echo "<script>
                    alert('Sorry, there was an error sending your message. Please try again.');
                    window.location.href='index.php';
                  </script>";
        }
    } else {
        // Redirect if accessed directly
        header('Location: index.php');
    }

    // Close database connection
    mysqli_close($conn);
?> 