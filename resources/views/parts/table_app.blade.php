<?php if(Session::has('firebaseUserId')&&Session::has('email')){ ?>
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta name="csrf-token" id="csrf-token" content="{{ csrf_token() }}">
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Laravel</title>
        <script src="https://www.gstatic.com/firebasejs/8.2.8/firebase-app.js"></script>
        <script src="https://www.gstatic.com/firebasejs/8.2.8/firebase-storage.js"></script>
        <script src="https://www.gstatic.com/firebasejs/8.2.8/firebase-analytics.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/4.0.0/crypto-js.min.js"></script>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
        <link href="{{ asset('css/Navigation-with-Button.css') }}" rel="stylesheet">
        <link href="{{ asset('css/Footer-Basic.css') }}" rel="stylesheet">
        <link href="{{ asset('css/Login-Form-Clean.css') }}" rel="stylesheet">
        <link href="{{ asset('css/styles.css') }}" rel="stylesheet">
        <link href="{{ asset('css/Video-Responsive.css') }}" rel="stylesheet">
</head>
<body style="background-image: url('img/background.png')">
    @include('parts.logged_navbar')
    <div id="content">
        @yield('content')
    </div>
    @include('parts.logged_footer')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php }
else{
    header("Location: /");
    die();
}
?>