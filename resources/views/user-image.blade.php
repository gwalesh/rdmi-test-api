<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Web Form Check</title>
</head>
    <body>
        @if(session()->has('success'))
            <h1>{{ session()->get('success') }}</h1>
        @endif
        @if(session()->has('error'))
            <h1>{{ session()->get('error') }}</h1>
        @endif
            <form method="POST" action="{{ route('form.submit' , '4') }}" enctype="multipart/form-data">
                @csrf 

                <input type="text" name="name" placeholder="Enter your Full Name">

                <input type="file" name="profile">

                <button type="submit" role="button">Submit Form</button>
            </form>
    </body>
</html>