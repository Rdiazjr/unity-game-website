<script>
   function logout(){
   $.ajax({
      type:'get',
      url:'/signout',
      success:function(response)
      {
        window.location.replace("/");
      }     
   });
}
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
      <a class="navbar-brand" href="/dashboard">DON'T CATCH COVID</a><button id="button" onclick="test()" class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="" aria-controls="navbarNav" aria-expanded="true" aria-label="Toggle navigation">
         <span class="navbar-toggler-icon"></span>
       </button>
      <div class="collapse navbar-collapse" id="navcol-1">
         <ul class="navbar-nav me-auto">
            <li class="nav-item"><a class="nav-link" href="admin" style="font-size: 20px;">Admin Panel</a></li>
            <li class="nav-item"><a class="nav-link" href="https://analytics.google.com/analytics/web/?authuser=1#/p291795621/reports/dashboard?r=firebase-overview" style="font-size: 20px;">Report Generation</a></li>
         </ul>
         <span class="navbar-text actions"> <a class="btn btn-light action-button" role="button"  onclick="logout(); return false;">Log Out</a></span>
      </div>
   </div>
</nav>
