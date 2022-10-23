@extends('parts.logged_app')
@section('content')
<script>
    function editCover(){
        $.ajax({
            type:'post',
            url:'/editCover',
            data: $("#upload_cover").serialize(),
            success:function(response)
            {
                location.reload();
            }
        });
    }
    
    function editPhoto(){
        const storage = firebase.storage();
        const storageRef = storage.ref();
        var file = document.querySelector('#image').files[0];
        uid = "<?php echo Session::get('firebaseUserId'); ?>";
        var URL_profile="";
        var name =  uid +'_profilePhoto';
        var metadata = {contentType: file.type}
        var uploadTask = storageRef.child(name).put(file, metadata);
        uploadTask.then(snapshot => snapshot.ref.getDownloadURL()).then(function(downloadURL){
            photo_url = String(downloadURL);
            document.getElementById("photo_msg").style.color = "#505e6c";
            $("#photo_msg").html("wait...");
            $.ajax({
            type:'post',
            url:'/editPhoto',
            data:{photoURL: photo_url,
                "_token": $('#csrf-token')[0].content },
            success:function(response)
            {
                if(response == "photo uploaded successfully!"){
                        document.getElementById("photo_msg").style.color = "green";
                   }
                    else{
                        document.getElementById("photo_msg").style.color = "#ff0000";
                    }
                    
            }
            }).done(
                function(){
                    $.ajax({
                        type:'get',
                        url:'/downloadPhoto',
                        success:function(response){
                            $("#photo_msg").html(response);
                            $("#upload_img")[0].reset();
                            location.reload();  
                        }
                    })
                }
            )
        });
    }
    function editUsername(){
        document.getElementById("msg_username").style.color = "#505e6c";
        $("#msg_username").html("wait...");
       $.ajax({
          type:'POST',
          url:'/editUsername',
          data: $("#username_form").serialize(),
            success:function(response)
            {
                   if(response.msg == "Success"){
                        document.getElementById("msg_username").style.color = "green";
                   }
                    else{
                        document.getElementById("msg_username").style.color = "#ff0000";
                    }
                    $("#msg_username").html(response.msg);
                    $("#username_form")[0].reset();
                    location.reload();
            },
            error: function(error) {
                console.log("error");
            }
       });
        }

    function editEmail(){
        document.getElementById("msg_email").style.color = "#505e6c";
        $("#msg_username").html("wait...");
        $.ajax({
          type:'POST',
          url:'/edit_email',
          data: $("#email_form").serialize(),
            success:function(response)
            {
                   if(response.msg == "Success"){
                        document.getElementById("msg_email").style.color = "green";
                   }
                    else{
                        document.getElementById("msg_email").style.color = "#ff0000";
                    }
                    $("#msg_email").html(response.msg);
                    alert("email");
                    location.reload();
            },
            error: function(error) {
                console.log("error");
            }
       });}
    function editPassword(){
        if (confirm('Are you sure you want to change your password? this will log you out of this session')) {
            // Save it!
            document.getElementById("msg_password").style.color = "#505e6c";
                    $("#msg_password").html("wait...");
                $.ajax({
                    type:'POST',
                    url:'/editPassword',
                    data: $("#password_form").serialize(),
                        success:function(response){
                            if(response.msg == "Success"){
                                    document.getElementById("msg_password").style.color = "green";
                                    alert("Password changed!");
                            }
                            else{
                                    document.getElementById("msg_password").style.color = "#ff0000";
                            }
                                $("#msg_password").html(response.msg);
                                $("#password_form")[0].reset();   
                            window.location.href = "/signout";
                        },
                        error: function(error) {
                            console.log("error");
                        }
                });
                
                } else {
                    alert("Password is not changed");
                }
        }
</script>
<main style="padding-bottom: 50px; padding-top: 40px">
    <div id="coverHolder" name="coverHolder" class="text-center" style="background: url('') top / cover no-repeat;height: 200px;">
        <div style="background: rgba(11,11,11,0.24);padding-bottom: 10px;">
           <img class="rounded-circle img-fluid" src="<?php echo Session::get('profilePhoto') ?>" width="180px" style="border: 13px solid var(--bs-teal);margin-top: 100px;" alt="userprofile">
           <h1 style="color: rgb(205,205,205);font-size: 35px;"><?php echo Session::get('username'); ?></h1>
        </div>
     </div>
<div class="container-fluid">
       <!--Edit username-->
       <div style="text-align: center;padding-top:180px;">
        <p style="text-align: center; font-size:24px;">Username: <?php echo Session::get('username'); ?>
            <a class="btn btn-link" data-bs-toggle="collapse" aria-expanded="true" aria-controls="collapse-1" href="#collapse-1" role="button" style="background: url(&quot;https://unpkg.com/ionicons@5.5.2/dist/svg/create-outline.svg&quot;) center / auto no-repeat;height: 26px;"></p></a>
        <div class="collapse" id="collapse-1" style="padding: 10px;">
            <div class="container justify-content-center">
                <form action="" method="post" id="username_form">
                    @csrf
                <div id="msg_username"></div>
                    <label class="col-form-label">Enter new username:</label>
                <center>
                    <input class="form-control" style="width:300px;" name="username" type="text" required/>
                </center>
                    <button class="btn btn-primary" onclick="editUsername(); return false;" style="margin-top:10px ">Save</button>
            </form>
        </div>
        </div></div>
        <!--Edit cover photo-->
        <div style="text-align:center; ">
            <p style="text-align: center; font-size:24px;">Update Cover Photo
                <a class="btn btn-link" data-bs-toggle="collapse" aria-expanded="true" aria-controls="collapse-0" href="#collapse" role="button" style="background: url(&quot;https://unpkg.com/ionicons@5.5.2/dist/svg/create-outline.svg&quot;) center / auto no-repeat;height: 26px;"></p></a>
            <div class="collapse" id="collapse" style="padding: 10px;">
                <div class="container justify-content-center">
                    <form name="upload_cover" enctype="multipart/form-data" id="upload_cover">
                        @csrf
                        <center>
                            <div id="cover_msg" name="coverPhoto_msg"></div>
                            <div class="input-group mb-3" style="width: 300px">
                                <select class="form-select" name="select_cover" aria-label="Default select example">
                                    <option selected>Select background photo</option>
                                    <option value="+639000000000">cover 1</option>
                                    <option value="+639000000001">cover 2</option>
                                    <option value="+639000000002">cover 3</option>
                                    <option value="+639000000003">cover 4</option>
                                  </select>
                                    <button type="button" class="btn btn-primary" id="btn_saveCover" onclick="editCover();">Okay</button>
                                </div>
                        </center>
                    </form>
            </div>
            </div>
        </div>
    <!--Edit profile photo-->
        <div style="text-align:center;">
            <p style="text-align: center; font-size:24px;">Update User Photo
                <a class="btn btn-link" data-bs-toggle="collapse" aria-expanded="true" aria-controls="collapse-0" href="#collapse-0" role="button" style="background: url(&quot;https://unpkg.com/ionicons@5.5.2/dist/svg/create-outline.svg&quot;) center / auto no-repeat;height: 26px;"></p></a>
            <div class="collapse" id="collapse-0" style="padding: 10px;">
                <div class="container justify-content-center">
                    <form name="upload_img" enctype="multipart/form-data" id="upload_img">
                        @csrf
                        <center>
                            <div id="photo_msg" name="photo_msg"></div>
                            <div class="input-group mb-3" style="width: 300px">
                                    <input type="file" class="form-control" name="image" id="image" required>
                                    <button type="button" class="btn btn-primary" id="upload_btn" onclick="editPhoto()">Upload</button>
                                </div>
                            </div>
                        </center>
                    </form>
            </div>
            </div>
        </div>

 
    <!--edit email-->
        <div style="text-align: center;">
        <p style="text-align: center; font-size:24px;">Email: <?php echo Session::get('email'); ?>
            <a class="btn btn-link" data-bs-toggle="collapse" aria-expanded="true" aria-controls="collapse-1" href="#collapse-2" role="button" style="background: url(&quot;https://unpkg.com/ionicons@5.5.2/dist/svg/create-outline.svg&quot;) center / auto no-repeat;height: 26px;"></p></a>
        <div class="collapse" id="collapse-2" style="padding: 10px;">
            <div class="container justify-content-center">
                <form action="/edit_email" method="post" id="email_form">
                    @csrf
                <div id="msg_email"></div>
                    <label class="col-form-label">Enter new email:</label>
                <center>
                    <input class="form-control" style="width:300px;" name="email" type="email" required/>
                </center>
                    <button class="btn btn-primary" onclick="editEmail(); return false;" style="margin-top:10px ">Save</button>
            </form>
        </div>
        </div></div>
    <!--edit password-->
        <div style="text-align: center;">
        <p style="text-align: center; font-size:24px;">Password<a class="btn btn-link" data-bs-toggle="collapse" aria-expanded="true" aria-controls="collapse-1" href="#collapse-3" role="button" style="background: url(&quot;https://unpkg.com/ionicons@5.5.2/dist/svg/create-outline.svg&quot;) center / auto no-repeat;height: 26px;"></p></a>
        <div class="collapse" id="collapse-3" style="padding: 10px;">
            <div class="container justify-content-center">
                <form id="password_form">
                    @csrf
                <div id="msg_password"></div>
                    <center>
                        <label class="col-form-label">Enter new password:</label>
                        <input class="form-control"  style="width:300px;" name="password" type="password" required/>
                    </center>
                    <button class="btn btn-primary" onclick="editPassword();" style="margin-top:10px ">Save</button>
                    </form>
            </div>
        </div>
</div>
</div>
</div>
</main>
@endsection
