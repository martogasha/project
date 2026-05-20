<?php

namespace App\Http\Controllers;

use App\Models\HotelOrder;
use App\Models\Hotelstock;
use App\Models\Order;
use App\Models\Purchase;
use App\Models\Sales;
use App\Models\salesHotel;
use App\Models\Sell;
use App\Models\sellHotel;
use App\Models\Stock;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StockController extends Controller
{
    public function purchase(){
        if (Auth::check()){
            $products = Purchase::orderByDesc('id')->get();
            return view('admin.purchase',[
                'products'=>$products
            ]);
        }
        else{
            return redirect(url('login'));
        }
    }
    public function storeStock(Request $request){
        if (!is_null($request->number_of_pack)){
            $incompleteQuantity = $request->quantity;
            $packs = $request->number_of_pack;
            $packsQuantity = $request->quantity_of_pack;
            $quantity = $packs*$packsQuantity+$incompleteQuantity;
        }
        else{
            $quantity = $request->quantity;
        }
       $store = new Stock();
        $store->barcode = $request->input('barcode');
        $store->product_name = $request->input('product_name');
        $store->quantity = $quantity;
        $store->quantity_of_pack = $request->input('quantity_of_pack');
        $store->number_of_pack = $request->input('number_of_pack');
        $store->buying_price = $request->input('buying_price');
        $store->selling_price = $request->input('selling_price');
        $store->date = $request->input('date');
        if ($request->image) {
            $file = $request->file('image');
            $extension = $file->getClientOriginalName();
            $filename = time() . '.' . $extension;
            $file->move('uploads/product/', $filename);
            $store->image = $filename;
        }
        $store->save();
        return redirect()->back()->with('success','PRODUCT ADDED SUCCESS');
    }
    public function storeHotelStock(Request $request){
        if (!is_null($request->number_of_pack)){
            $incompleteQuantity = $request->quantity;
            $packs = $request->number_of_pack;
            $packsQuantity = $request->quantity_of_pack;
            $quantity = $packs*$packsQuantity+$incompleteQuantity;
        }
        else{
            $quantity = $request->quantity;
        }
       $store = new Hotelstock();
        $store->barcode = $request->input('barcode');
        $store->product_name = $request->input('product_name');
        $store->quantity = $quantity;
        $store->quantity_of_pack = $request->input('quantity_of_pack');
        $store->number_of_pack = $request->input('number_of_pack');
        $store->buying_price = $request->input('buying_price');
        $store->selling_price = $request->input('selling_price');
        $store->date = $request->input('date');
        $store->fixed = $request->input('fixed');
        $store->barcodeOne = $request->input('takeAway');
        if ($request->image) {
            $file = $request->file('image');
            $extension = $file->getClientOriginalName();
            $filename = time() . '.' . $extension;
            $file->move('uploads/product/', $filename);
            $store->image = $filename;
        }
        $store->save();
        return redirect()->back()->with('success','PRODUCT ADDED SUCCESS');
    }
    public function stockEdit($id){
        $edit = Stock::find($id);
        return view('admin.stockEdit',[
            'edit'=>$edit
        ]);
    }
    public function stockHotelEdit($id){
        $edit = Hotelstock::find($id);
        return view('admin.stockHotelEdit',[
            'edit'=>$edit
        ]);
    }
    public function eStock(Request $request){
        if (!is_null($request->number_of_pack)){
            $incompleteQuantity = $request->quantity;
            $packs = $request->number_of_pack;
            $packsQuantity = $request->quantity_of_pack;
            $quantity = $packs*$packsQuantity+$incompleteQuantity;
        }
        else{
            $quantity = $request->quantity;
        }
        $edit = Stock::find($request->stockId);
        $currentQuantity = $edit->quantity;
        $finalQuantity = $currentQuantity+$request->addStock;
        $edit->barcode = $request->barcode;
        $edit->product_name = $request->product_name;
        $edit->quantity = $finalQuantity;
        $edit->quantity_of_pack = $request->input('quantity_of_pack');
        $edit->number_of_pack = $request->input('number_of_pack');
        $edit->buying_price = $request->buying_price;
        $edit->selling_price = $request->selling_price;
        $edit->date = $request->date;
        if ($request->image) {
            $file = $request->file('image');
            $extension = $file->getClientOriginalName();
            $filename = time() . '.' . $extension;
            $file->move('uploads/product/', $filename);
            $edit->image = $filename;
        }
        $edit->save();
        $storeP = new Purchase();
        $storeP->barcode = $request->barcode;
        $storeP->product_name = $request->product_name;
        $storeP->quantity = $request->addStock;
        $storeP->quantity_of_pack = $request->input('quantity_of_pack');
        $storeP->number_of_pack = $request->input('number_of_pack');
        $storeP->buying_price = $request->buying_price;
        $storeP->selling_price = $request->selling_price;
        $storeP->date = $request->date;
        if ($request->image) {
            $file = $request->file('image');
            $extension = $file->getClientOriginalName();
            $filename = time() . '.' . $extension;
            $file->move('uploads/product/', $filename);
            $edit->image = $filename;
        }
        $storeP->save();
        return redirect(url('stock'))->with('success','PRODUCT EDITED SUCCESS');
    }
    public function eHotelStock(Request $request){
        $edit = Hotelstock::find($request->stockId);
        if (!is_null($request->number_of_pack)){
            $incompleteQuantity = $request->quantity;
            $packs = $request->number_of_pack;
            $packsQuantity = $request->quantity_of_pack;
            $totalQ = $packs*$packsQuantity;
            $currectQuant = $edit->number_of_pack;
            $cInPackQuant = $edit->quantity_of_pack;
            $packQ = $currectQuant * $cInPackQuant;
            $cQuant = $edit->quantity;
            $currectQuant = $packQ+$cQuant;
            $totalQuantity = $totalQ+$incompleteQuantity+$currectQuant;
            $packNo = intdiv($totalQuantity, $packsQuantity);
            $getIncomplete = $totalQuantity%$packsQuantity;
            $edit = Hotelstock::find($request->stockId);
            $stockPackNumber = $edit->number_of_pack;
            $currentPackNumber = $packNo;
            $quantity = $getIncomplete;
        }
        elseif(is_null($request->number_of_pack)&&!is_null($edit->quantity_of_pack)&&!is_null($edit->quantity)){
            $incompleteQuantity = $request->quantity;
            $packs = $edit->number_of_pack;
            $packsQuantity = $request->quantity_of_pack;
            $totalQ = $packs*$packsQuantity;
            $cQuant = $edit->quantity;
            $currectQuant = $totalQ+$cQuant;
            $totalQuantity = $currectQuant+$request->quantity;
            $packNo = intdiv($totalQuantity, $packsQuantity);
            $getIncomplete = $totalQuantity%$packsQuantity;
            $edit = Hotelstock::find($request->stockId);
            $stockPackNumber = $edit->number_of_pack;
            $currentPackNumber = $packNo;
            $quantity = $getIncomplete;
        }
        else{
            if (!is_null($request->quantity)){
                $quant = $request->quantity;
                $currentStock = $edit->quantity;
                $quantity = $currentStock+$quant;
            }
            else{
                $quantity = 0;
            }

        }

        $edit->barcode = $request->barcode;
        $edit->product_name = $request->product_name;
        $edit->quantity = $quantity;
        $edit->quantity_of_pack = $request->input('quantity_of_pack');
        if (!is_null($request->quantity)){
            $edit->number_of_pack = $currentPackNumber;

        }
        $edit->buying_price = $request->buying_price;
        $edit->selling_price = $request->selling_price;
        $edit->date = $request->date;
        $edit->fixed = $request->fixed;
        $edit->barcodeOne = $request->takeAway;
        if ($request->image) {
            $file = $request->file('image');
            $extension = $file->getClientOriginalName();
            $filename = time() . '.' . $extension;
            $file->move('uploads/product/', $filename);
            $edit->image = $filename;
        }
        $edit->save();
        return redirect(url('hotelStock'))->with('success','PRODUCT EDITED SUCCESS');
    }
    public function viewStock(Request $request){
        $output = "";
        $product = Stock::find($request->id);
        $output = '
<div class="modal-header">
                                                <div class="modal-title h4">'.$product->product_name.'</div> <button type="button" class="btn-close" aria-label="Close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="card-body">
                                                    <div id="example-form">
                                                        <h3>General Information</h3>
                                                        <h6 class="h-0 m-0">&nbsp;</h6>
                                                        <div class="row gutters">
                                                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">

                                                                <div class="field-wrapper">
                                                                    <div class="input-group">
                                                                        <input type="text" class="form-control" value="'.$product->barcode.'" placeholder="Set Barcode" name="barcode" required>
                                                                    </div>
                                                                    <div class="field-placeholder">Barcode</div>
                                                                </div>

                                                            </div>
                                                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">

                                                                <div class="field-wrapper">
                                                                    <input type="text" placeholder="Enetr Product Name" value="'.$product->product_name.'" name="product_name" required>
                                                                    <div class="field-placeholder">Product Name</div>
                                                                </div>

                                                            </div>
                                                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">

                                                                <div class="field-wrapper">
                                                                    <div class="input-group">
                                                                        <input type="text" class="form-control" value="'.$product->buying_price.'" placeholder="Set Buying Price" name="buying_price" required>
                                                                        <span class="input-group-text">Ksh</span>
                                                                    </div>
                                                                    <div class="field-placeholder">Buying Price</div>
                                                                </div>

                                                            </div>
                                                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">

                                                                <div class="field-wrapper">
                                                                    <div class="input-group">
                                                                        <input type="text" class="form-control" value="'.$product->selling_price.'" placeholder="Set Selling Price" name="selling_price" required>
                                                                        <span class="input-group-text">Ksh</span>
                                                                    </div>
                                                                    <div class="field-placeholder">Selling Price</div>
                                                                </div>

                                                            </div>
                                                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">

                                                                        <div class="field-wrapper">
                                                                            <div class="input-group">
                                                                                <input type="text" class="form-control" value="'.$product->quantity.'" placeholder="Quantity" name="quantity">
                                                                            </div>
                                                                            <div class="field-placeholder">Quantity(Incomplete Park)</div>
                                                                        </div>

                                                                    </div>
                                                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">

                                                                        <div class="field-wrapper">
                                                                            <div class="input-group">
                                                                                <input type="text" class="form-control" value="'.$product->quantity_of_pack.'" placeholder="Quantity in pack" name="quantity_of_pack">
                                                                            </div>
                                                                            <div class="field-placeholder">Quantity in pack</div>
                                                                        </div>

                                                                    </div>
                                                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">

                                                                        <div class="field-wrapper">
                                                                            <div class="input-group">
                                                                                <input type="text" class="form-control" value="'.$product->number_of_pack.'" placeholder="Pack No:" name="number_of_pack">
                                                                            </div>
                                                                            <div class="field-placeholder">Pack Number</div>
                                                                        </div>

                                                                    </div>

                                                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">

                                                                <div class="field-wrapper">
                                                                    <div class="input-group">
                                                                        <input type="date" value="'.$product->date.'" class="form-control" name="date">
                                                                    </div>
                                                                    <div class="field-placeholder">Date</div>
                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>
                                            </div>
        ';
        return response($output);
    }
    public function viewHotelStock(Request $request){
        $output = "";
        $product = Hotelstock::find($request->id);
        $output = '
<div class="modal-header">
                                                <div class="modal-title h4">'.$product->product_name.'</div> <button type="button" class="btn-close" aria-label="Close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="card-body">
                                                    <div id="example-form">
                                                        <h3>General Information</h3>
                                                        <h6 class="h-0 m-0">&nbsp;</h6>
                                                        <div class="row gutters">
                                                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">

                                                                <div class="field-wrapper">
                                                                    <div class="input-group">
                                                                        <input type="text" class="form-control" value="'.$product->barcode.'" placeholder="Set Barcode" name="barcode" required>
                                                                    </div>
                                                                    <div class="field-placeholder">Barcode</div>
                                                                </div>

                                                            </div>
                                                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">

                                                                <div class="field-wrapper">
                                                                    <input type="text" placeholder="Enetr Product Name" value="'.$product->product_name.'" name="product_name" required>
                                                                    <div class="field-placeholder">Product Name</div>
                                                                </div>

                                                            </div>
                                                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">

                                                                <div class="field-wrapper">
                                                                    <div class="input-group">
                                                                        <input type="text" class="form-control" value="'.$product->buying_price.'" placeholder="Set Buying Price" name="buying_price" required>
                                                                        <span class="input-group-text">Ksh</span>
                                                                    </div>
                                                                    <div class="field-placeholder">Buying Price</div>
                                                                </div>

                                                            </div>
                                                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">

                                                                <div class="field-wrapper">
                                                                    <div class="input-group">
                                                                        <input type="text" class="form-control" value="'.$product->selling_price.'" placeholder="Set Selling Price" name="selling_price" required>
                                                                        <span class="input-group-text">Ksh</span>
                                                                    </div>
                                                                    <div class="field-placeholder">Selling Price</div>
                                                                </div>

                                                            </div>
                                                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">

                                                                        <div class="field-wrapper">
                                                                            <div class="input-group">
                                                                                <input type="text" class="form-control" value="'.$product->quantity.'" placeholder="Quantity" name="quantity">
                                                                            </div>
                                                                            <div class="field-placeholder">Quantity(Incomplete Park)</div>
                                                                        </div>

                                                                    </div>
                                                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">

                                                                        <div class="field-wrapper">
                                                                            <div class="input-group">
                                                                                <input type="text" class="form-control" value="'.$product->quantity_of_pack.'" placeholder="Quantity in pack" name="quantity_of_pack">
                                                                            </div>
                                                                            <div class="field-placeholder">Quantity in pack</div>
                                                                        </div>

                                                                    </div>
                                                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">

                                                                        <div class="field-wrapper">
                                                                            <div class="input-group">
                                                                                <input type="text" class="form-control" value="'.$product->number_of_pack.'" placeholder="Pack No:" name="number_of_pack">
                                                                            </div>
                                                                            <div class="field-placeholder">Pack Number</div>
                                                                        </div>

                                                                    </div>

                                                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">

                                                                <div class="field-wrapper">
                                                                    <div class="input-group">
                                                                        <input type="date" value="'.$product->date.'" class="form-control" name="date">
                                                                    </div>
                                                                    <div class="field-placeholder">Date</div>
                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>
                                            </div>
        ';
        return response($output);
    }
    public function deleteStock(Request $request){
        $output = "";
        $stockId = Stock::find($request->id);
        $output = '
            <input type="hidden" value="'.$stockId->id.'" name="stockId">
            <div class="modal-title h4">ARE YOU SURE</div> <button type="button" class="btn-close" aria-label="Close" data-bs-dismiss="modal"></button>

        ';
        return response($output);
    }
    public function deleteHotelStock(Request $request){
        $output = "";
        $stockId = Hotelstock::find($request->id);
        $output = '
            <input type="hidden" value="'.$stockId->id.'" name="stockId">
            <div class="modal-title h4">ARE YOU SURE</div> <button type="button" class="btn-close" aria-label="Close" data-bs-dismiss="modal"></button>

        ';
        return response($output);
    }
    public function dStock(Request $request){
        $delete = Stock::find($request->stockId);
        $delete->delete();
        return redirect()->back()->with('success','PRODUCT DELETED SUCCESS');
    }
    public function dHotelStock(Request $request){
        $delete = Hotelstock::find($request->stockId);
        $delete->delete();
        return redirect()->back()->with('success','PRODUCT DELETED SUCCESS');
    }
    public function sellStock(Request $request){
        $getProduct = Stock::find($request->id);
        $date = Carbon::now()->format('Y-m-d');
        $getQua = Sell::where('barcode',$getProduct->barcode)->first();
        if (is_null($getQua)){
            $sell = new Sell();
            $sell->barcode = $getProduct->barcode;
            $sell->product_name = $getProduct->product_name;
            $sell->quantity = 1;
            $sell->selling_price = $getProduct->selling_price;
            $sell->total = $getProduct->selling_price;
            $sell->date = $date;
            $sell->discount = 0;
            $sell->discount_percentage = 0;
            $sell->image = $getProduct->image;
            $sell->save();
            $prev = $getProduct->quantity;
            $stockQuantity = $prev-1;
            $updateStock = Stock::where('id',$request->id)->update(['quantity'=>$stockQuantity]);
        }
        else{
            $getQuantity = Sell::where('barcode',$getProduct->barcode)->first();
            $currentQuantity = $getQuantity->quantity + 1;
            $currentTotal = $getQuantity->selling_price*$currentQuantity;
            $updateQuantity = Sell::where('barcode',$getProduct->barcode)->update(['quantity'=>$currentQuantity]);
            $updateTotal = Sell::where('barcode',$getProduct->barcode)->update(['total'=>$currentTotal]);
            $prev = $getProduct->quantity;
            $stockQuantity = $prev-1;
            $updateStock = Stock::where('id',$request->id)->update(['quantity'=>$stockQuantity]);
        }

    }
    public function sellHotelStock(Request $request){
        $getProduct = Hotelstock::find($request->id);
        $getTakeAwayStock = Hotelstock::where('barcode',$getProduct->barcodeOne)->first();
        if (!is_null($getTakeAwayStock)){
            $current = $getTakeAwayStock->quantity;
            $selling = $getProduct->fixed;
            $stockQ = $current-$selling;
        }
        $date = Carbon::now()->format('Y-m-d');
        $getQua = sellHotel::where('barcode',$getProduct->barcode)->first();
            if (is_null($getQua)){
                    $sell = new sellHotel();
                $sell->barcode = $getProduct->barcode;
                $sell->product_name = $getProduct->product_name;
                $sell->quantity = 1;
                $sell->selling_price = $getProduct->selling_price;
                $sell->total = $getProduct->selling_price;
                $sell->date = $date;
                $sell->image = $getProduct->image;
                $sell->save();
                $prev = $getProduct->quantity;
                if (!is_null($getProduct->quantity_of_pack)){
                    $packNo = $getProduct->number_of_pack;
                    $qOfPack = $getProduct->quantity_of_pack;
                    $quant = $getProduct->quantity;
                    $totalQuant = $packNo*$qOfPack+$quant;
                    $afterTotalQuant = $totalQuant-1;
                    $noOfPack = intdiv($afterTotalQuant,$qOfPack);
                    $stockQuantity = $afterTotalQuant%$qOfPack;
                    $stockQuant = Hotelstock::where('id',$request->id)->update(['quantity'=>$stockQuantity]);
                    $updatePackNo = Hotelstock::where('id',$request->id)->update(['number_of_pack'=>$noOfPack]);

                }
                else{
                    $stockQuantity = $prev-1;
                    $updateStock = Hotelstock::where('id',$request->id)->update(['quantity'=>$stockQuantity]);
                }

                if (!is_null($getTakeAwayStock)) {
                    $updateS = Hotelstock::where('id', $getTakeAwayStock->id)->update(['quantity' => $stockQ]);
                }

            }
            else{
                $getQuantity = sellHotel::where('barcode',$getProduct->barcode)->first();
                $currentQuantity = $getQuantity->quantity + 1;
                $currentTotal = $getQuantity->selling_price*$currentQuantity;
                $updateQuantity = sellHotel::where('barcode',$getProduct->barcode)->update(['quantity'=>$currentQuantity]);
                $updateTotal = sellHotel::where('barcode',$getProduct->barcode)->update(['total'=>$currentTotal]);
                $prev = $getProduct->quantity;
                if (!is_null($getProduct->quantity_of_pack)){
                    $packNo = $getProduct->number_of_pack;
                    $qOfPack = $getProduct->quantity_of_pack;
                    $quant = $getProduct->quantity;
                    $totalQuant = $packNo*$qOfPack+$quant;
                    $afterTotalQuant = $totalQuant-1;
                    $noOfPack = intdiv($afterTotalQuant,$qOfPack);
                    $stockQuantity = $afterTotalQuant%$qOfPack;
                    $stockQuant = Hotelstock::where('id',$request->id)->update(['quantity'=>$stockQuantity]);
                    $updatePackNo = Hotelstock::where('id',$request->id)->update(['number_of_pack'=>$noOfPack]);

                }
                else{
                    $stockQuantity = $prev-1;
                    $updateStock = Hotelstock::where('id',$request->id)->update(['quantity'=>$stockQuantity]);
                }

                if (!is_null($getTakeAwayStock)) {
                    $updateS = Hotelstock::where('id', $getTakeAwayStock->id)->update(['quantity' => $stockQ]);
                }
            }

    }
    public function add(Request $request){
        $add = Sell::find($request->id);
        $getProduct = Stock::where('barcode',$add->barcode)->first();
        $quant = $add->quantity;
        $currentQuantity = $quant+1;
        $currentTotal = $add->selling_price*$currentQuantity;
        $update = Sell::where('id',$add->id)->update(['quantity'=>$currentQuantity]);
        $updateTotal = Sell::where('barcode',$add->barcode)->update(['total'=>$currentTotal]);
        $prev = $getProduct->quantity;
        $stockQuantity = $prev-1;
        $updateStock = Stock::where('barcode',$add->barcode)->update(['quantity'=>$stockQuantity]);
        $getQ = Sell::where('barcode',$add->barcode)->first();
        $originalSellingPrice = $getProduct->selling_price;
        $sellingPrice = $add->selling_price;
        $dis = $originalSellingPrice - $sellingPrice;
        $cal = $dis/$originalSellingPrice;
        $discount = $dis*$getQ->quantity;
        $percentage = $cal*100;
        $updateDiscount = Sell::where('id',$add->id)->update(['discount'=>$discount]);
        $updatePercentage = Sell::where('id',$add->id)->update(['discount_percentage'=>$percentage]);


    }
    public function addHotel(Request $request){
        $add = sellHotel::find($request->id);
        $stock = Hotelstock::where('barcode',$add->barcode)->first();
        $getTakeAwayStock = Hotelstock::where('barcode',$stock->barcodeOne)->first();
        if (!is_null($getTakeAwayStock)){
            $current = $getTakeAwayStock->quantity;
            $selling = $stock->fixed;
            $stockQ = $current-$selling;
        }
            $getProduct = Hotelstock::where('barcode',$add->barcode)->first();
            $quant = $add->quantity;
            $currentQuantity = $quant+1;
            $currentTotal = $add->selling_price*$currentQuantity;
            $update = sellHotel::where('id',$add->id)->update(['quantity'=>$currentQuantity]);
            $updateTotal = sellHotel::where('barcode',$add->barcode)->update(['total'=>$currentTotal]);
            $prev = $getProduct->quantity;
        if (!is_null($getProduct->quantity_of_pack)){
            $packNo = $getProduct->number_of_pack;
            $qOfPack = $getProduct->quantity_of_pack;
            $quant = $getProduct->quantity;
            $totalQuant = $packNo*$qOfPack+$quant;
            $afterTotalQuant = $totalQuant-1;
            $noOfPack = intdiv($afterTotalQuant,$qOfPack);
            $stockQuantity = $afterTotalQuant%$qOfPack;
            $stockQuant = Hotelstock::where('id',$getProduct->id)->update(['quantity'=>$stockQuantity]);
            $updatePackNo = Hotelstock::where('id',$getProduct->id)->update(['number_of_pack'=>$noOfPack]);

        }
        else{
            $stockQuantity = $prev-1;
            $updateStock = Hotelstock::where('barcode',$add->barcode)->update(['quantity'=>$stockQuantity]);
        }

        if (!is_null($getTakeAwayStock)) {
            $updateS = Hotelstock::where('id', $getTakeAwayStock->id)->update(['quantity' => $stockQ]);
        }


    }
    public function minus(Request $request){
        $minus = Sell::find($request->id);
        $getProduct = Stock::where('barcode',$minus->barcode)->first();
        $quant = $minus->quantity;
        $currentQuantity = $quant-1;
        $currentTotal = $minus->selling_price*$currentQuantity;
        if ($currentQuantity>0){
            $update = Sell::where('id',$minus->id)->update(['quantity'=>$currentQuantity]);
            $updateTotal = Sell::where('barcode',$minus->barcode)->update(['total'=>$currentTotal]);
            $prev = $getProduct->quantity;
            $stockQuantity = $prev+1;
            $updateStock = Stock::where('barcode',$minus->barcode)->update(['quantity'=>$stockQuantity]);
            $getQ = Sell::where('barcode',$minus->barcode)->first();
            $originalSellingPrice = $getProduct->selling_price;
            $sellingPrice = $minus->selling_price;
            $dis = $originalSellingPrice - $sellingPrice;
            $cal = $dis/$originalSellingPrice;
            $discount = $dis*$getQ->quantity;
            $percentage = $cal*100;
            $updateDiscount = Sell::where('id',$minus->id)->update(['discount'=>$discount]);
            $updatePercentage = Sell::where('id',$minus->id)->update(['discount_percentage'=>$percentage]);

        }
        else{
            $prev = $getProduct->quantity;
            $stockQuantity = $prev+1;
            $updateStock = Stock::where('barcode',$minus->barcode)->update(['quantity'=>$stockQuantity]);
            $minus->delete();
        }
    }
    public function minusHotel(Request $request){
        $minus = sellHotel::find($request->id);
        $getProduct = Hotelstock::where('barcode',$minus->barcode)->first();
            $quant = $minus->quantity;
            $currentQuantity = $quant-1;
            $currentTotal = $minus->selling_price*$currentQuantity;
        $getTakeAwayStock = Hotelstock::where('barcode',$getProduct->barcodeOne)->first();
        if (!is_null($getTakeAwayStock)){
            $current = $getTakeAwayStock->quantity;
            $selling = $getProduct->fixed;
            $stockQ = $current+$selling;
        }
            if ($currentQuantity>0){
                $update = sellHotel::where('id',$minus->id)->update(['quantity'=>$currentQuantity]);
                $updateTotal = sellHotel::where('barcode',$minus->barcode)->update(['total'=>$currentTotal]);
                $prev = $getProduct->quantity;
                if (!is_null($getProduct->quantity_of_pack)){
                    $packNo = $getProduct->number_of_pack;
                    $qOfPack = $getProduct->quantity_of_pack;
                    $quant = $getProduct->quantity;
                    $totalQuant = $packNo*$qOfPack+$quant;
                    $afterTotalQuant = $totalQuant+1;
                    $noOfPack = intdiv($afterTotalQuant,$qOfPack);
                    $stockQuantity = $afterTotalQuant%$qOfPack;
                    $stockQuant = Hotelstock::where('id',$getProduct->id)->update(['quantity'=>$stockQuantity]);
                    $updatePackNo = Hotelstock::where('id',$getProduct->id)->update(['number_of_pack'=>$noOfPack]);
                }
                else{
                    $stockQuantity = $prev+1;
                    $updateStock = Hotelstock::where('barcode',$minus->barcode)->update(['quantity'=>$stockQuantity]);
                }

                if (!is_null($getTakeAwayStock)) {
                    $updateS = Hotelstock::where('id', $getTakeAwayStock->id)->update(['quantity' => $stockQ]);
                }

            }
            else{
                $prev = $getProduct->quantity;
                if (!is_null($getProduct->quantity_of_pack)){
                    $packNo = $getProduct->number_of_pack;
                    $qOfPack = $getProduct->quantity_of_pack;
                    $quant = $getProduct->quantity;
                    $totalQuant = $packNo*$qOfPack+$quant;
                    $afterTotalQuant = $totalQuant+1;
                    $noOfPack = intdiv($afterTotalQuant,$qOfPack);
                    $stockQuantity = $afterTotalQuant%$qOfPack;
                    $stockQuant = Hotelstock::where('id',$getProduct->id)->update(['quantity'=>$stockQuantity]);
                    $updatePackNo = Hotelstock::where('id',$getProduct->id)->update(['number_of_pack'=>$noOfPack]);
                }
                else{
                    $stockQuantity = $prev+1;
                    $updateStock = Hotelstock::where('barcode',$minus->barcode)->update(['quantity'=>$stockQuantity]);
                }

                if (!is_null($getTakeAwayStock)) {
                    $updateS = Hotelstock::where('id', $getTakeAwayStock->id)->update(['quantity' => $stockQ]);
                }
                $minus->delete();
            }
    }
    public function del(Request $request){
        $delete = Sell::find($request->id);
        $getProduct = Stock::where('barcode',$delete->barcode)->first();
        $prev = $getProduct->quantity;
        $cur = $delete->quantity;
        $stockQuantity = $prev+$cur;
        $updateStock = Stock::where('barcode',$delete->barcode)->update(['quantity'=>$stockQuantity]);
        $delete->delete();
    }
    public function delHotel(Request $request){
        $delete = sellHotel::find($request->id);
        $stock = Hotelstock::where('barcode',$delete->barcode)->first();
        $getTakeAwayStock = Hotelstock::where('barcode',$stock->barcodeOne)->first();
        if (!is_null($getTakeAwayStock)){
            $current = $getTakeAwayStock->quantity;
            $selling = $stock->fixed*$delete->quantity;
            $stockQ = $current+$selling;
        }
        if ($stock->id==5||$stock->barcode=='0606'||$stock->barcode=='0702'){
            $delete = sellHotel::find($request->id);
            $getProduct = Hotelstock::where('barcode',$delete->barcode)->first();
            if (!is_null($getProduct->quantity_of_pack)){
                $packNo = $getProduct->number_of_pack;
                $qOfPack = $getProduct->quantity_of_pack;
                $quant = $getProduct->quantity;
                $totalQuant = $packNo*$qOfPack+$quant;
                $afterTotalQuant = $totalQuant+$delete->quantity;
                $noOfPack = intdiv($afterTotalQuant,$qOfPack);
                $stockQuantity = $afterTotalQuant%$qOfPack;
                $stockQuant = Hotelstock::where('id',$getProduct->id)->update(['quantity'=>$stockQuantity]);
                $updatePackNo = Hotelstock::where('id',$getProduct->id)->update(['number_of_pack'=>$noOfPack]);
            }
            if (!is_null($getTakeAwayStock)) {
                $updateS = Hotelstock::where('id', $getTakeAwayStock->id)->update(['quantity' => $stockQ]);
            }
            $delete->delete();
        }
        else{
            if (!is_null($getTakeAwayStock)) {
                $updateS = Hotelstock::where('id', $getTakeAwayStock->id)->update(['quantity' => $stockQ]);
            }
            $delete->delete();

        }
    }
    public function sales(Request $request){
        $output = "";
        $date = Carbon::now()->format('Y-m-d');
        $sells = Sell::all();
        $createOrder = Order::create([
           'phone'=>$request->phone,
            'payment_method'=>$request->paymentMethod,
            'date'=>$date,
        ]);
        foreach($sells as $sell){
            $getStock = Stock::where('barcode',$sell->barcode)->first();
            $buyingPrice = $getStock->buying_price;
            $sellingPrice = $sell->selling_price;
            $prof = $sellingPrice-$buyingPrice;
            $profit = $prof*$sell->quantity;
            $sales = new Sales();
            $sales->barcode = $sell->barcode;
            $sales->product_name = $sell->product_name;
            $sales->quantity = $sell->quantity;
            $sales->selling_price = $sell->selling_price;
            $sales->date = $date;
            $sales->total = $sell->total;
            $sales->image = $sell->image;
            $sales->profit = $profit;
            $sales->discount = $sell->discount;
            $sales->discount_percentage = $sell->discount_percentage;
            $sales->order_id = $createOrder->id;
            $sales->save();
            $sell->delete();
        }
        $receipts = Sales::where('order_id',$createOrder->id)->orderByDesc('id')->get();
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
    public function salesHotel(Request $request){
        $output = "";
        $date = Carbon::now()->format('Y-m-d');
        $sells = sellHotel::all();
        $createOrder = HotelOrder::create([
           'phone'=>$request->phone,
           'name'=>$request->name,
            'payment_method'=>$request->paymentMethod,
            'date'=>$date,
            'total'=>$sells->sum('total')
        ]);
        foreach($sells as $sell){
                $getStock = Hotelstock::where('barcode',$sell->barcode)->first();
            $buyingPrice = $getStock->buying_price;
            $sellingPrice = $sell->selling_price;
            $prof = $sellingPrice-$buyingPrice;
            $profit = $prof*$sell->quantity;
            $sales = new salesHotel();
            $sales->barcode = $sell->barcode;
            $sales->product_name = $sell->product_name;
            $sales->quantity = $sell->quantity;
            $sales->selling_price = $sell->selling_price;
            $sales->date = $date;
            $sales->total = $sell->total;
            $sales->image = $sell->image;
            $sales->profit = $profit;
            $sales->order_id = $createOrder->id;
            $sales->save();
            $sell->delete();
        }
        $receipts = salesHotel::where('order_id',$createOrder->id)->orderByDesc('id')->get();
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
    public function salesMeat(Request $request){
        $output = "";
        $date = Carbon::now()->format('Y-m-d');
        $createOrder = HotelOrder::create([
           'phone'=>$request->phone,
           'name'=>$request->name,
            'payment_method'=>$request->paymentMethod,
            'date'=>$date,
            'total'=>$request->meatAmount,
        ]);

            $getStock = Hotelstock::find($request->id);
            $currentQuantity = $getStock->quantity;
            $quantity = $request->quantity;
            $final = $currentQuantity-$quantity;
            $updateMeatQuantity =Hotelstock::where('id',$getStock->id)->update(['quantity'=>$final]);
            $sales = new salesHotel();
            $sales->barcode = $getStock->barcode;
            $sales->product_name = $getStock->product_name;
            $sales->quantity = $request->quantity;
            $sales->selling_price = $getStock->selling_price;
            $sales->date = $date;
            $sales->total = $request->meatAmount;
            $sales->image = $getStock->image;
            $sales->profit = $request->meatAmount;
            $sales->order_id = $createOrder->id;
            $sales->save();
        $receipts = salesHotel::where('order_id',$createOrder->id)->orderByDesc('id')->get();
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
    public function salesB(Request $request){
        $output = "";
        $date = Carbon::now()->format('Y-m-d');
        $createOrder = HotelOrder::create([
            'payment_method'=>$request->paymentMethod,
            'date'=>$date,
        ]);

            $getStock = Hotelstock::find($request->id);
            $getTakeAway = Hotelstock::where('barcode',$getStock->barcodeOne)->first();
            $currentQuantity = $getTakeAway->quantity;
            $quantity = $request->quantity;
            $final = $currentQuantity-$quantity;
            $updateMeatQuantity =Hotelstock::where('id',$getTakeAway->id)->update(['quantity'=>$final]);
            $sales = new salesHotel();
            $sales->barcode = $getStock->barcode;
            $sales->product_name = $getStock->product_name;
            $sales->quantity = $request->quantity;
            $sales->selling_price = 0;
            $sales->date = $date;
            $sales->total = 0;
            $sales->image = $getStock->image;
            $sales->profit = 0;
            $sales->order_id = $createOrder->id;
            $sales->save();
        $receipts = salesHotel::where('order_id',$createOrder->id)->orderByDesc('id')->get();
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
    public function totalTax(){
        $output = "";
        $output = '
        <tr class="tabletitle">
                                                        <td></td>
                                                        <td class="Rate"><h2>Total</h2></td>
                                                        <td class="payment"><h2>$3,644.25</h2></td>
                                                    </tr>
        ';
        return response($output);
    }
    public function highMovingproducts(){

        if (Auth::check()){
            $sales = Sales::where('date',Carbon::now()->format('Y-m-d'))->get()->unique('barcode');
            $hotels = salesHotel::where('date',Carbon::now()->format('Y-m-d'))->get()->unique('barcode');
            return view('admin.highlyMovingProducts',[
                'sales'=>$sales,
                'hotels'=>$hotels,
                'today'=>Carbon::now()->format('Y-m-d')
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
            $products  = Purchase::whereBetween('date', array($start_date, $end_date))->get();
            return view('admin.purchase',[
                'products'=>$products,
            ]);
        }
        else{
            $products  = Purchase::whereBetween('date', array($start_date, $end_date))->where('barcode',$request->productId)->get();
            return view('admin.purchase',[
                'products'=>$products,
            ]);
        }

    }
}
