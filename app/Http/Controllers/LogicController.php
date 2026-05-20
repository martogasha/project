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
        $default = Institution::where('id',$id)->update(['connection_status'=>null]);

        return redirect()->back()->with('success','INSTITUTION CONNECTED SUCCESS');

    }
     public function removeConnect($id){
        $intitutions = Institution::find($id);
        $default = Institution::where('id',$id)->update(['connection_status'=>0]);

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
     
        $store->save();
        return redirect('registered')->with('success','INSTITUTION REGISTERED SUCCESS');
        
    }
     public function eInstitution(Request $request, $id){
        $store = Institutionfind($id);
        $store->institution_name = $request->input('institution_name');
        $store->registration_fee = $request->input('registration_fee');
        $store->instalation_fee = $request->input('instalation_fee');
        $store->monthly_payment_id = $request->input('monthly_payment');
        $store->monthlyPayment_id = $request->input('monthly_payment');
        $store->No_of_computers = $request->input('No_of_computers');
        $store->lan_nodes = $request->input('lan_nodes');
        $store->fine = 0;
        $store->reconnection_fee = 0;
        $store->defaulters_status = 0;
        $store->connection_status = 0;
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
