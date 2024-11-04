<?php include "../connect.php"; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Form</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        /* Reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        /* Background */
        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            background-color: #333;
        }

        /* Form Container */
        .contact-form-container {
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            width: 400px;
            padding: 20px;
            text-align: center;
            margin: auto;
            margin-top: 40px;
        }

        /* Form Title */
        .contact-form-container h2 {
            font-size: 24px;
            color: #333;
            margin-bottom: 20px;
        }

        /* Form */
        .contact-form {
            display: flex;
            flex-direction: column;
        }

        /* Input Group */
        .input-group {
            position: relative;
            margin-bottom: 15px;
        }

        /* Input Fields */
        .contact-form input,
        .contact-form textarea {
            width: 100%;
            padding: 12px 15px 12px 40px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 14px;
            color: #555;
            outline: none;
            transition: border-color 0.3s;
        }

        .contact-form textarea {
            resize: none;
            height: 100px;
        }

        /* Icons */
        .input-group i {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #aaa;
        }

        /* Button */
        .contact-form button {
            padding: 12px;
            font-size: 16px;
            color: #fff;
            background-color: #007bff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .contact-form button:hover {
            background-color: #0056b3;
        }

        /* Footer */
        footer {
            background-color: #333;
            color: #fff;
            text-align: center;
            padding: 10px 0;
            margin-top: auto;
        }
    </style>
</head>
<body>

    
    <?php include '../Template/navbar.php'; ?>

    <div class="contact-form-container">
        <h2>Send us a Message</h2>
        <form class="contact-form" action="contact.php" method="post">
            <div class="input-group">
                <i class="fas fa-user"></i>
                <input type="text" name="name" placeholder="Enter your name" required>
            </div>
            <div class="input-group">
                <i class="fas fa-envelope"></i>
                <input type="email" name="email" placeholder="Enter your email" required>
            </div>
            <div class="input-group">
                <i class="fas fa-phone"></i>
                <input type="tel" name="phone" placeholder="Enter your phone" required>
            </div>
            <div class="input-group">
                <i class="fas fa-comment"></i>
                <textarea name="message" placeholder="Write your message" required></textarea>
            </div>
            <button type="submit">Send Message</button>
        </form>
    </div>

    
    <?php include '../Template/footer.php'; ?>

</body>
</html>
