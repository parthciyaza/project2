<!DOCTYPE html>
<html lang="{{str_replace('_', '-', app()->getLocale())}}">
<head>
    <meta charset="utf-8">
     <meta name="csrf-token" content="{{ csrf_token()}}" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laravel  Dropdown</title>
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.css">
    <style>
        .form{
            all: unset;
            width: 100px;
            font-size: 16px;
            background: #18131300;
            position: relative;
            align-items: center;
            justify-content: center;
            font-family: "Roboto", sans-serif;
            cursor: pointer;
            border: ridge;
            background-image: linear-gradient(#0dccea, #1669cf);
            border-radius: 4px;
            box-shadow: 0px 10px 25px #57aba7, 0px -10px 25px #a6fffa, inset 0px -5px 10px #57aba7, inset 0px 5px 10px #a6fffa;
	        font-family: 'Damion', cursive;
            transition: 500ms;
            }
            .form:hover {
		            border: 2px solid #6dd6d1;
	                animation: hueRotation 2s linear infinite;
                    }
            @keyframes hueRotation {
	              to {filter: hue-rotate(360deg);}
            }   
            
            .table{
                width:100%;
                text-align: center;
                margin-left: 100%;
            }
        </style>   
   </head>
    <body style="background-color:#bcf3f3">
    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-md-3">
                @if(session()->has('message'))
    <div class="alert alert-danger">
        {{session()->get('message')}}
    </div>
    @endif

    <h2 class="mb-">Country State City</h2><br></br>
        <form role="form" action="{{url('/insertinfo')}}" method="post">
                    @csrf
                    <div class="form-group mb-3">
                        <select  id="country-dd" name="country_id" class="form-control">
                            <option value="">Select Country</option>
                             @foreach($countries as $data)
                            <option value="{{$data->c_id}}">
                                {{$data->c_name}}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group mb-3">
                        <select id="state-dd" name="state_id" class="form-control">
                            <option value="">Select state</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <select id="city-dd" name="city_id" class="form-control">
                            <option value="">Select City</option> 
                        </select>
                    </div>
                    <br></br>
                    <center>
                        <input style=text-align:center type="submit" value="Submit" class="form" >
                    </center>
                    <br></br>
                    <div>
                        <form type="get" action="{{url('/search')}}">
                        <input  type="search" id="search" name="search" placeholder="Search here"/>
                
                         </div>  
                    </form><br></br>
                    <center>
                        <table style="border:2px solid black;">
                          <tr style="background-color: rgb(207, 182, 212);">
                            <th>No</th>
                            <th>Country</th>
                            <th>State</th>
                            <th>City</th>
                            <th>Action</th>
                          </tr>
                          <?php $i= 1; ?>
                           @foreach($info as $val)
                          <tr style='with:500px,height:100px'>
                            <td>{{$i++}} </td>
                            <td>{{$val->c_name}}</td>
                            <td>{{$val->s_name}}</td>
                            <td>{{$val->ci_name}}</td> 
                          <td>
                              <a href="{{url('fatchinfo')}}/{{$val->id}}">Edit</a>
                              <a href="{{url('deleteinfo')}}/{{$val->id}}" onClick="form()">Delete</a>
                            </td>
                          </tr>
                          @endforeach 
                          <tbody id="mycard"></tbody>
                        </table>
                      </center>
                </form>
            </div>
              </center>
         </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.js"></script>
     <script>
        function form() {
                                alert("Are you sure  you want to Delete?");
                        }
        </script>
    <script>
        $(document).on('keyup','#search', function(){
            // alert($(this).val());
            var searching = $(this).val();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
                $.ajax({
                    type:"POST",
                    url:"{{url('/search')}}",
                    data:{
                        'searching':searching
                    },
                    success:function(data) {

                        var res = '';
                        var a = 1;
                        // $("#complain_added_"+b).remove();
                        $.each(data, function(key, value) {
                           
                                res += '<tr>';
                                res+= '<td>'+ a +'</td>';
                                res+= '<td>'+ value.c_name +'</td>';
                                res+= '<td>'+ value.s_name +'</td>';
                                res+= '<td>'+ value.ci_name +'</td>';
                                res+= '<td>';
                                res+= '<a>Update</a>';
                                res+= '<a>Delete</a>';
                                res+= '</td>';
                                res += '</tr>';
                                    a++;
                        });
                        $("#mycard").html(res);
                      $('.mycard').html(data);
                    }
                });
            });
        $("#example1").DataTable({
            
         });
        $(document).ready(function(){
            $('#country-dd').on('change', function(){
                var idCountry = this.value;
                $("#state-dd").html('');
                $.ajax({
                    url: "{{url('api/fetch-states')}}",
                    type: "POST",
                    data: {
                        country_id: idCountry,
                        _token:'{{csrf_token()}}'
                    },
                    dataType:'json',
                    success: function (result) {
                        $('#state-dd').html('<option value="">Select State</option>');
                        $.each(result.states, function (key, value) {
                            $("#state-dd").append('<option value="' + value
                                .s_id + '">' + value.s_name + '</option>');
                        });
                        $('#city-dd').html('<option value="">Select City</option>');
                    }
                });
            });
            $('#state-dd').on('change',function(){
                var idState = this.value;
                $("#city-dd").html('');
                $.ajax({
                    url: "{{url('api/fetch-cities')}}",
                    type: "POST",
                    data: {
                        state_id: idState,
                        _token: '{{csrf_token()}}'
                    },
                    dataType:'json',
                    success:function(res){
                        $('#city-dd').html('<option value="">Select City</option>');
                        $.each(res.cities, function (key, value)
                        {
                            $("#city-dd").append('<option value="' + value
                                .ci_id + '">' + value.ci_name + '</option>');
                        });
                    }
                });
            });
        });
    </script>
</body>
</html>

