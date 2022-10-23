<script>
   function test(){
      console.log($("#navcol-1").hasClass("show"));
      if($("#navcol-1").hasClass("show") === true){
         $("#navcol-1").removeClass("show");
      }
      else{
         $("#navcol-1").addClass("show");
      }
  
}
</script>
<nav class="navbar navbar-dark navbar-expand-md navigation-clean-button fixed-top shadow-sm">
    <div class="container">
       <a class="navbar-brand" href="/">DON'T CATCH COVID</a>
       <button id="button" onclick="test()" class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="" aria-controls="navbarNav" aria-expanded="true" aria-label="Toggle navigation">
         <span class="navbar-toggler-icon"></span>
       </button>
       <div class="collapse navbar-collapse" id="navcol-1">
          <ul class="navbar-nav me-auto">
          </ul>
          <span class="navbar-text actions"> <a class="btn btn-link login" type="button" data-bs-toggle="modal" data-bs-target="#LoginModal" onclick="$('#msg').html('');">Log In</a>
         <a class="btn btn-light action-button" type="button" data-bs-toggle="modal" data-bs-target="#registerModal" role="button" onclick="$('#msg_reg').html('');">Sign Up</a>
      </span>
       </div>
    </div>
 </nav>
 