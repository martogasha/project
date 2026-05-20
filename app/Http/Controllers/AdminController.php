<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\Hotelexpense;
use App\Models\HotelOrder;
use App\Models\Hotelstock;
use App\Models\Order;
use App\Models\Sales;
use App\Models\salesHotel;
use App\Models\Sell;
use App\Models\sellHotel;
use App\Models\Stock;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function index(){
        $sales = Order::orderByDesc('id')->get();
        return view('admin.index',[
            'sales'=>$sales
        ]);
    }
    public function hotelAdmin(){
        if (Auth::check()){
            $sales = HotelOrder::where('date',Carbon::now()->format('Y-m-d'))->orderByDesc('id')->get();
            $products = Hotelstock::all();
            $credit = HotelOrder::where('payment_method',3)->sum('total');
            $sal = salesHotel::where('date',\Carbon\Carbon::now()->format('Y-m-d'))->where('barcode','!=','0606')->where('barcode','!=','0502')->where('barcode','!=','0702')->where('reprofit',null)->sum('profit');
            $salii = salesHotel::where('date',\Carbon\Carbon::now()->format('Y-m-d'))->where('barcode','0606')->sum('profit');
            $salits = salesHotel::where('date',\Carbon\Carbon::now()->format('Y-m-d'))->where('barcode','0502')->sum('profit');
            $exp = Hotelexpense::where('end_date',null)->sum('amount');
            $tak = salesHotel::where('barcode','!=','0606')->where('barcode','!=','0502')->where('barcode','!=','0702')->where('reprofit',null)->sum('profit');
            $ttt = Hotelexpense::where('end_date',null)->sum('amount');
            $chipsProf = salesHotel::where('date',\Carbon\Carbon::now()->format('Y-m-d'))->where('barcode','0606')->sum('profit');
            $sodaProf = salesHotel::where('date',\Carbon\Carbon::now()->format('Y-m-d'))->where('barcode','0702')->sum('profit');
            $smokieProf = salesHotel::where('date',\Carbon\Carbon::now()->format('Y-m-d'))->where('barcode','0502')->sum('profit');
            $expe = Hotelexpense::where('end_date',null)->sum('amount');
            $dailySales = salesHotel::where('date',\Carbon\Carbon::now()->format('Y-m-d'))->sum('total')-$credit;
            $ee = $ttt+$credit;
            $takeAwayProf = $tak-$ee;
            $eeeeee = $exp+$credit;
            $totalProfit = $sal+$salii+$salits+$sodaProf-$eeeeee;
            return view('admin.indexHotel',[
                'sales'=>$sales,
                'products'=>$products,
                'credit'=>$credit,
                'totalProfit'=>$totalProfit,
                'takeAwayProf'=>$takeAwayProf,
                'chipsProf'=>$chipsProf,
                'sodaProf'=>$sodaProf,
                'smokieProf'=>$smokieProf,
                'expe'=>$expe,
                'dailySales'=>$dailySales,

            ]);
        }
        else{
            return redirect(url('login'));
        }
    }
    public function HardwareDashboard(){
        if (Auth::check()){
            $sales = Order::where('date',Carbon::now()->format('Y-m-d'))->orderByDesc('id')->get();
            $products = Stock::all();
            $alertStock = Stock::where('quantity','<',5)->first();
            return view('admin.indexHardware',[
                'sales'=>$sales,
                'products'=>$products,
                'alertStock'=>$alertStock
            ]);
        }
        else{
            return redirect(url('login'));
        }

    }
    public function expense(){
        if (Auth::check()){
            $expenses = Expense::orderByDesc('id')->get();
            return view('admin.expense',[
                'expenses'=>$expenses
            ]);
        }
        else{
            return redirect(url('login'));

        }

    }
    public function expenseHotel(){
        if (Auth::check()){
            $expenses = Hotelexpense::orderByDesc('id')->get();
            return view('admin.expenseHotel',[
                'expenses'=>$expenses
            ]);
        }
        else{
            return redirect(url('login'));
        }

    }
    public function addExpense(){
        if (Auth::check()){
            return view('admin.addExpense');

        }
        else{
            return redirect(url('login'));
        }
    }
    public function addHotelExpense(){
        if (Auth::check()){
            $products = Hotelstock::all();
            return view('admin.addHotelExpense',[
                'products'=>$products
            ]);

        }
        else{
            return redirect('login');
        }
    }
    public function storeExpense(Request $request){
        $store = Expense::create([
            'name'=>$request->name,
            'desc'=>$request->desc,
            'amount'=>$request->amount,
            'date'=>$request->date,
            'payment_method'=>$request->paymentMethod,
        ]);
        return redirect(url('expense'))->with('success','EXPENSE ADDED SUCCESS');
    }
    public function storeHotelExpense(Request $request){
        $getProduct = Hotelstock::find($request->id);
        $productName = $getProduct->product_name;
        $productBarcode = $getProduct->barcode;
        if (isset($request->name)){
            $store = Hotelexpense::create([
                'name'=>$request->name,
                'desc'=>$request->desc,
                'amount'=>$request->amount,
                'date'=>$request->date,
                'end_date'=>$request->end_date,
                'payment_method'=>$request->payment_method,
            ]);
        }
        else{
            $store = Hotelexpense::create([
                'name'=>$productName,
                'barcode'=>$productBarcode,
                'desc'=>$request->desc,
                'amount'=>$request->amount,
                'date'=>$request->date,
                'end_date'=>$request->end_date,
                'payment_method'=>$request->payment_method,
            ]);
        }
    }
    public function expenseEdit($id){
        $expense = Expense::find($id);
        return view('admin.editExpense',[
            'expense'=>$expense
        ]);

    }
    public function expenseHotelEdit($id){
        $expense = Hotelexpense::find($id);
        return view('admin.editHotelExpense',[
            'expense'=>$expense
        ]);

    }
    public function eExpense(Request $request){
        $edit = Expense::find($request->expenseId);
        $edit->name = $request->name;
        $edit->desc = $request->desc;
        $edit->amount = $request->amount;
        $edit->date = $request->date;
        $edit->payment_method = $request->paymentMethod;
        $edit->save();
        return redirect(url('expense'))->with('success','EXPENSE EDITED SUCCESS');
    }
    public function eHotelExpense(Request $request){
        $edit = Hotelexpense::find($request->expenseId);
        $edit->name = $request->name;
        $edit->desc = $request->desc;
        $edit->amount = $request->amount;
        $edit->date = $request->date;
        $edit->end_date = $request->end_date;
        $edit->payment_method = $request->paymentMethod;
        $edit->save();
        return redirect(url('expenseHotel'))->with('success','EXPENSE EDITED SUCCESS');
    }
    public function sell(){
        if (Auth::check()){
            $stocks = Stock::orderByDesc('id')->get();
            $sells = Sell::orderByDesc('id')->get();
            return view('admin.sell',[
                'stocks'=>$stocks,
                'sells'=>$sells
            ]);
        }
        else{
            return redirect(url('login'));
        }

    }
    public function sellHotel(){
        if (Auth::check()){
            $stocks = Hotelstock::all();
            $sells = sellHotel::orderByDesc('id')->get();
            return view('admin.sellHotel',[
                'stocks'=>$stocks,
                'sells'=>$sells
            ]);
        }
        else{
            return redirect(url('login'));

        }

    }
    public function stock(){
        if (Auth::check()){
            $products = Stock::orderByDesc('id')->get();
            return view('admin.stock',[
                'products'=>$products
            ]);
        }
        else{
            return redirect(url('login'));
        }

    }
    public function stockBelowFive(){
        if (Auth::check()){
            $products = Stock::where('quantity','<',5)->get();
            return view('admin.stockBelowFive',[
                'products'=>$products
            ]);
        }
        else{
            return redirect(url('login'));
        }

    }
    public function hotelStock(){
        if (Auth::check()){
            $products = Hotelstock::orderByDesc('id')->get();
            return view('admin.hotelStock',[
                'products'=>$products
            ]);
        }
        else{
            return redirect(url('login'));
        }

    }
    public function addProduct(){
        if (Auth::check()){
            return view('admin.addProduct');

        }
        else{
            return redirect(url('login'));
        }
    }
    public function addHotelProduct(){
        if (Auth::check()){
            return view('admin.addProductHotel');

        }
        else{
            return redirect(url('login'));
        }
    }
    public function uSell(Request $request){
        $output = "";
        $sell = Sell::find($request->id);
        $buying = Stock::where('barcode',$sell->barcode)->first();
        $output = '
          <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">'.$sell->product_name.'</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="field-wrapper">
                        <input type="hidden" value="'.$sell->id.'" name="sellId">
                            <input type="text" class="form-control" value="'.$sell->quantity.'" name="quantity">
                            <div class="field-placeholder">Quantity</div>
                        </div>
                         <div class="field-wrapper">
                            <input type="text" class="form-control" value="'.$sell->selling_price.'" name="price">
                            <div class="field-placeholder">Price</div>
                        </div>
                    </div>
        ';
        return response($output);
    }
    public function uHotelSell(Request $request){
        $output = "";
        $sell = sellHotel::find($request->id);
        $output = '
          <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">'.$sell->product_name.'</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="field-wrapper">
                        <input type="hidden" value="'.$sell->id.'" name="sellId">
                            <input type="text" class="form-control" value="'.$sell->quantity.'" name="amount">
                            <div class="field-placeholder">Quantity</div>
                        </div>
                    </div>
        ';
        return response($output);
    }
    public function burgain(Request $request){
        $getSell = Sell::find($request->sellId);
        $getProduct = Stock::where('barcode',$getSell->barcode)->first();
        $sellQ = $getSell->quantity;
        $stockQ = $getProduct->quantity;
        $stockF = $stockQ+$sellQ;
        $FinalStock = $stockF-$request->quantity;
        $sellingP = $request->price;
        $total = $sellingP*$request->quantity;
        $updateStock = Stock::where('id',$getProduct->id)->update(['quantity'=>$FinalStock]);
        $updateSell = Sell::where('id',$getSell->id)->update(['quantity'=>$request->quantity]);
        $updateSell = Sell::where('id',$getSell->id)->update(['total'=>$total]);
        $updateSell = Sell::where('id',$getSell->id)->update(['selling_price'=>$request->price]);
        return redirect()->back()->with('success','QUANTITY EDITED');

    }
    public function burgainHotel(Request $request){
        $getSell = sellHotel::find($request->sellId);
        $getStockQuantity = Hotelstock::where('barcode',$getSell->barcode)->first();
        $getStockQa = Hotelstock::where('barcode',$getStockQuantity->barcodeOne)->first();
        if (!is_null($getStockQa)){
            $sellQ = $getSell->quantity;
            $changedQ = $request->amount;
            $stockQuantity = $getStockQuantity->fixed;
            $currentSt = $getStockQa->quantity;
            $cStockFunction = $stockQuantity*$sellQ;
            $fStock = $currentSt+$cStockFunction;
            $cStockToDeduct = $stockQuantity*$changedQ;
            $finalStock = $fStock-$cStockToDeduct;
            $sellingPrice = $getStockQuantity->selling_price;
            $total = $sellingPrice*$changedQ;
            $updatePrice = sellHotel::where('id', $request->sellId)->update(['quantity'=>$changedQ]);
            $updateTotal = sellHotel::where('id', $request->sellId)->update(['total'=>$total]);
            $updateQ = Hotelstock::where('id',$getStockQa->id)->update(['quantity'=>$finalStock]);
        }
        else{
            $sellQ = $getSell->quantity;
            $changedQ = $request->amount;
            $packNo = $getStockQuantity->number_of_pack;
            $qOfPack = $getStockQuantity->quantity_of_pack;
            $quant = $getStockQuantity->quantity;
            $stockQ = $packNo*$qOfPack+$quant;
            $eStock = $stockQ+$sellQ;
            $fStock = $eStock-$changedQ;
            $total = $getStockQuantity->selling_price*$changedQ;
            $noOfPack = intdiv($fStock,$qOfPack);
            $finalQ = $fStock%$qOfPack;
            $updatePrice = sellHotel::where('id', $request->sellId)->update(['quantity'=>$changedQ]);
            $updateTotal = sellHotel::where('id', $request->sellId)->update(['total'=>$total]);
            $updateStock = Hotelstock::where('id',$getStockQuantity->id)->update(['number_of_pack'=>$noOfPack]);
            $updateQ = Hotelstock::where('id',$getStockQuantity->id)->update(['quantity'=>$finalQ]);
        }
        return redirect()->back()->with('success','AMOUNT EDITED');
    }
    public function deleteExpense(Request $request){
        $output = "";
        $stockId = Expense::find($request->id);
        $output = '
            <input type="hidden" value="'.$stockId->id.'" name="expenseId">
            <div class="modal-title h4">ARE YOU SURE</div> <button type="button" class="btn-close" aria-label="Close" data-bs-dismiss="modal"></button>

        ';
        return response($output);
    }
    public function deleteHotelExpense(Request $request){
        $output = "";
        $stockId = Hotelexpense::find($request->id);
        $output = '
            <input type="hidden" value="'.$stockId->id.'" name="expenseId">
            <div class="modal-title h4">ARE YOU SURE</div> <button type="button" class="btn-close" aria-label="Close" data-bs-dismiss="modal"></button>

        ';
        return response($output);
    }
    public function dExpense(Request $request){
        $delete = Expense::find($request->expenseId);
        $delete->delete();
        return redirect()->back()->with('success','EXPENSE DELETED SUCCESS');
    }
    public function dHotelExpense(Request $request){
        $delete = Hotelexpense::find($request->expenseId);
        $delete->delete();
        return redirect()->back()->with('success','EXPENSE DELETED SUCCESS');
    }
    public function viewSale(Request $request){
        $output = "";
        $sales = Sales::where('order_id',$request->id)->orderByDesc('id')->get();
        foreach ($sales as $sale) {
            $output .= '
                                        <tr class="order">

                                            <td class="order-number" data-title="Order">
                                                <a href="*">'.$sale->product_name.'</a>
                                            </td>

                                            <td class="order-date" data-title="Date">
                                                <time datetime="2014-06-12" title="1402562157">'.$sale->quantity.'</time>
                                            </td>

                                            <td class="order-status" data-title="Status">
                                                '.$sale->selling_price.'
                                            </td>
                                            <td class="order-status" data-title="Status">
                                                '.$sale->discount.'(<b>'.$sale->discount_percentage.'%</b>)
                                            </td>

                                            <td class="order-total" data-title="Total">
                                                <span class="amount">'.$sale->total.'</span>
                                            </td>
                                        </tr>


        ';
        }
        return response($output);
    }
    public function viewHotelSale(Request $request){
        $output = "";
        $sales = salesHotel::where('order_id',$request->id)->orderByDesc('id')->get();
        foreach ($sales as $sale) {
            $output .= '
                                        <tr class="order">

                                            <td class="order-number" data-title="Order">
                                                <a href="*">'.$sale->product_name.'</a>
                                            </td>

                                            <td class="order-date" data-title="Date">
                                                <time datetime="2014-06-12" title="1402562157">'.$sale->quantity.'</time>
                                            </td>

                                            <td class="order-status" data-title="Status">
                                                '.$sale->selling_price.'
                                            </td>

                                            <td class="order-total" data-title="Total">
                                                <span class="amount">'.$sale->total.'</span>
                                            </td>
                                        </tr>


        ';
        }
        return response($output);
    }
    public function viewSaleHeader(Request $request){
        $output = "";
        $sales = Order::find($request->id);
            $output .= '
               <h5 class="modal-title" id="exampleModalLabel">order #'.$sales->id.' <b style="font-size: 20px">'.$sales->phone.'</b></h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            ';

        return response($output);
    }
    public function viewHotelSaleHeader(Request $request){
        $output = "";
        $sales = HotelOrder::find($request->id);
            $output .= '
               <h5 class="modal-title" id="exampleModalLabel">order #'.$sales->id.' <b style="font-size: 20px">'.$sales->name.'</b></h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            ';

        return response($output);
    }
    public function CalTotal(Request $request){
        $output = "";
        $getLatestOrder = Order::latest('id')->first();
        $total = Sales::where('order_id',$getLatestOrder->id)->sum('total');
        $output = '
          <td></td>
                                                        <td class="payment"><h3>Ksh '.$total.'</h3></td>
        ';
        return response($output);
    }
    public function CalTotalHotel(Request $request){
        $output = "";
        $getLatestOrder = HotelOrder::latest('id')->first();
        $total = salesHotel::where('order_id',$getLatestOrder->id)->sum('total');
        $output = '
          <td></td>
                                                        <td class="payment"><b><span>Ksh '.$total.'</span></b></td>
        ';
        return response($output);
    }
    public function profile(){
        if (Auth::check()){
            return view('admin.profile');

        }
        else{
            return redirect(url('login'));
        }
    }
    public function updateProfile(Request $request){
        $update = User::find($request->id);
        $update->first_name = $request->first_name;
        $update->last_name = $request->last_name;
        $update->password = Hash::make($request->password);
        $update->save();
        if ($update->role==1){
            return redirect(url('hotelAdmin'))->with('success','PROFILE UPDATED SUCCESS');
        }
        else{
            return redirect(url('admin'))->with('success','PROFILE UPDATED SUCCESS');

        }
    }
    public function filterHardware(){
        if (Auth::check()){
            $sales = Order::orderByDesc('id')->get();
            return view('admin.indexFilter',[
                'sales'=>$sales
            ]);
        }
        else{
            return redirect(url('login'));
        }

    }
    public function filterHotelIndex(){
        if (Auth::check()){
            $sales = Hotelstock::orderByDesc('id')->get();
            return view('admin.indexHotelFilter',[
                'sales'=>$sales,
            ]);
        }
        else{
            return redirect(url('login'));
        }

    }
    public function filterMpesa(Request $request){
        $start_date = $request->start_date;
        $end_date = $request->end_date;
        if (is_null($request->productId)){
            $sales  = Order::whereBetween('date', array($start_date, $end_date))->get();
            $getProfit  = Sales::whereBetween('date', array($start_date, $end_date))->sum('profit');
            $totalSales  = Sal::whereBetween('date', array($start_date, $end_date))->sum('total');
            $expense  = Hotelexpense::whereBetween('date', array($start_date, $end_date))->sum('amount');
            $products = Stock::all();
            $profit = $getProfit-$expense;
            return view('admin.indexFilter',[
                'sales'=>$sales,
                'profit'=>$profit,
                'totalSales'=>$totalSales,
                'start_date'=>$start_date,
                'end_date'=>$end_date,
                'expense'=>$expense,
                'products'=>$products,
                'check'=>$request->productId,
            ]);
        }
        else{
            $sales  = Sales::whereBetween('date', array($start_date, $end_date))->where('barcode',$request->productId)->get();
            $getProfit  = Sales::whereBetween('date', array($start_date, $end_date))->where('barcode',$request->productId)->sum('profit');
            $totalSales  = Sales::whereBetween('date', array($start_date, $end_date))->where('barcode',$request->productId)->sum('total');
            $discount  = Sales::whereBetween('date', array($start_date, $end_date))->where('barcode',$request->productId)->sum('discount');
            $expense  = Hotelexpense::whereBetween('date', array($start_date, $end_date))->sum('amount');
            $products = Stock::all();
            $profit = $getProfit;
            return view('admin.indexFilter',[
                'sales'=>$sales,
                'total'=>$sales->sum('amount'),
                'profit'=>$profit,
                'totalSales'=>$totalSales,
                'start_date'=>$start_date,
                'end_date'=>$end_date,
                'expense'=>$expense,
                'products'=>$products,
                'discount'=>$discount,
                'check'=>$request->productId,

            ]);
        }

    }
    public function highly(Request $request){
        $start_date = $request->start_date;
        $end_date = $request->end_date;
            $sals  = Sales::whereBetween('date', array($start_date, $end_date))->get()->unique('barcode');
            $hots  = salesHotel::whereBetween('date', array($start_date, $end_date))->get()->unique('barcode');
            return view('admin.highlyMovingProducts',[
                'sals'=>$sals,
                'hots'=>$hots,
                'start_date'=>$start_date,
                'end_date'=>$end_date,
            ]);
    }
    public function filterHotel(Request $request){
        $start_date = $request->start_date;
        $end_date = $request->end_date;
        if (is_null($request->productId)){
            $sales = HotelOrder::whereBetween('date', array($start_date, $end_date))->orderByDesc('id')->get();
            $products = Hotelstock::all();
            $credit = HotelOrder::whereBetween('date', array($start_date, $end_date))->where('payment_method',3)->sum('total');
            $sal = salesHotel::whereBetween('date', array($start_date, $end_date))->where('barcode','!=','0606')->where('barcode','!=','0502')->where('barcode','!=','0702')->sum('profit');
            $salii = salesHotel::whereBetween('date', array($start_date, $end_date))->where('barcode','0606')->sum('profit');
            $salits = salesHotel::whereBetween('date', array($start_date, $end_date))->where('barcode','0502')->sum('profit');
            $exp = Hotelexpense::where('end_date',null)->sum('amount');
            $tak = salesHotel::whereBetween('date', array($start_date, $end_date))->where('barcode','!=','0606')->where('barcode','!=','0502')->where('barcode','!=','0702')->sum('profit');
            $ttt = Hotelexpense::where('end_date',null)->sum('amount');
            $chipsProf = salesHotel::whereBetween('date', array($start_date, $end_date))->where('barcode','0606')->sum('profit');
            $sodaProf = salesHotel::whereBetween('date', array($start_date, $end_date))->where('barcode','0702')->sum('profit');
            $smokieProf = salesHotel::whereBetween('date', array($start_date, $end_date))->where('barcode','0502')->sum('profit');
            $expe = Hotelexpense::where('end_date',null)->sum('amount');
            $dailySales = salesHotel::whereBetween('date', array($start_date, $end_date))->sum('total')-$credit;
            $takeAwayProf = $tak-$ttt;
            $eeeeeee = $exp+$credit;
            $totalProfit = $sal+$salii+$salits+$sodaProf-$eeeeeee;
            return view('admin.indexHotelFilter',[
                'sales'=>$sales,
                'products'=>$products,
                'credit'=>$credit,
                'totalProfit'=>$totalProfit,
                'takeAwayProf'=>$takeAwayProf,
                'chipsProf'=>$chipsProf,
                'sodaProf'=>$sodaProf,
                'smokieProf'=>$smokieProf,
                'expe'=>$expe,
                'dailySales'=>$dailySales,
                'start_date'=>$start_date,
                'end_date'=>$end_date,
            ]);
        }
        else{
            $sales = salesHotel::whereBetween('date', array($start_date, $end_date))->where('barcode',$request->productId)->orderByDesc('id')->get();
            $salesTotal = salesHotel::whereBetween('date', array($start_date, $end_date))->where('barcode',$request->productId)->sum('total');
            $salesProfit = salesHotel::whereBetween('date', array($start_date, $end_date))->where('barcode',$request->productId)->sum('profit');
            $expe = Hotelexpense::where('end_date',null)->sum('amount');
            $pp = $salesProfit-$expe;
            return view('admin.indexHotelFilterEach',[
                'sales'=>$sales,
                'salesTotal'=>$salesTotal,
                'salesProfit'=>$pp,
                'start_date'=>$start_date,
                'end_date'=>$end_date,
            ]);
        }

    }
    public function sellButchery(Request $request){
        $output = "";
        $sell = Hotelstock::find($request->id);
        $output = '
          <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">'.$sell->product_name.'</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="field-wrapper">
                            <input type="text" class="form-control meatAmount"  id="meatAmount">
                            <div class="field-placeholder">Amount(Ksh)</div>
                        </div>
                        <div class="field-wrapper">
                            <input type="text" class="form-control"  name="meatQuantity" id="meatQuantity" disabled>
                            <div class="field-placeholder">Quantity(KG)</div>
                        </div>
                         <div class="field-wrapper">
                        <input type="hidden" value="'.$sell->id.'" id="sellId">
                            <input type="text" class="form-control" id="unitPrice" value="'.$sell->selling_price.'" disabled>
                            <div class="field-placeholder">Unit Price(KG)</div>
                        </div>
                           <div class="field-wrapper">
                        <select class="form-select" id="paymentM">
                            <option value="1">Mpesa</option>
                            <option value="2">Cash</option>
                            <option value="3">Credit</option>
                        </select>
                        <div class="field-placeholder">Payment Method</div>
                    </div>
                    <div class="field-wrapper">
                            <input type="text" class="form-control" id="clientN">
                            <div class="field-placeholder">Name</div>
                        </div>
                        <div class="field-wrapper">
                            <input type="text" class="form-control" id="phoneNo">
                            <div class="field-placeholder">Phone Number</div>
                        </div>
                    </div>
        ';
        return response($output);
    }
    public function reprintReceipt(Request $request){
        $output = "";
        $receipts = salesHotel::where('order_id',$request->id)->orderByDesc('id')->get();
        foreach ($receipts as $receipt){
            $output .='

							     <tr>
                                                    <td data-label="Account">'.$receipt->product_name.'</td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td data-label="Due Date">'.$receipt->quantity.'</td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td data-label="Amount">'.$receipt->selling_price.'</td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td data-label="Amount">'.$receipt->total.'</td>
                                                </tr>

        ';
        }

        return response($output);
    }
    public function sellByProduct(Request $request){
        $output = "";
        $sell = Hotelstock::find($request->id);
        $output = '
          <div class="modal-header">
                                  <input type="hidden" value="'.$sell->id.'" id="sellD">

                        <h5 class="modal-title" id="exampleModalLabel">'.$sell->product_name.'</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="field-wrapper">
                            <input type="text" class="form-control"  name="meatQuantity" id="meatQ">
                            <div class="field-placeholder">Quantity(KG)</div>
                        </div>
                          <div class="field-wrapper">
                        <select class="form-select" id="paymentB">
                            <option value="1">Mpesa</option>
                            <option value="2">Cash</option>
                        </select>
                        <div class="field-placeholder">Payment Method</div>
                        </div>
        ';
        return response($output);
    }
    public function payCredit(Request $request){
        $output = "";
        $order = HotelOrder::find($request->id);
        $salestotal = salesHotel::where('order_id',$order->id)->sum('total');
        $output = '
<input type="hidden" value="'.$order->id.'" name="orderId">
                <div class="field-wrapper">
                    <select class="form-select" name="paymentMethod">
                        <option value="1">Mpesa</option>
                        <option value="2">Cash</option>
                    </select>
                    <div class="field-placeholder">Payment Method</div>
                </div>
                <div class="field-wrapper">
                    <input type="text" value="'.$salestotal.'" class="form-control" name="amount" required>
                    <div class="field-placeholder">Amount</div>
                </div>

        ';
        return response($output);
    }
    public function creditPay(Request $request){
        $order = HotelOrder::where('id',$request->orderId)->update(['payment_method'=>$request->paymentMethod]);
        return redirect(url('hotelDashboard'))->with('success','CREDIT PAID SUCCESS');
    }

}
