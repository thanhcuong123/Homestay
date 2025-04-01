<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng ký</title>
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

        .register-container {
            background-color: #ffffff;
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.3);
            width: 100%;
            max-width: 400px;
            text-align: center;
        }

        .register-container h2 {
            margin-bottom: 30px;
            color: #3f7a5c;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            margin-bottom: 15px;
            text-align: left;
        }

        .form-group label {
            margin-bottom: 5px;
            color: #3f7a5c;
            font-weight: 500;
        }

        .form-group input {
            width: 100%;
            padding: 12px;
            border: 1px solid #eeaeca;
            border-radius: 10px;
            box-sizing: border-box;
            font-size: 16px;
            outline: none;
            transition: border-color 0.3s;
        }

        .form-group input:focus {
            border-color: #3f7a5c;
        }

        .register-btn,
        .return-btn {
            width: 100%;
            padding: 15px;
            background-color: #69ae8b;
            color: #fff;
            border: none;
            border-radius: 10px;
            font-size: 18px;
            cursor: pointer;
            transition: background-color 0.3s;
            margin-top: 10px;
        }

        .register-btn:hover,
        .return-btn:hover {
            background-color: #3f7a5c;
        }

        .error-message {
            color: red;
            margin-bottom: 10px;
        }

        .login-link {
            display: block;
            margin-top: 15px;
            color: #00796b;
            text-decoration: none;
            font-weight: 500;
        }
    </style>
</head>

<body>
    <div class="register-container">
        <h2>Đăng ký tài khoản</h2>

        <form action="{{ route('register') }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="name">Họ và Tên:</label>
                <input type="text" id="name" name="name" placeholder="Nhập họ và tên" required value="{{ old('name') }}">
                @error('name')
                <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" placeholder="Nhập email" required value="{{ old('email') }}">
                @error('email')
                <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="password">Mật khẩu:</label>
                <input type="password" id="password" name="password" placeholder="Nhập mật khẩu" required>
                @error('password')
                <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="password_confirmation">Xác nhận mật khẩu:</label>
                <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Nhập lại mật khẩu" required>
            </div>

            <button type="submit" class="register-btn">Đăng ký</button>
        </form>

        <a href="{{ route('login') }}" class="login-link">Đã có tài khoản? Đăng nhập ngay</a>
    </div>
</body>

</html>
