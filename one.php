<?php
// Database connection
$conn = new mysqli("localhost", "root", "", "social_service_db");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Initialize form data variables
$full_name = $age = $gender = $email = $phone_number = $service_type = $availability = $comments = "";
$form_submitted = false; // Flag to check if the form is submitted

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $full_name = $_POST['full_name'];
    $age = $_POST['age'];
    $gender = $_POST['gender'];
    $email = $_POST['email'];
    $phone_number = $_POST['phone_number'];
    $service_type = $_POST['service_type'];
    $availability = $_POST['availability'];
    $comments = $_POST['comments'];

    // Insert the registration into the database
    $sql = "INSERT INTO registrations (full_name, age, gender, email, phone_number, service_type, availability, comments) 
            VALUES ('$full_name', '$age', '$gender', '$email', '$phone_number', '$service_type', '$availability', '$comments')";

    if ($conn->query($sql) === TRUE) {
        $message = "Registration successful!";
        $form_submitted = true; // Set flag to true when the form is submitted successfully
    } else {
        $message = "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Social Service Registration Form</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        .container {
            width: 80%;
            margin: 20px auto;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        h1, h2 {
            text-align: center;
            color: #333;
        }

        .registration-form {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        label {
            font-weight: bold;
        }

        input, textarea, select, button {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        button {
            background-color: #3498db;
            color: #fff;
            border: none;
            cursor: pointer;
        }

        button:hover {
            background-color: #2980b9;
        }

        .message {
            text-align: center;
            color: green;
            font-size: 18px;
        }

        .error {
            color: red;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Social Service Registration Form</h1>

        <!-- Show success/error message -->
        <?php if (isset($message)): ?>
            <p class="message"><?php echo $message; ?></p>
        <?php endif; ?>

        <!-- Show the entered data after successful registration -->
        <?php if ($form_submitted): ?>
            <h2>Submitted Data</h2>
            <p><strong>Full Name:</strong> <?php echo htmlspecialchars($full_name); ?></p>
            <p><strong>Age:</strong> <?php echo htmlspecialchars($age); ?></p>
            <p><strong>Gender:</strong> <?php echo htmlspecialchars($gender); ?></p>
            <p><strong>Email:</strong> <?php echo htmlspecialchars($email); ?></p>
            <p><strong>Phone Number:</strong> <?php echo htmlspecialchars($phone_number); ?></p>
            <p><strong>Service Type:</strong> <?php echo htmlspecialchars($service_type); ?></p>
            <p><strong>Availability:</strong> <?php echo htmlspecialchars($availability); ?></p>
            <p><strong>Additional Comments:</strong> <?php echo nl2br(htmlspecialchars($comments)); ?></p>
        <?php else: ?>
            <!-- Registration Form -->
            <form action="" method="POST" class="registration-form">
                <label for="full_name">Full Name:</label>
                <input type="text" name="full_name" id="full_name" required>

                <label for="age">Age:</label>
                <input type="number" name="age" id="age" required>

                <label for="gender">Gender:</label>
                <select name="gender" id="gender" required>
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                    <option value="Other">Other</option>
                </select>

                <label for="email">Email:</label>
                <input type="email" name="email" id="email" required>

                <label for="phone_number">Phone Number:</label>
                <input type="text" name="phone_number" id="phone_number" required>

                <label for="service_type">Type of Service:</label>
                <select name="service_type" id="service_type" required>
                    <option value="Teaching">Teaching</option>
                    <option value="Fundraising">Fundraising</option>
                    <option value="Event Organization">Event Organization</option>
                    <option value="Healthcare Assistance">Healthcare Assistance</option>
                    <option value="Other">Other</option>
                </select>

                <label for="availability">Availability:</label>
                <input type="text" name="availability" id="availability" placeholder="e.g., Weekends, Weekdays" required>

                <label for="comments">Additional Comments:</label>
                <textarea name="comments" id="comments" rows="4" placeholder="Any other details..."></textarea>

                <button type="submit">Register</button>
            </form>
        <?php endif; ?>
    </div>
</body>
</html>
