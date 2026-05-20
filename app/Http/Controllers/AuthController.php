<?php

namespace App\Http\Controllers;

use App\Models\HotelOrder;
use App\Models\salesHotel;
use App\Models\Stock;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function index(){
        return view('auth.login');
    }
    public function users(){
        if (Auth::check()){
            $users = User::orderByDesc('id')->get();
            return view('admin.users',[
                'users'=>$users
            ]);
        }
        else{
            redirect(url('login'));
        }

    }
    public function userEdit($id){
        $edit = User::find($id);
        return view('admin.stockUser',[
            'edit'=>$edit
        ]);
    }
    public function eUser(Request $request){
        $edit = User::find($request->userId);
        $edit->first_name = $request->first_name;
        $edit->last_name = $request->last_name;
        $edit->phone = $request->phone;
        $edit->role = $request->role;
        $edit->save();
        return redirect(url('users'))->with('success','USER EDITED SUCCESS');
    }
    public function addUser(){
        return view('admin.addUsers');
    }
    public function storeUsers(Request $request){
        $store = User::create([
            'first_name'=>$request->first_name,
            'last_name'=>$request->last_name,
            'phone'=>$request->phone,
            'role'=>$request->role,
            'password'=>Hash::make('password')
        ]);
        return redirect(url('users'))->with('success','USER ADDED SUCCESS');
    }
    public function deleteUser(Request $request){
        $output = "";
        $stockId = User::find($request->id);
        $output = '
            <input type="hidden" value="'.$stockId->id.'" name="userId">
            <div class="modal-title h4">ARE YOU SURE YOU</div> <button type="button" class="btn-close" aria-label="Close" data-bs-dismiss="modal"></button>

        ';
        return response($output);
    }
    public function dUser(Request $request){
        $del = User::find($request->userId);
        $del->delete();
        return redirect(url('users'))->with('success','USER DELETED SUCCESS');
    }
    public function reset($id){
        $password = Hash::make('password');
        $res = User::where('id',$id)->update(['password'=>$password]);
        return redirect(url('users'))->with('success','PASSWORD RESET SUCCESS');

    }
    public function Login(Request $request){
        $user = User::where('phone',$request->phone)->first();
        if (Auth::attempt([
            'phone' => $request->phone,
            'password' => $request->password,
        ])){
            if ($user->role==1){
                return redirect(url('hotelDashboard'));
            }
            if ($user->role==2){
                return redirect(url('HardwareDashboard'));
            }
            if ($user->role==0){
                return redirect(url('HardwareDashboard'));

            }
        }
        else{
            return redirect()->back()->with('error', 'CREDENTIALS DOES NOT MATCH');
        }
    }
    public function receiptFooter(Request $request){
        $output = "";
        $order = HotelOrder::latest('id')->first();
        if ($order->payment_method==1){
            $p = 'Mpesa';
        }
        elseif($order->payment_method==3){
            $p = 'Credit';

        }
        else{
            $p = 'Cash';

        }
        $output = '
           <table class="summary" cellspacing="0">
                                                    <tbody>
                                                    <tr>
                                                        <td>payment Method:</td>
                                                        <td>'.$p.'</td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                                <table class="summary" cellspacing="0">
                                                    <tbody>
                                                    <tr>
                                                        <td>Name:</td>
                                                        <td>'.$order->name.'</td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                                <table class="summary" cellspacing="0">
                                                    <tbody>
                                                    <tr>
                                                        <td>Phone No:</td>
                                                        <td>'.$order->phone.'</td>
                                                    </tr>
                                                    </tbody>
                                                </table>
        ';
        return response($output);
    }
    public function receiptF(Request $request){
        $output = "";
        $order = HotelOrder::find($request->id);
        if ($order->payment_method==1){
            $p = 'Mpesa';
        }
        elseif($order->payment_method==3){
            $p = 'Credit';

        }
        else{
            $p = 'Cash';

        }
        $output = '
           <table class="summary" cellspacing="0">
                                                    <tbody>
                                                    <tr>
                                                        <td>payment Method:</td>
                                                        <td>'.$p.'</td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                                <table class="summary" cellspacing="0">
                                                    <tbody>
                                                    <tr>
                                                        <td>Name:</td>
                                                        <td>'.$order->name.'</td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                                <table class="summary" cellspacing="0">
                                                    <tbody>
                                                    <tr>
                                                        <td>Phone No:</td>
                                                        <td>'.$order->phone.'</td>
                                                    </tr>
                                                    </tbody>
                                                </table>
        ';
        return response($output);
    }
    public function restock(){
        $restock = salesHotel::where('reprofit',null)->update(['reprofit'=>1]);
        return redirect(url('hotelDashboard'))->with('success','SUCCESS');
    }
}
