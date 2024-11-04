<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ChicFoot - Register</title>
    <link rel="stylesheet" href="../css/index.css">
    <script>
        
        var httpreEmail;
        var httpRequest;
        var typingTimer; 
        var doneTypingInterval = 500; // Time in milliseconds to wait after the last key stroke


        function checkUsername() {
            clearTimeout(typingTimer); 
            document.getElementById("usernameResult").innerHTML = ""; 
            document.getElementById("username").className = "thinking";

            
            typingTimer = setTimeout(function() {
                var username = document.getElementById("username").value;

                
                if (username.trim() !== "") {
                    httpRequest = new XMLHttpRequest();
                    httpRequest.onreadystatechange = showResult;
                    httpRequest.open("GET", "check-username.php?Username=" + encodeURIComponent(username));
                    httpRequest.send();
                } else {
                    document.getElementById("username").className = ""; 
                }
            }, doneTypingInterval);
        }

        function showResult() {
            if (httpRequest.readyState == 4 && httpRequest.status == 200) {
                if (httpRequest.responseText == "okay") {
                    document.getElementById("username").className = "approved";
                } else {
                    document.getElementById("username").className = "denied";
                    document.getElementById("usernameResult").innerHTML = "Username has already been used.";
                }
            }
        }

        function checkemail(){
            
            var email = document.getElementById("email").value;
            httpreEmail = new XMLHttpRequest();
            httpreEmail.onreadystatechange = showResultEmail;
            httpreEmail.open("GET", "check-email.php?Email=" + email);
            httpreEmail.send();
        }
        function showResultEmail() {
            
            var message = '';

            if (httpreEmail.readyState == 4 && httpreEmail.status == 200) {
                document.getElementById("emailResult").innerHTML = httpreEmail.responseText;
            }
        }

        function validatePasswords() {
            var password = document.getElementById("password").value;
            var confirmPassword = document.getElementById("confirmPassword").value;
            var message = '';

            if (password !== confirmPassword) {
                message = "Passwords do not match.";
                
            } else {
                message = "Passwords match.";
            }

            document.getElementById("passwordResult").innerHTML = message;

            if(message == "Passwords do not match."){
                document.getElementById("confirmPassword").focus;
            }
        }
    </script>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #2fab91, #63e0ac);
        }

        
        .register-container {
            width: 100%;
            max-width: 400px;
            padding: 40px;
            background-color: rgba(255, 255, 255, 0.9);
            border-radius: 10px;
            box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.2);
            text-align: center;
        }

        
        .logo img {
            width: 250px; 
            margin-bottom: 20px;
        }

        
        form input[type="text"],
        form input[type="password"],
        form input[type="email"] {
            width: 100%;
            padding: 15px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-sizing: border-box;
            font-size: 16px;
            transition: 0.3s;
        }

        
        form input[type="text"]:focus,
        form input[type="password"]:focus ,
        form input[type="email"]:focus {
            border-color: #2fab91;
            box-shadow: 0px 0px 5px rgba(47, 171, 91, 0.5);
            outline: none;
        }

        #emailResult{
            color: red;
        }

        
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

        
        .button:hover {
            background-color: #63e0ac;
        }

        .thinking,
        .approved,
        .denied {
            background-size: 40px; 
            background-repeat: no-repeat;
            background-position: right center; 
            padding-right: 30px; 
        }
        
        .thinking {
            background-image: url("../thinking.gif");
            
            
        }

        .approved {
            background-image: url("../okay.gif");
            
            
        }

        .denied {
            background-image: url("../no.gif");
            
            
        }
    </style>
</head>

<body>
    <div class="register-container">
        <div class="logo">
            <img src="../logonew.png" alt="Site Logo">
        </div>
        <form action="./register.php" method="POST">
            <input type="text" id="username" name="username" placeholder="Username"  required oninput="checkUsername()">
            <div id="usernameResult" style="color: red;"></div>
            <input type="text" name="firstname" id="firstname" placeholder="Firstname" required><br>
            <input type="text" name="lastname" id="lastname" placeholder="Lastname" required><br>
            <input type="email" name="email" id="email" placeholder="Email" onblur="checkemail()" required><br>
            <div id="emailResult"></div>
            <input type="password" name="password" id="password" placeholder="Password" required oninput="validatePasswords()">
            <input type="password" name="confirmPassword" id="confirmPassword" placeholder="Confirm Password" required oninput="validatePasswords()">
            <div id="passwordResult"></div>
            <input type="submit" value="Register" class="button">
        </form>
    </div>
</body>
</html>
            
            