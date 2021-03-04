<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
</head>

<body>
    <h1>Forgot Password</h1>

    <p>Name : {{$user_name}}</p>
    <p>Email : {{$user_email}}</p>
    <p>Phone : {{$user_phone}}</p>
    <p>Role : {{$user_role}}</p>

    <a href="{{route('change_password', [$user_email, $token['token']])}}">Click here to change password</a>
</body>

</html>