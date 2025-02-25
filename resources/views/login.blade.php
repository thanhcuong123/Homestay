<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập</title>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #777777;
            margin: 0;
            font-family: 'Roboto', sans-serif;
        }

        .login-container {
            background-color: #ffffff;
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.3);
            width: 100%;
            max-width: 400px;
            text-align: center;
        }

        .login-container h2 {
            margin-bottom: 30px;
            color: #794300;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            margin-bottom: 20px;
            text-align: left;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
            color: #f8b100;
            font-weight: 500;
        }

        .form-group a {
            align-self: flex-end;
            margin-top: 10px;
            color: #f8b100;
            font-size: 14px;
        }

        .form-group input {
            width: 100%;
            padding: 12px;
            border: 1px solid #794300;
            border-radius: 10px;
            box-sizing: border-box;
            font-size: 16px;
            outline: none;
            transition: border-color 0.3s;
        }

        .form-group input:focus {
            border-color: #f8b100;
        }

        .login-btn,
        .return-btn {
            width: 100%;
            padding: 15px;
            background-color: #f8b100;
            color: #fff;
            border: none;
            border-radius: 10px;
            font-size: 18px;
            cursor: pointer;
            transition: background-color 0.3s;
            margin-top: 10px;
        }

        .return-btn {
            width: 402px;
        }


        .login-btn:hover,
        .return-btn:hover {
            background-color: #f1daa1;
        }

        .register-link {
            margin-top: 20px;
            display: block;
            color: #00796b;
            text-decoration: none;
            font-weight: 500;
        }

        .error-message {
            color: red;
            margin-bottom: 15px;
        }
    </style>
</head>

<body>
    <div class="login-container">
        <h2>Đăng nhập</h2>

        <form action="{{ route('login') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" placeholder="Nhập email" required>
                @error('email')
                <div class="error-message">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="password">Mật khẩu:</label>
                <input type="password" id="password" name="password" placeholder="Nhập mật khẩu" required>
                <a href="#">Quên mật khẩu?</a>
                @error('password')
                <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            @if ($errors->has('login_error'))
            <div class="alert alert-danger">
                {{ $errors->first('login_error') }}
            </div>
            @endif

            <button type="submit" class="login-btn">Đăng nhập</button>

        </form>
        <form action="{{ route('home.html') }}" method="GET">

            <button type="submit" class="return-btn">Thoát</button>
        </form>

    </div>
    </div>
</body>

</html>