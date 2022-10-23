@extends('parts.app')
@section('content')

<script>
   function LoginSubmit(){
         document.getElementById("msg").style.color = "white";
       $("#msg").html("wait...");
      $.ajax({
         type:'POST',
         url:'/signin',
         data: $("#ajaxform").serialize(),
           success:function(response){
               if(response) {
                  if(response.msg == "Success"){
                       document.getElementById("msg").style.color = "green";
                       $("#msg").html(response.msg);
                      
                  }
                  else if(response.msg == "admin"){
                       window.location.replace("/admin");
                  }
                   else{
                       document.getElementById("msg").style.color = "#ff0000";
                       $("#msg").html(response.msg);
                   }
                  
               }
           },
           error: function(error) {
               console.log("error");
           }
      }).done(
         function(){
            $.ajax({
               type:'get',
               url:'/downloadPhoto',
               success:function(response){
                  window.location.replace("/dashboard");
               }
            })
         }
      )
   }
   function RegisterSubmit(){
                        document.getElementById("msg_reg").style.color = "white";
                        $("#msg_reg").html("wait...");
                       $.ajax({
                          type:'POST',
                          url:'/signup',
                          data: $("#ajaxform_reg").serialize(),
                            success:function(response){
                                if(response) {
                                   if(response.msg == "Account Created!"){
                                        document.getElementById("msg_reg").style.color = "green";
                                        document.getElementById("ajaxform_reg").reset();
                                   }
                                    else{
                                        document.getElementById("msg_reg").style.color = "#ff0000";
                                       
                                    }
                                    $("#msg_reg").html(response.msg);
                                    setTimeout(function () {
                                       $('#registerModal').modal('hide'); 
                                       $('.modal-backdrop').remove();
                                       $('#LoginModal').modal('show');
                                    }, 500);
                                   
                                }
                            },
                            error: function(error) {
                                console.log("error");
                            }
                       });
                    }
    function ResetPassword(){
     
      document.getElementById("msg_reset").style.color = "white";
                        $("#msg_reset").html("wait...");
                       $.ajax({
                          type:'POST',
                          url:'/reset',
                          data: $("#resetForm").serialize(),
                            success:function(response){
                              document.getElementById("resetForm").reset();
                              document.getElementById("msg_reset").style.color = "green";
                                    $("#msg_reset").html(response);
                            },
                            error: function(error) {
                              document.getElementById("msg_reset").style.color = "#ff0000";
                                console.log("error");
                            }
                       });
                    }
</script>
    <div class="carousel slide"  data-bs-ride="carousel" data-bs-pause="false" id="carousel-1">
       <div class="carousel-inner">
          <div class="carousel-item active"><img class="w-100 d-block" src="/img/Untitled%20design.gif" alt="Slide Image" style="height: 100%;"></div>
          <div class="carousel-item"><img class="w-100 d-block" src="/img/Untitled%20design%20(2).gif" alt="Slide Image" style="height: 100%;"></div>
          <div class="carousel-item"><img class="w-100 d-block" src="/img/Untitled%20design%20(1).gif" alt="Slide Image" style="height: 100%;"></div>
          <div class="carousel-item"><img class="w-100 d-block" src="/img/Untitled%20design%20(3).gif" alt="Slide Image" style="height: 100%;"></div>
       </div>
       <div><a class="carousel-control-prev" href="#carousel-1" role="button" data-bs-slide="prev">
           <span class="carousel-control-prev-icon"></span><span class="visually-hidden">Previous</span></a>
           <a class="carousel-control-next" href="#carousel-1" role="button" data-bs-slide="next"><span class="carousel-control-next-icon"></span>
            <span class="visually-hidden">Next</span></a></div>
       <ol class="carousel-indicators">
          <li data-bs-target="#carousel-1" data-bs-slide-to="0" class="active"></li>
          <li data-bs-target="#carousel-1" data-bs-slide-to="1"></li>
          <li data-bs-target="#carousel-1" data-bs-slide-to="2"></li>
          <li data-bs-target="#carousel-1" data-bs-slide-to="3"></li>
       </ol>
    </div>
    <div class="container-fluid" style="margin: 20px 0px 120px 0px; padding:0px 80px;">
      <div class="d-flex justify-content-center" style="padding:0px 50px;">
         <table>
            <tr height="80px">
               <td><a href="https://cdn-133.anonfiles.com/L998d753x7/0e506df2-1641312367/dontcatchcovid.apk" class="btn btn-primary text-responsive" type="button" style="width: 80vw;border:0px;height: auto;margin-right: 10px;background: var(--bs-purple);font-size: 24px;padding: 5px;">DOWNLOAD APK</a></td>
            </tr>
            <tr>
               <td>
                  <a href="/game" class="btn btn-primary text-responsive" type="button" style="width: 80vw;border:0px;height: auto;background: var(--bs-purple);font-size: 24px;padding: 5px;">PLAY DEMO</a></div>
               </td>
            </tr>
         </table>
         
         
      </div>

<!-- Modal -->
<div class="modal fade" id="LoginModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
   <div class="modal-dialog" >
     <div class="modal-content" style="background:#424242">
      <div> 
         <button style="float: right; margin:8px;" type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick=" $('#ajaxform')[0].reset();">
         </button>
      </div>
        
       <div class="modal-body">
         <form method="POST" id="ajaxform" action="" style="padding: 0px 20px;">
            @csrf
            <center>
            <h2 style="color: white;font-weight:bold;">Sign In</h2>
            </center>
            <p id = 'msg'></p>
           <div class="mb-3"><input class="form-control" type="email" id="email_login" name="email" placeholder="Email" required /></div>
           <div class="mb-3"><input class="form-control" type="password" id="password_login" name="password" placeholder="Password" required /></div>
           <div class="mb-3"><button name="login" style="background: #ff5050;border:0px;border-radius:30px;" class="btn btn-primary d-block w-100" type="button" style="border-radius: 30px" onclick="LoginSubmit(); return false;">Log In</button></div>
           <center><a style="color:white" class="forgot" href="#" onclick="document.getElementById('ajaxform').reset();$('#LoginModal').modal('hide'); $('.modal-backdrop').remove();$('#ResetPassword').modal('show');">Forgot Password</a></center>
        </form>
      </div>
     </div>
   </div>
 </div>

 <!-- Modal -->
<div class="modal fade" id="registerModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
   <div class="modal-dialog">
      <div class="modal-content" style="background:#424242;color:white;">
       <div>
         <button style="float: right; margin:8px;" type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick=" $('#ajaxform_reg')[0].reset();"></button>
       </div>
       <div class="modal-body">
         <form  action="/signin" style="0px 40px" id="ajaxform_reg" method="post">
            @csrf
           <h2 class="visually-hidden">Register Form</h2>
           <h2><center><b>Register</b><center></h2>
            <p id ='msg_reg'></p>
           <div class="mb-3"><input class="form-control" type="username" name="username" placeholder="Username"></div>
           <div class="mb-3"><input class="form-control" type="email" name="email" placeholder="Email"></div>
           <div class="mb-3"><input class="form-control" type="password" name="password" placeholder="Password"></div>
           <div class="mb-3"><input class="form-control" type="password" name="password_2" placeholder="Confirm Password"></div>
           <div class="mb-3"><button class="btn btn-primary d-block w-100" style="background: #ff5050;border:0px;border-radius:30px;"  type="button" onclick="RegisterSubmit();  return false;" style="border-radius: 30px">Proceed</button></div>
        </form>
       </div>
     </div>
   </div>
 </div>
  <!-- Modal -->
<div class="modal fade" id="ResetPassword" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" onclick=" document.getElementById('ajaxform').reset();$('#msg_reset').html('');" aria-hidden="true">
   <div class="modal-dialog">
      <div class="modal-content" style="background:#424242;color:white;">
       <div>
         <button style="float: right; margin:8px;" type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
       </div>
       <div class="modal-body">
         <form action="/reset" style="0px 40px" id="resetForm" method="post">
            @csrf
           <h2 class="visually-hidden">Login Form</h2>
           <h2><center><b>Reset Password</b><center></h2>
            <p id ='msg_reset'></p>
           <div class="mb-3"><input class="form-control" type="email" name="email" placeholder="Email"></div>
           <div class="mb-3"><button class="btn btn-primary d-block w-100" style="background: #ff5050;border:0px;border-radius:30px;"  type="button" onclick="ResetPassword();  return false;" style="border-radius: 30px">Proceed</button></div>
        </form>
       </div>
     </div>
   </div>
 </div>
 <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js"></script>    
@endsection