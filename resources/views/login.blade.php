<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login</title>
</head>

<body class="antialiased">
    <div class="flex flex-col mx-auto bg-green-100">
        <form action="{{ route('login.auth') }}" method="post">
            @csrf
            @method('post')
            <div class="flex flex-col">
                <span>Login</span>
                <input type="text" name="email">
            </div>
            <div class="flex flex-col">
                <span>Password</span>
                <input type="text" name="password">
            </div>
            <div class="flex flex-row">
                <input type="submit" value="login">
            </div>
        </form>
    </div>
</body>

</html>
