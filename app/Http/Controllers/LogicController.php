<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\monthlyPayment;
use App\Models\Institution;


class LogicController extends Controller
{
      public function index(){
        $registered = Institution::count();
        $defaulted = Institution::where('defaulters_status',0)->count();
        $disconnected = Institution::where('connection_status',0)->count();
        return view('welcome',[
            'registered'=>$registered,
            'defaulted'=>$defaulted,
            'disconnected'=>$disconnected,
        ]);
    }
     public function registered(){
        $intitutions = Institution::orderByDesc('id')->get();
        return view('registered',[
            'intitutions'=>$intitutions
        ]);
    }
    public function defaulters(){
          $intitutions = Institution::where('defaulters_status',0)->get();
        return view('defaulters',[
            'intitutions'=>$intitutions
        ]);
    }
    public function default($id){
        $intitutions = Institution::find($id);
        $default = Institution::where('id',$id)->update(['defaulters_status'=>0]);

        return redirect()->back()->with('success','INSTITUTION DEFAULTED SUCCESS');

    }
     public function removeDefault($id){
        $intitutions = Institution::find($id);
        $default = Institution::where('id',$id)->update(['defaulters_status'=>null]);

        return redirect()->back()->with('success','INSTITUTION DEFAULT REMOVED');

    }
     public function connect($id){
        $intitutions = Institution::find($id);
        $default = Institution::where('id',$id)->update(['connection_status'=>null,'reconnection_fee'=>null,'fine'=>null]);

        return redirect()->back()->with('success','INSTITUTION CONNECTED SUCCESS');

    }
     public function removeConnect($id){
        $intitutions = Institution::find($id);
        $default = Institution::where('id',$id)->update(['connection_status'=>0,'reconnection_fee'=>1000,'fine'=>$intitutions->monthly_payment_id*0.15]);

        return redirect()->back()->with('success','INSTITUTION DISCONNECTED SUCCESS');

    }
    public function disconnected(){
            $intitutions = Institution::where('connection_status',0)->get();
        return view('disconnected',[
            'intitutions'=>$intitutions
        ]);
    }
     public function register(){
        $monthlys = monthlyPayment::all();
        return view('register',[
            'monthlys'=>$monthlys   
        ]);
    }
    public function editRegister($id){
        $intitution = Institution::find($id);
        $monthlys = monthlyPayment::all();
        return view('eRegister',[
            'intitution'=>$intitution,
            'monthlys'=>$monthlys 
        ]);
    }
    public function storeInstitution(Request $request){
        $store = new Institution();
        $store->institution_name = $request->input('institution_name');
        $store->registration_fee = $request->input('registration_fee');
        $store->instalation_fee = $request->input('instalation_fee');
        $store->monthly_payment_id = $request->input('monthly_payment');
        $store->monthlyPayment_id = $request->input('monthly_payment');
        $store->No_of_computers = $request->input('No_of_computers');
        $store->lan_nodes = $request->input('lan_nodes');
           if($request->input('lan_nodes') <2){
           $store->lan_nodes_amount = 0; 
        }
           if($request->input('lan_nodes') >=2 && $request->input('lan_nodes') <= 10){
           $store->lan_nodes_amount = 10000; 
        }
        if($request->input('lan_nodes') >=11 && $request->input('lan_nodes') <= 20){
           $store->lan_nodes_amount = 20000; 
        }
        if($request->input('lan_nodes') >=21 && $request->input('lan_nodes') <= 40){
           $store->lan_nodes_amount = 30000; 
        }
        if($request->input('lan_nodes') >=41 && $request->input('lan_nodes') <= 100){
           $store->lan_nodes_amount = 40000; 
        }
     
        $store->save();
        return redirect('registered')->with('success','INSTITUTION REGISTERED SUCCESS');
        
    }
     public function eInstitution(Request $request){
        $store = Institution::find($request->id);
        $get = Institution::where('id',$request->id)->first();
        $store->institution_name = $request->input('institution_name');
        $store->registration_fee = $request->input('registration_fee');
        $store->instalation_fee = $request->input('instalation_fee');
      
        $store->monthly_payment_id = $request->input('monthly_payment');
        
        if($request->input('monthly_payment') > $get->monthly_payment_id){
            $discount = $request->input('monthly_payment') * 0.1;
            $store->discount = $discount;
        }
        else{
            $store->discount = null;
        }
        $store->monthlyPayment_id = $request->input('monthly_payment');
        $store->No_of_computers = $request->input('No_of_computers');
        $store->lan_nodes = $request->input('lan_nodes');
         if($request->input('lan_nodes') <2){
           $store->lan_nodes_amount = 0; 
        }
           if($request->input('lan_nodes') >=2 && $request->input('lan_nodes') <= 10){
           $store->lan_nodes_amount = 10000; 
        }
        if($request->input('lan_nodes') >=11 && $request->input('lan_nodes') <= 20){
           $store->lan_nodes_amount = 20000; 
        }
        if($request->input('lan_nodes') >=21 && $request->input('lan_nodes') <= 40){
           $store->lan_nodes_amount = 30000; 
        }
        if($request->input('lan_nodes') >=41 && $request->input('lan_nodes') <= 100){
           $store->lan_nodes_amount = 40000; 
        }

      
        $store->save();
        return redirect('registered')->with('success','INSTITUTION UPDATED SUCCESS');
        
    }
    public function bandwidth(){
        $bandwidths = monthlyPayment::orderByDesc('id')->get();
        return view('bandwidth',[
            'bandwidths'=>$bandwidths
        ]);
    }
    public function Addbandwidth(){
        return view('addBandwidth');
    }
    public function storeBandwidth(Request $request){
        $store = new monthlyPayment();
        $store->name = $request->input('name');
        $store->amount = $request->input('amount');
        $store->save();
        return redirect('bandwidth')->with('success','BANDWIDTH ADDED SUCCESS');
    }
    public function editbandwidth($id){
        $band = monthlyPayment::find($id);
        return view('editBandwidth',[
            'band'=>$band
        ]);
    }
     public function ebandwidth(Request $request, $id){
        $band = monthlyPayment::find($id);
        $band->name = $request->input('name');
        $band->amount = $request->input('amount');
        $band->save();
        return redirect('bandwidth')->with('success','BANDWIDTH EDITED SUCCESS');
    }
    public function deleteBandwidth($id){
        $del = monthlyPayment::where('id',$id)->delete();
        return redirect('bandwidth')->with('success','BANDWIDTH DELETED SUCCESS');

    }
}
