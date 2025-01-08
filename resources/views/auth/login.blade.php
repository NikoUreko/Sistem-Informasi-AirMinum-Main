<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}" />
    <title>Login</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        
        body, html {
            height: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: rgb(130, 255, 132); 
            font-family: Arial, sans-serif; 
        }
    </style>
</head>

<body>
    <section class="login-section">
        <h1>Login</h1>
        @if ($errors->any())
            <div class="error-messages">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if (session('success'))
            <p class="success-message">{{ session('success') }}</p>
        @endif

        <form action="{{ url('/login') }}" method="POST">
            @csrf
            <label class= "loginlabel" for="id">ID:</label>
            <input class= "logininput" type="text" name="id" id="id" value="{{ old('id') }}" required>

            <label class= "loginlabel" for="password">Password:</label>
            <input class= "logininput" type="password" name="password" id="password" required>

            <button class= "loginbutton" type="submit">Login</button>
        </form>
    </section>
</body>
</html>
