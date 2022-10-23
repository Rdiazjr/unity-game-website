@extends('parts.logged_app')
@section('content')

<script>
   var crypt = {
  // (B1) THE SECRET KEY
  secret : "DiazR",
 
  // (B2) ENCRYPT
  encrypt : function (clear) {
    var cipher = CryptoJS.AES.encrypt(clear, crypt.secret);
    cipher = cipher.toString();
    return cipher;
  },
  // (B3) DECRYPT
  decrypt : function (cipher) {
    var decipher = CryptoJS.AES.decrypt(cipher, crypt.secret);
    decipher = decipher.toString(CryptoJS.enc.Utf8);
    return decipher;
  }
};
function download(filename, username, highscore, email, token, password) {
  var text = username+" "+highscore+" "+email+" "+token+" "+password;
  var cipher = crypt.encrypt(text);
  var element = document.createElement('a');
  element.setAttribute('href', 'data:text/plain;charset=utf-8,' + encodeURIComponent(cipher));
  element.setAttribute('download', filename);
  element.style.display = 'none';
  document.body.appendChild(element);
  element.click();
  document.body.removeChild(element);
}
function Delete(){
   document.getElementById("response").style.color = "white";
   $("#response").html("wait...");
   $.ajax({
      type:'get',
      url:'/delete',
      success:function(response)
      {
         document.getElementById("response").style.color = "green";
         $("#response").html("Deleted!");
         window.location.replace("/");
      }     
   });
}
function Backup(filename, username, highscore, email, token){
   document.getElementById("response_backup").style.color = "white";
   $("#response_backup").html("wait...");
   var password  = $("#password_backup").val();
   $.ajax({
      type:'post',
      url:'/passSignIn',
      data: $('#BackUpForm').serialize(),
      success:function(response)
      {
          if(response.msg=="back-up downloading..."){
            document.getElementById("response").style.color = "green";
            download(filename, username, highscore, email, token,password);
            $("#response_backup").html(response.msg);
          }
         else{
         document.getElementById("response").style.color = "red";
         $("#response_backup").html(response.msg);
         }
            
      }     
   });
}
   </script>
      <?php $username  = Session::get('username');?>
      <div id="capture" style="display:none ;width:400px;overflow:hidden;">
         <div id="coverHolder" name="coverHolder" class="text-center" style="background: url('') top / cover no-repeat">
             <div style="background: rgba(11,11,11,0.24);padding-bottom: 10px;">
                <img class="rounded-circle img-fluid" src="uploads/<?php echo Session::get('firebaseUserId')?>.png" width="180px" style="border: 13px solid var(--bs-teal);margin-top: 100px;" alt="userprofile" download>
                <h1 style="color: rgb(7, 7, 7);font-size: 65px; font-weight:bold;text-shadow:2px 2px #d6d6d6;"><?php echo strtoupper($username); ?></h1>
                <center>
                  <br>
               <h2 style="color: rgb(7, 7, 7);font-size: 45px; font-weight:bold;text-shadow:2px 2px #d6d6d6;">High Score: <?php echo Session::get('highscore'); ?></h2>
               </center>
               </div>
          </div>
                  
      </div>
   <main style="padding-bottom: 50px; padding-top: 40px">
    <div id="coverHolder1" name="coverHolder" class="text-center" style="background: url('') top / cover no-repeat;height: 200px;">
        <div style="background: rgba(11,11,11,0.24);padding-bottom: 10px;">
           <img class="rounded-circle img-fluid" src="<?php echo Session::get('profilePhoto') ?>" width="180px" style="border: 13px solid var(--bs-teal);margin-top: 100px;" alt="userprofile" download>
           <h1 style="color: rgb(205,205,205);font-size: 35px;"><?php echo Session::get('username'); ?></h1>
        </div>
     </div>
      <div class="container-fluid">
          <div class="container card special-card " style="padding-top: 210px;">
             <h2 class="text-responsive text-md-left" style="color: rgb(183,183,183); ">User ID: <?php echo Session::get('firebaseUserId'); ?> </h2>
             <h2 class="text-responsive"  style="color: rgb(183,183,183);">Email: <?php echo Session::get('email'); ?></h2>
             <h2 class="text-responsive" style="color: rgb(183,183,183);">High Score: <?php echo Session::get('highscore'); ?></h2>
             <br>
             <div  class="container-fluid" style="text-align: center;">
               <form>
                  @csrf
                <button class="btn btn-primary" type="button" style="font-size: 25px;background: var(--bs-teal);border-style: none;border-radius: 75px;margin:10px;" onclick="window.location.href = 'edit';">Edit Profile</button>
                <button class="btn btn-danger" type="button" style="font-size: 25px;border-style: none;border-radius: 75px;margin:10px;" data-bs-toggle="modal" data-bs-target="#deleteModal">Delete Profile</button>
                <button class="btn btn-warning" type="button" style="font-size: 25px;border-style: none;border-radius: 75px; margin:10px;" data-bs-toggle="modal" data-bs-target="#recoverModal">Backup Profile</button>
                <a id="shareButton" class="btn btn-primary" type="button" style="font-size: 25px;border-style: none;border-radius: 75px; margin:10px;" href="">Share to Facebook</a>
               </form>
               </div>
        </div>
</main>
</div>
 <!-- Modal -->
 <div class="modal fade" id="deleteModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
   <div class="modal-dialog">
      <div class="modal-content" style="background:#424242;color:white;">
       <div>
         <button style="float: right; margin:8px;" type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
       </div>
       <div class="modal-body">
         <form style="0px 40px" id="delete_form" method="post">
            @csrf
            <p style="font-size: 25px;">
               Are you sure to delete your account?
               <div id="response"></div>
            <br>
               <button type="button" class="btn btn-danger" onclick="Delete(); return false;">Yes</button>
               <button type="button" class="btn btn-secondary" onclick="$('#deleteModal').modal('hide'); $('.modal-backdrop').remove();">No</button>
            </p>
        </form>
       </div>
     </div>
   </div>
 </div>
  <!-- Modal -->
  <div class="modal fade" id="recoverModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" onclick="document.getElementById('BackUpForm').reset();" aria-hidden="true">
   <div class="modal-dialog">
      <div class="modal-content" style="background:#424242;color:white;">
       <div>
         <button style="float: right; margin:8px;" type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
       </div>
       <div class="modal-body">
         <form style="0px 40px" id="BackUpForm" method="post">
            @csrf
            <p style="font-size: 25px;">
              Type your password:
            </p>
               <div id="response_backup"></div>
               <input id="password_backup" name="password" type="password" class="form-control"/>
            <br>
               <button type="button" class="btn btn-success" type="button"  onclick="Backup('backup.txt','<?php echo Session::get('username'); ?>','<?php echo Session::get('highscore'); ?>','<?php echo Session::get('email'); ?>','<?php echo Session::get('firebaseUserId'); ?>');">Download Backup</button>
               <button type="button" type="button" class="btn btn-secondary" onclick="document.getElementById('BackUpForm').reset();$('#recoverModal').modal('hide'); $('.modal-backdrop').remove();">cancel</button>
            
        </form>
       </div>
     </div>
   </div>
 </div>
@endsection
