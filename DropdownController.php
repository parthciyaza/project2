<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Response;
use Redirect;
use App\Models\{Country, State, City,Info};

class DropdownController extends Controller
{
    public function index(Request $request)
    {   
        // $search = $request['search'] ?? "";
        // if($search !=""){
        //     $countries = country::where('c_name','=',$search)->get();

        // }else{
            $data['countries'] = Country::get(["c_name", "c_id"]);
       





        // $data['countries'] = Country::get(["c_name", "c_id"]);
        $data['info'] = info::join('cities','info.city_id','=','cities.ci_id')
                            ->join('states','info.state_id','=','states.s_id')
                            ->join('countries','info.country_id','=','countries.c_id')
                            ->get();
        
    // $data = compact('countries','search');
        return view('welcome',$data);
    }
    public function fetchState(Request $request)
    {
        $country_id = $request->input('country_id');
        $data['states'] = State::where("c_id",$country_id)->get();
        return response()->json($data);
    }
    public function deleteinfo($id)
    {
        $delete = info::where("id",$id)->first();
        $delete->delete();
        return redirect("/dependent-dropdown");
    }
   
    
    public function fetchCity(Request $request)
    {
        $s_id = $request->input('state_id');
        $data['cities'] = City::where("s_id",$s_id)->get();
        return response()->json($data);
    }

    public function insertinfo(Request $request)
    {           
        $data = $request->input() ;
        $ins = array(
            'country_id'=>$request->input('country_id'),
            'state_id'=>$request->input('state_id'),
            'city_id'=>$request->input('city_id'),
        );
        Info::create($ins);
        return redirect()->back()->with('message',"Data insert successfully");
    }
    public function fatchinfo($id)
    {
       $info = info::where('id',$id)->first();
       $countries = Country::all();
       $state = State::get();
       $city = city::get();

       return view("updateinfo",compact('info','countries','state','city'));
    }
     public function updateinfo(Request $request,$id)
    {
        $data = $request->input();
        $ins = array(
            'country_id'=>$request->input('country_id'),
            'state_id'=>$request->input('state_id'),
            'city_id'=>$request->input('city_id'),
        );
        Info::where("id",$id)->update($ins);
        return redirect('/dependent-dropdown');
    }

     public function search1(Request $request)
     {


        if($request->ajax()){
        $output = '';
         $info= info:: where('country_id','LIKE','%' .$request->search. '%')
                        ->orwhere('state_id','LIKE','%' .$request->search. '%')
                        ->orwhere('city_id','LIKE','%' .$request->search. '%')
                        ->get();
                        return view("searchinfo",compact('info'));
                    

         if($infos) {
            foreach($info as $info) {
                $output .= 
                '<div>
                <?php $i= 1; ?>
                @foreach($info as $val)
               <tr>
                 <td>{{$i++}} </td>
                 <td>{{$val->c_name}}</td>
                 <td>{{$val->s_name}}</td>
                 <td>{{$val->ci_name}}</td> 
                </tr>
               @endforeach 
               </div>';
            }
            return response()->json($output);
         }

     }
    
    }
    public function search(Request $request)
    {
        $searching = $request->input('searching');
        // dd($searching);
        $country = country::where('c_name','LIKE','%'.$searching. '%')
                            ->join('states','countries.c_id','states.c_id')
                            ->join('cities','states.s_id','cities.s_id')
                            ->get();
        // $info= info:: where('country_id','LIKE','%' .$request->search. '%')
        
        return response($country);
    }
     
}
