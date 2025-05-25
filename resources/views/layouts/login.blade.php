<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-cover bg-center flex items-center justify-center" style="background-image: url('/images/imageBgLogin.jpg')">

    <div class=" w-full max-w-md">
        @yield('content')
    </div>

</body>
</html>
