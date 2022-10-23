<?php  if(Session::has('firebaseUserId')&&Session::has('email')&&Session::get('email') != 'admin@gmail.com'){ ?>
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
        <script src="https://html2canvas.hertzen.com/dist/html2canvas.js"></script>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
        <link href="{{ asset('css/Navigation-with-Button.css') }}" rel="stylesheet">
        <link href="{{ asset('css/Footer-Basic.css') }}" rel="stylesheet">
        <link href="{{ asset('css/Login-Form-Clean.css') }}" rel="stylesheet">
        <link href="{{ asset('css/styles.css') }}" rel="stylesheet">
        <link href="{{ asset('css/Video-Responsive.css') }}" rel="stylesheet">
        
</head>
<script>
       var firebaseConfig = {
        apiKey: "AIzaSyAFQMfAKP72UPCbZ8qMwul8luKYbyzqoaY",
        authDomain: "covid-runner-f54c7.firebaseapp.com",
        databaseURL: "https://covid-runner-f54c7-default-rtdb.firebaseio.com",
        projectId: "covid-runner-f54c7",
        storageBucket: "covid-runner-f54c7.appspot.com",
        messagingSenderId: "549760676524",
        appId: "1:549760676524:web:931f3771ee96087a54e509",
        measurementId: "G-4TPXQ6G961"
    };
    // Initialize Firebase
    firebase.initializeApp(firebaseConfig);
    firebase.analytics();

$(document).ready(function(){
    $('#shareButton').html('wait...');
    var cover_number = <?php echo Session::get('coverphoto'); ?>;
        if(cover_number == '639000000000'){
            document.getElementById('coverHolder').style.backgroundImage = "url('img/mario_cover.jpg')";
            if( $('#coverHolder1').length ){
                document.getElementById('coverHolder1').style.backgroundImage = "url('img/mario_cover.jpg')";
            }
        }
        else if(cover_number == '639000000001'){
            document.getElementById('coverHolder').style.backgroundImage = "url('img/starry_night.jpg')";
            if( $('#coverHolder1').length ){
                document.getElementById('coverHolder1').style.backgroundImage = "url('img/starry_night.jpg')";
            }
            
        }
        else if(cover_number == '639000000002'){
            document.getElementById('coverHolder').style.backgroundImage = "url('img/smashbros.jpg')";
            if( $('#coverHolder1').length ){
                document.getElementById('coverHolder1').style.backgroundImage = "url('img/smashbros.jpg')";
            }
        }
        else if(cover_number == '639000000003'){
            document.getElementById('coverHolder').style.backgroundImage = "url('img/summer_mario.jpg')";
            if( $('#coverHolder1').length ){
                document.getElementById('coverHolder1').style.backgroundImage = "url('img/summer_mario.jpg')";
            }
            
        }

        const storage = firebase.storage();
        const storageRef = storage.ref();
        uid = "<?php echo Session::get('firebaseUserId'); ?>";
        var name =  uid +'_sharePhoto';
        if( $('#capture').length ){
            html2canvas(document.getElementById("capture"), 
            {useCORS: true, 
            scale: 1,
            onclone: 
                function (clonedDoc) {
                    clonedDoc.getElementById('capture').style.display = 'block';
                    }
                }).then(canvas => {
             canvas.toBlob(function(blob){
                var uploadTask = storageRef.child(name).put(blob);
               var waitTask = uploadTask.then(snapshot => snapshot.ref.getDownloadURL()).then(function(downloadURL){
                   url = encodeURIComponent(downloadURL);
                $('#shareButton').attr('href','https://www.facebook.com/sharer/sharer.php?kid_directed_site=0&u='+url+'&display=popup&ref=plugin&src=share_button')
                $('#shareButton').html('Share to facebook');
                });
            });
        });
    }
});

    </script>
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
else if(Session::get('email') == 'admin@gmail.com'){
    header("Location: /admin");
}
else{
        header("Location: /");
}
die();
?>