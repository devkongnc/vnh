<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
    </head>
    <body>
        <p>Full name: {{ $data['name'] }}</p>
        <p>Phone: {{ $data['phone'] }}</p>
        <p>Email: {{ $data['email'] }}</p>
        <p>Message: </p>
        <div>{{ $data['message'] }}</div>
    </body>
</html>
