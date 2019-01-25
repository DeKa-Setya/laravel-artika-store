<?php

namespace App\Http\Controllers\User\Order;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Gloudemans\Shoppingcart\Cart;
use Illuminate\Support\Collection;
use App\Http\Controllers\Controller;
use App\Sale;
use App\SalesDetail;
use Indonesia;

class OrderController extends Controller
{

  public function __construct()
  {
      $this->middleware('auth');
      $this->middleware('user');
  }


    public function index(Request $request, Cart $cart)
    {
        $province = Indonesia::allProvinces();
// dd($province,$district,$subdistrict,$village);
        $c = $cart->content();
        $total = $cart->total();
        return view('user.order.index', compact('c', 'total', 'province'));
    }

    public function getDistrict(Request $request)
    {
        try {
          $temp = Indonesia :: findProvince($request->id, [ 'cities' ]);
          $district = $temp->cities;
          $html = "";
          foreach ($district as $key) {
              $html .= "<option value='". $key->id ."'> ". $key->name ."</option>";
          }
          return response()
            ->json(['status' => true, 'description' => 'Berhasil pilih kecamatan !', 'data' => $html]);

        } catch (\Exception $e) {
          return response()
            ->json(['status' => false, 'description' => $e->getMessage()]);
        }

    }

    public function getSubDistrict(Request $request)
    {
        try {
          $temp = Indonesia :: findCity($request->id, [ 'districts' ]);
          $subdistrict = $temp->districts;
          $html = "";
          foreach ($subdistrict as $subdistricts) {
              $html .= "<option value='". $subdistricts->id ."'> ". $subdistricts->name ."</option>";
          }
          return response()
            ->json(['status' => true, 'description' => 'done !', 'data' => $html]);

        } catch (\Exception $e) {
          return response()
            ->json(['status' => false, 'description' => $e->getMessage()]);
        }

    }

    public function getVillage(Request $request)
    {
        try {
          $temp = Indonesia :: findDistrict($request->id, [ 'villages' ]);
         $village = $temp->villages;
          $html = "";
          foreach ($village as $key) {
              $html .= "<option value='". $key->id ."'> ". $key->name ."</option>";
          }
          return response()
            ->json(['status' => true, 'description' => 'done !', 'data' => $html]);

        } catch (\Exception $e) {
          return response()
            ->json(['status' => false, 'description' => $e->getMessage()]);
        }

    }


    public function store(Request $request, Cart $cart)
    {
        try {
          $c = $cart->content();
          $sale = new Sale;
          $orderdetail = new SalesDetail;

          $record = Sale::orderBy('id', 'desc')->first();

          if (empty($record)) {
            $firstNumber = 0001;
            $salescode = date('ymd').$firstNumber;
          }
          else {
            $yymmdd = substr($record->sales_code, 0,6);

            if ($yymmdd == date('ymd')) {
              $last      = substr($record->sales_code,6,strlen($record->sales_code)-1);
              (int)$last;
              $last += 1;
              $salescode = date('ymd') . $last;
            }
            else {
              $firstNumber = 0001;
              $salescode = date('ymd').$firstNumber;
            }
          }

          $sale->user_id = Auth::id();
          $sale->sales_code = $salescode;
          $sale->delivery_address = $request->delivery;
          $sale->billing_address = $request->billing;
          $sale->total = $cart->total();
          $sale->save();

          foreach ($c as $key) {
              $orderdetail->sales_id  = $sale->id;
              $orderdetail->sales_code = $salescode;
              $orderdetail->item_id = $key->id;
              $orderdetail->qty = $key->qty;
              $orderdetail->price = $key->price;
              $orderdetail->save();
          }

          return response()
            ->json(['status' => true, 'description' => 'Kuantitas berhasil ditambah!']);


        } catch (\Exception $e) {
          return response()
            ->json(['status' => false, 'description' => $e->getMessage()]);
        }


    }

    public function destroy()
    {

    }
}
