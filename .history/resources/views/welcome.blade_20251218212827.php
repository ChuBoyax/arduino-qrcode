<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.css">
    <script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>
    <style>
        * {
            box-sizing: border-box;
            font-family: Arial, Helvetica, sans-serif;
        }

        body {
            margin: 0;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background: #f4f6f8;
        }

        .login-box {
            width: 100%;
            max-width: 380px;
            background: #ffffff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.08);
        }

        .login-box h2 {
            text-align: center;
            margin-bottom: 25px;
            color: #333;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-size: 14px;
            color: #555;
        }

        .form-group input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 14px;
        }

        .form-group input:focus {
            outline: none;
            border-color: #2563eb;
        }

        .login-btn {
            width: 100%;
            padding: 12px;
            border: none;
            border-radius: 5px;
            background: #2563eb;
            color: #fff;
            font-size: 15px;
            cursor: pointer;
        }

        .login-btn:hover {
            background: #1e4fd6;
        }

        .footer-text {
            text-align: center;
            margin-top: 15px;
            font-size: 13px;
            color: #777;
        }
    </style>
</head>
<body>
    <div class="login-box">
        <h2>Login</h2>
        <form id="loginForm">
            <div class="form-group">
                <label>Email</label>
                <input type="email" id="email" placeholder="Enter your email" required>
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" id="password" placeholder="Enter your password" required>
            </div>
            <button type="submit" class="login-btn">Sign In</button>
        </form>
        <div class="footer-text">
            © 2025 Your System
        </div>
    </div>
</body>
</html>
<script>
    var notyf = new Notyf({
        position: { x: 'right', y: 'top' }, 
        duration: 3000, 
        ripple: true,
        dismissible: true
    });
    document.getElementById("loginForm").addEventListener("submit", function(e) {
        e.preventDefault();
        var email = document.getElementById("email").value;
        var password = document.getElementById("password").value;

        fetch("http://arduino-qrcode.test/api/login", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "Accept": "application/json"
            },
            body: JSON.stringify({email: email, password: password})
        })
        .then(function(res) {
            return res.json().then(function(data){
                if (!res.ok) throw data;
                return data;
            });
        })
        .then(function(data){
            localStorage.setItem("token", data.token);
            localStorage.setItem("user", JSON.stringify(data.user));
            notyf.success('Login successful!');
            setTimeout(function() {
                window.location.href = "http://arduino-qr.test/dashboard";
            }, 1000); 
        })
        .catch(function(err){
            notyf.error(err.message || "Invalid email or password");
        });
    });
</script>


