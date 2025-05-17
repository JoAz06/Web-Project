<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$errors = [];
$name = $email = $subject = $message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate name
    if (empty($_POST['name'])) {
        $errors[] = "Name is required";
    } else {
        $name = htmlspecialchars($_POST['name']);
    }

    // Validate email
    if (empty($_POST['email'])) {
        $errors[] = "Email is required";
    } else {
        $email = htmlspecialchars($_POST['email']);
    }

    // Validate subject
    if (empty($_POST['subject'])) {
        $errors[] = "Subject is required";
    } else {
        $subject = htmlspecialchars($_POST['subject']);
    }

    // Validate message
    if (empty($_POST['message'])) {
        $errors[] = "Message is required";
    } else {
        $message = htmlspecialchars($_POST['message']);
    }

    // If no errors, proceed with database insertion
    if (empty($errors)) {
        try {
            $conn = new mysqli('localhost', 'root', '', 'WebProject');
            if ($conn->connect_error) {
                throw new Exception("Connection failed: " . $conn->connect_error);
            }
            
            $stmt = $conn->prepare("INSERT INTO contact (fname, email, subject, message) VALUES (?, ?, ?, ?)");
            if (!$stmt) {
                throw new Exception("Prepare failed: " . $conn->error);
            }
            
            $stmt->bind_param("ssss", $name, $email, $subject, $message);
            if (!$stmt->execute()) {
                throw new Exception("Execute failed: " . $stmt->error);
            }
            
            $stmt->close();
            $conn->close();
        } catch (Exception $e) {
            $errors[] = "Database error: " . $e->getMessage();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thank You - Message Received</title>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Arabic:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .thank-you-section {
            text-align: center;
            padding: 50px 20px;
        }

        .thank-you-section h1 {
            color: #2563eb;
            margin-bottom: 30px;
        }

        .message-box {
            background-color: #f8f9fa;
            padding: 30px;
            border-radius: 10px;
            max-width: 600px;
            margin: 0 auto;
        }

        .message-box h2 {
            color: #155724;
            margin-bottom: 20px;
        }

        .submitted-info {
            text-align: left;
            margin-top: 30px;
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .submitted-info h3 {
            color: #2563eb;
            margin-bottom: 15px;
            font-size: 1.2em;
        }

        .submitted-info p {
            color: #333;
            margin: 10px 0;
        }

        .submitted-info strong {
            color: #2563eb;
        }

        .back-link {
            margin-top: 30px;
        }

        .back-link a {
            display: inline-block;
            padding: 10px 20px;
            background-color: #2563eb;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }

        .error-message {
            background-color: #f8d7da;
            color: #721c24;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
            text-align: left;
        }

        .error-message ul {
            margin: 10px 0;
            padding-left: 20px;
        }

        .error-message li {
            margin: 5px 0;
        }
    </style>
</head>
<body>
    <div class="layout">
        <main class="main-content">
            <section class="thank-you-section">
                <?php if (!empty($errors)): ?>
                    <div class="message-box">
                        <div class="error-message">
                            <h2><i class="fas fa-exclamation-circle"></i> Please correct the following errors:</h2>
                            <ul>
                                <?php foreach ($errors as $error): ?>
                                    <li><?php echo $error; ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                        <div class="back-link">
                            <a href="contact.html">
                                <i class="fas fa-arrow-left"></i> Back to Contact Form
                            </a>
                        </div>
                    </div>
                <?php else: ?>
                    <h1>
                        <i class="fas fa-check-circle"></i> Thank You!
                    </h1>
                    <div class="message-box">
                        <h2>Your Message Has Been Submitted!</h2>
                        
                        <div class="submitted-info">
                            <h3>Submitted Information:</h3>
                            <p><strong>Name:</strong> <?php echo $name; ?></p>
                            <p><strong>Email:</strong> <?php echo $email; ?></p>
                            <p><strong>Subject:</strong> <?php echo $subject; ?></p>
                            <p><strong>Message:</strong> <?php echo nl2br($message); ?></p>
                        </div>

                        <div class="back-link">
                            <a href="contact.php">
                                <i class="fas fa-arrow-left"></i> Back to Contact Form
                            </a>
                        </div>
                    </div>
                <?php endif; ?>
            </section>
        </main>
    </div>
</body>
</html>