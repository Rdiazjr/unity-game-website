@extends('parts.admin_app')
@section('content')
<script>
    $( document ).ready(function() {
       $.ajax({
          url:'/table_disabled',
            success:
                function(response)
                {
                  if(response == "no data"){

                }
                else{
                    var obj = JSON.parse(response);
                    var res = Object.keys(obj).map((data)=>{
                    var innerdata = obj[data];
                    var tokenID = data;
                    var username = innerdata.username;
                    return [username,data]
                    });
                 

                    var result = res.sort((a,b)=> b[0]-a[0])
                    var final = Object.keys(result).map((rank)=>{
                    var name = result[rank][0]
                    var id = result[rank][1]
                    document.querySelector('#table_1 > tbody').innerHTML += `
                    <tr>
                        <td style="text-align: center;">${name}</td>
                        <td style="text-align: center;">${id}</td>
                        <td style="text-align: center;"><a class="btn btn-success" type="button" data-bs-toggle="modal" data-bs-target="#confirmModal" onclick="enableAccount('${id}')">Enable</button></td> 
                    </tr>`;
                    }); 
                  }
                },
            error: function(error) {console.log("error");}
       });
});

function enableAccount(uid) {
   var userid  = uid;
   $.ajax({
      type:'post',
      url:'/enableAccount',
      data: {user_id:userid,
        "_token": $('#csrf-token')[0].content},
      success:function(response)
      {
        location.reload();
      }     
   });
}

</script>
<div class="container" style="padding-top: 80px; padding-bottom:200px;">
    <center>
    <h1><b>Manage Users</b></h1></center><br>
    <div class="table-responsive">
        <table id="table_1" class="table table-borderless table-dark table-striped" id="records_table">
          <thead>
              <th style="text-align: center; width:80%">Username</th>
              <th style="text-align: center; width:80%">User ID</th>
              <th style="text-align: center; width:20%" >Enable Account</th>
          </thead>
          <tbody></tbody>
  </table>
    </div>
</div>
 <!-- Modal -->
  <div class="modal fade" id="confirmModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content" style="background:#424242;color:white;">
          <div>
            <button style="float: right; margin:8px;" type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick=" $('#ajaxform_reg')[0].reset();"></button>
          </div>
          <div class="modal-body">
            <form  action="/signin" style="0px 40px" id="ajaxform_reg" method="post">
              @csrf<center>
              <h2><b>Confirm</b></h2>
              <div id="disable_msg"></div>
              <p>Are you sure you want to enable this account?</p>
              </center>
              <div class="mb-3"><button class="btn btn-primary d-block w-100" style="background: #ff5050;border:0px;border-radius:30px;"  type="button" onclick="enableAccount();  return false;" style="border-radius: 30px">Proceed</button></div>
              <div class="mb-3"><button class="btn btn-secondary d-block w-100" style="border:0px;border-radius:30px;" type="button" onclick=" return false;" style="border-radius: 30px">Cancel</button></div>
          </form>
          </div>
        </div>
      </div>
    </div>
@endsection