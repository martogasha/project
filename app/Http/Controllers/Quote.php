<?php

namespace App\Http\Controllers;

use App\Models\Quotation;
use App\Models\Stock;
use Illuminate\Http\Request;

class Quote extends Controller
{
    public function quotation(){
        $products = Stock::all();
        $quotations = Quotation::all();
        return view('admin.quotation',[
            'products'=>$products,
            'quotations'=>$quotations
        ]);
    }
    public function quote(Request $request){
        $stock = Stock::where('barcode',$request->id)->first();
        $sell = $stock->selling_price;
        $selling = $sell*1;
        $createQuote = Quotation::create([
           'barcode'=>$stock->barcode,
           'product_name'=>$stock->product_name,
           'selling_price'=>$stock->selling_price,
           'total'=>$selling,
           'quantity'=>1,
        ]);
    }
    public function editQuotation(Request $request){
        $output = "";
        $edit = Quotation::find($request->id);
        $output = '
<input type="hidden" value="'.$edit->id.'" name="qId">
 <div class="card-body">
                                                    <div id="example-form">
                                                        <h3>'.$edit->product_name.'</h3>
                                                        <h6 class="h-0 m-0">&nbsp;</h6>
        <div class="row gutters">

        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">

        <div class="field-wrapper">
            <input type="text" placeholder="Enetr Quantity" value="'.$edit->quantity.'" name="quantity" required>
            <div class="field-placeholder">Quanntity</div>
        </div>

    </div>
    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">

        <div class="field-wrapper">
            <input type="text" placeholder="Enetr Price" value="'.$edit->selling_price.'" name="price" required>
            <div class="field-placeholder">Price</div>
        </div>

    </div>
    </div>
    </div>
    </div>

        ';
        return response($output);
    }
    public function dQuotation(Request $request){
        $output = "";
        $edit = Quotation::find($request->id);
        $output = '
<input type="hidden" value="'.$edit->id.'" name="dQ">
        ';
        return response($output);
    }
    public function editQ(Request $request){
        $edit = Quotation::find($request->qId);
        $sell = $request->price;
        $selling = $sell*$request->quantity;
        $edit->selling_price = $request->price;
        $edit->quantity = $request->quantity;
        $edit->total = $selling;
        $edit->save();
        return redirect()->back();
    }
    public function startAgain(){
        $del = Quotation::where('id','>',0)->delete();
    }
    public function dQ(Request $request){
        $del = Quotation::where('id',$request->dQ)->delete();
        return redirect()->back();
    }
}
