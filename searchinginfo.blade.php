

<html lang="{{str_replace('_', '-',app()->getLocale())}}">

     <head>
            <meta charset="utf-8">
            <meta name="csrf-token" content="content">
             <meta name="csrf-token" content="{{csrf_token()}}">
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <title>Laravel  Dropdown</title>
            
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet">
            <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.css">
    </head>  
    <body>  
    <div class="container mt-3 pd-3">

            <h2>serching</h2>
            <form role="form" action="{{url('/searchinfo')}}/{{$info->id}}"method="post">
                <h1> saerchingc g</h1>
            </form>    

            <div class="row justify-content-center">
                <div class="col-md-4"> 
                    <div class="input-group">
                        <input type="text"  id="search"  name=" "class="form-control rounded" placeholder="Search"/>
                        
                      </div>
                </div>
                <div class="col-md-8">
                        <div class="card mycard m-2 p-2" style="width: 18rem;">

                            <table style="border:2px solid black;">
                                <tr style="background-color: rgb(233, 136, 255);">
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
                                
                                </tr>
                                @endforeach 
                              </table>
                        </div>
                </div>
            </div>    
    </div>

    <script type="text/javascript">
        var route = "{{ url('searchinfo') }}";
        $('#search').typeahead({
            source: function (query, process) {
                return $.get(route, {
                    query: query
                }, function (data) {
                    return process(data);
                });
            }
        });
    </script>

    <script>

        
        $(document).on('keyup','#search', function(){
            alert($(this).val());
        });
    </script>     
</body>    
</html>    