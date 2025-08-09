<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">\
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <title>Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #4f46e5, #3b82f6);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .login-container {
            background: white;
            padding: 30px 40px;
            border-radius: 15px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 400px;
            text-align: center;
        }

        .logo {
            width: 80px;
            height: 80px;
            margin-bottom: 15px;
        }

        h2 {
            margin-bottom: 20px;
            color: #333;
        }

        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 12px;
            margin: 8px 0 15px;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-sizing: border-box;
            font-size: 14px;
        }

        button {
            width: 100%;
            padding: 12px;
            background: #4f46e5;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            cursor: pointer;
            transition: 0.3s;
        }

        button:hover {
            background: #3b36c5;
        }

        label {
            font-size: 14px;
            color: #555;
        }

        a {
            color: #4f46e5;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }

        .message {
            font-size: 14px;
            margin-bottom: 10px;
        }

        .success {
            color: green;
        }

        .error {
            color: red;
        }
    </style>
</head>

<body>

    <div class="login-container">
        <h2><i class="fa-solid fa-gift" style="color:#4f46e5; margin-right:8px;"></i>PRIZE</h2>
        <h2>Login</h2>

        @if (session('success'))
            <p class="message success">{{ session('success') }}</p>
        @endif

        @error('email')
            <p class="message error">{{ $message }}</p>
        @enderror

        <form method="POST" action="{{ route('login') }}">
            @csrf
            <input type="email" name="email" placeholder="Email" value="{{ old('email') }}" required>
            <input type="password" name="password" placeholder="Password" required>
            <div style="text-align: left; margin-bottom: 15px;">
                <label>
                    <input type="checkbox" name="remember"> Remember me
                </label>
            </div>
            <button type="submit">Login</button>
        </form>

        <p style="margin-top: 15px;">Belum punya akun? <a href="{{ route('register') }}">Register</a></p>
    </div>

</body>

</html>
