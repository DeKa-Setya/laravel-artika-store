<?php

namespace App\Http\Controllers\Admin\OrderList;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Sale;
use App\SalesDetail;
use App\inputitem;
use App\User;

class OrderListController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

     public function __construct()
     {
         $this->middleware('auth');
         $this->middleware('admin');
     }

    public function index()
    {
        
        $item = Sale::orderBy('id', 'DESC')->paginate(10);
        foreach ($item as $sls){
          $user = User::where('id', $sls->user_id)->first();
          $sls->user = $user->name;
          $detail = SalesDetail::where('sales_code', $sls->sales_code)->orderBy('created_at', 'DESC')->get();
            foreach ($detail as $details) {
              $sls->product_qty = $details->qty;
              $sls->product_price = $details->price;
              $product = InputItem::where('id', $details->item_id)->get();

              }
                foreach ($product as $key) {
                  $sls->photo = $key->picture;
                  $sls->product_name = $key->name;
                }
            }

        return view('admin.orderlist.index',compact('item','detail'));
      }

  public function accept(Request $request)
  {
      $info = Sale::where('id', $request->id)->first();
      $info->update(['status' => 1]);
      return response()->json(['status'=> true, 'message' => 'status berubah !']);
  }

  public function decline(Request $request)
  {
      $info = Sale::where('id', $request->id)->first();
      $info->update(['status' => 2]);

  }
}
