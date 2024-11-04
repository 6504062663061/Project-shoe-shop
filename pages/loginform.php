<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ChicFoot</title>
    <style>
        /* Apply a green gradient background to the entire page */
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #2fab91, #63e0ac);
        }

        /* Style for the login container */
        .login-container {
            width: 100%;
            max-width: 400px;
            padding: 40px;
            background-color: rgba(255, 255, 255, 0.9);
            border-radius: 10px;
            box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.2);
            text-align: center;
        }

        /* Logo styling - larger size */
        .logo img {
            width: 250px; /* Increased logo size */
            margin-bottom: 20px;
        }

        /* Style the form input fields */
        form input[type="text"],
        form input[type="password"] {
            width: 100%;
            padding: 15px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-sizing: border-box;
            font-size: 16px;
            transition: 0.3s;
        }

        /* Input fields focus effect */
        form input[type="text"]:focus,
        form input[type="password"]:focus {
            border-color: #2fab91;
            box-shadow: 0px 0px 5px rgba(47, 171, 91, 0.5);
            outline: none;
        }

        /* Style both buttons (login and register) */
        .button {
            width: 100%;
            padding: 15px;
            margin-top: 10px;
            background-color: #2fab91;
            color: white;
            font-size: 16px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: 0.3s;
            text-align: center;
            display: inline-block;
            text-decoration: none;
            box-sizing: border-box;
        }

        /* Button hover effect */
        .button:hover {
            background-color: #63e0ac;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="logo">
            <img src="../logonew.png" alt="Site Logo">
        </div>
        <form action="check-login.php" method="POST">
            <input type="text" name="Username" placeholder="Username" required>
            <input type="password" name="Password" placeholder="Password" required>
            <input type="submit" value="Login" class="button">
        </form>
        <a href="register.php" class="button">Register</a>
    </div>
</body>
</html>
