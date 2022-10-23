@extends('parts.table_app')
@section('content')
<script>
    $( document ).ready(function() {
        $.ajax({
          url:'/table',
            success:
                function(response)
                {
                    var obj = JSON.parse(response);
                    var res = Object.keys(obj).map((data)=>{
                    var innerdata = obj[data];
                    var score = innerdata.Highscore;
                    var username = innerdata.username;
                    return [score,username]
                    });

                    var result = res.sort((a,b)=> b[0]-a[0])
                    var final = Object.keys(result).map((rank)=>{
                    var Rank =Number(rank)+1;
                    var score = result[rank][0];
                    var name = result[rank][1]
                    document.querySelector('table > tbody').innerHTML += `
                    <tr>
                        <td style="text-align: center;">${Rank}</td>
                        <td style="text-align: center;">${name}</td>
                        <td style="text-align: center;">${score}</td>
                    </tr>`;
                    });
                },
            error: function(error) {console.log("error");}
       });
});

function myFunction(item) {
    text =  item ; 
}
</script>
<div class="container" style="padding-top: 80px; padding-bottom:200px;">
    <center>
    <h1><b>ONLINE LEADERBOARD</b></h1></center><br>
    <div class="table-responsive">
        <table class="table table-borderless table-dark table-striped" id="records_table">
                <thead>
                    <th style="text-align: center;">Rank</th>
                    <th style="text-align: center;">Username</th>
                    <th style="text-align: center;">Highscore</th>
                </thead>
                <tbody></tbody>
        </table>
    </div>
</div>
@endsection