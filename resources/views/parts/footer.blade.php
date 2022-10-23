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
   function Recover(){
   var file = document.getElementById('inputfile').files[0];
	var reader = new FileReader();
	var username = "";
	var highscore = 0;
	var email = "";
   var token ="";
   var password ="";
	reader.onload = function(progressEvent)
		{
         var decrypted = crypt.decrypt(this.result);
			var lines = decrypted.split(' ');
			for(var line = 0; line < lines.length; line++)
			{
				switch(line){
               case 0:
					   username = lines[line];
               break;
				   case 1:
					   highscore = lines[line];
               break;
               case 2:
                  email = lines[line];
               break;
               case 3:
                  token=lines[line];
               break;
               case 4:
                  password = lines[line];
                  break;
            }
			}
         recoverAccount(username,highscore,email,token,password);
		};

	reader.readAsText(file);
   
}
function recoverAccount(username,highscore,email,token,password){
   $("#res").html("wait...");
   $.ajax({
      type:'get',
      data: {
         username:username,
         highscore:highscore,
         email:email,
         token:token,
         password:password},
      url:'/recover',
      success:function(response)
      {
         $("#res").html(response.msg);
      }     
   });
}
   </script>
<footer class="footer-basic">
    <div class="social"><a href="#"><i class="icon ion-social-instagram"></i></a><a href="#"><i class="icon ion-social-snapchat"></i></a><a href="#"><i class="icon ion-social-twitter"></i></a><a href="#"><i class="icon ion-social-facebook"></i></a></div>
    <ul class="list-inline">
       <li class="list-inline-item"><a href="/">Home</a></li>
       <li class="list-inline-item"><a data-bs-toggle="modal" data-bs-target="#accountRecovery">Account Recovery</a></li>
       <li class="list-inline-item"><a href="/about">About</a></li>
    </ul>
    <p class="copyright">III-BCSAD © 2021</p>
     <!-- Modal -->
 <div class="modal fade" id="accountRecovery" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
   <div class="modal-dialog">
      <div class="modal-content" style="background:#424242;color:white;">
       <div class="modal-header">
          <h5><b>Recover Account</b></h5>
         <button style="float: right; margin:8px;" type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
       </div>
       <div class="modal-body">
         <form style="0px 40px" id="" method="post">
            @csrf
            <div id="res"></div>
            <label>Upload your backup file</label>
            <input type="file" class="form-control" name="inputfile" id="inputfile">
            <br>
            <pre id="output"></pre>
               <button type="button" class="btn btn-success" onclick="Recover(); return false;">Recover</button>
            </p>
        </form>
       </div>
     </div>
   </div>
 </div>
 </footer>