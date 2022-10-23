@extends('parts.admin_app')
@section('content')
<div class="container" style="padding-top: 80px; padding-bottom:50px;">
      <div class="container text-center">
        <h1><b>Manage Users</b></h1><br>
        <button class="btn btn-success" type="button" style="font-size: 31px;width: 150px;margin: 20px;" onclick="location.href = '/enableAccountView';" >
           <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor" class="bi bi-person-check-fill d-md-flex justify-content-md-center" style="width: 100%;height: 80px;">
              <path fill-rule="evenodd" d="M1 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm9.854-2.854a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 0 1 .708-.708L12.5 7.793l2.646-2.647a.5.5 0 0 1 .708 0z"></path>
           </svg>
           <label class="form-label d-md-flex justify-content-md-center" style="font-size: 16px;">Enable users</label>
        </button>
        <button class="btn btn-danger" type="button" style="font-size: 31px;width: 150px;margin: 20px;" onclick="location.href = '/disableAccountView';">
           <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor" class="bi bi-person-x-fill d-md-flex justify-content-md-center" style="width: 100%;height: 80px;">
              <path fill-rule="evenodd" d="M1 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm6.146-2.854a.5.5 0 0 1 .708 0L14 6.293l1.146-1.147a.5.5 0 0 1 .708.708L14.707 7l1.147 1.146a.5.5 0 0 1-.708.708L14 7.707l-1.146 1.147a.5.5 0 0 1-.708-.708L13.293 7l-1.147-1.146a.5.5 0 0 1 0-.708z"></path>
           </svg>
           <label class="form-label d-md-flex justify-content-md-center" style="font-size: 16px;">Disable users</label>
        </button>
     </div>
</div>
@endsection