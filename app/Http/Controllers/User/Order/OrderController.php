<?php

namespace App\Http\Controllers\User\Order;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Gloudemans\Shoppingcart\Cart;
use Illuminate\Support\Collection;
use App\Http\Controllers\Controller;
use App\Sale;
use App\SalesDetail;
use App\InputItem;
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
          $html .= "<option value=''>-Pilih Kabupaten/Kota-</option>";
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
          $html .= "<option value=''>-Pilih Kecamatan-</option>";
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
          $html .= "<option value=''>-Pilih Desa-</option>";
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
          $TempTotal = $cart->total();
          $total = (double)$TempTotal;


          $record = Sale::orderBy('id', 'desc')->first();

          $tempProvince = Indonesia :: findProvince($request->province);
          $tempDistrict = Indonesia :: findCity($request->district);
          $tempSubDistrict = Indonesia :: findDistrict($request->subdistrict);
          $tempVillage = Indonesia :: findVillage($request->village);
          $provinces = $tempProvince->name;
          $districts = $tempDistrict->name;
          $subdistricts = $tempSubDistrict->name;
          $villages = $tempVillage->name;

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
          $sale->delivery_address = $request->delivery." Desa ".$villages.", Kecamatan ".$subdistricts.", ".$districts.", ".$provinces;
          $sale->billing_address = $request->billing." Desa ".$villages.", Kecamatan ".$subdistricts.", ".$districts.",".$provinces;
          $sale->total = $total;
          $sale->save();

            foreach ($c as $key) {
                $orderdetail = new SalesDetail;
                $inputitem = InputItem::where('id',$key->id)->first();
                $orderdetail->sale_id  = $sale->id;
                $orderdetail->item_id = $key->id;
                $orderdetail->sales_code = $salescode;
                $orderdetail->qty = $key->qty;
                $inputitem->qty -= $key->qty;
                $orderdetail->price = $key->price;
                $orderdetail->save();
                $inputitem->save();
            }

          $cart->destroy();

          return response()
            ->json(['status' => true, 'description' => 'Pesanan Sukses !']);



        } catch (\Exception $e) {
          return response()
            ->json(['status' => false, 'description' => $e->getMessage()]);
        }
    }

    public function getdetail(Request $request, Cart $cart)
    {
      try {
        $c = $cart->content();
        $total = $cart->total();
        $tempProvince = Indonesia :: findProvince($request->province);
        $tempDistrict = Indonesia :: findCity($request->district);
        $tempSubDistrict = Indonesia :: findDistrict($request->subdistrict);
        $tempVillage = Indonesia :: findVillage($request->village);
        $province = $tempProvince->name;
        $district = $tempDistrict->name;
        $subdistrict = $tempSubDistrict->name;
        $village = $tempVillage->name;

        $html = "";
        $html .= "<div class='row container'>";
        $html .= "<h3 class='header'>Rincian Pesanan</h3>";
        $html .= "<div class='col-sm-12 col-lg-8 container'>";
        $html .= "<table>";
        $html .= "<tr>";
        $html .= "<td class='down'><b>Alamat Lengkap</b></td>";
        $html .= "</tr>";
        $html .= "<tr>";
        $html .= "<td class='down'>$request->delivery Desa $village, Kecamatan $subdistrict, $district, $province</td>";
        $html .= "</tr>";
        $html .= "<tr>";
        $html .= "<td class='down'><b>Alamat Penagihan</b></td>";
        $html .= "</tr>";
        $html .= "<tr>";
        $html .= "<td class='down'>$request->billing Desa $village, Kecamatan $subdistrict, $district, $province</td>";
        $html .= "</tr>";
        $html .= "</table>";
        $html .= "<table class='table table-striped'>";
        $html .= "<tbody>";
        $html .= "<tr>";
        $html .= "<td class='header'><b>Rincian Pesanan</b></td>";
        $html .= "</tr>";

        foreach ($c as $key){
          $html .= "<tr>";
          $html .= "<td width='100px'><img src='". asset("picture/inputitem/".$key->picture) ."' width='100px'/></td>";
          $html .= "<td><strong>$key->name</strong></td>";
          $html .= "<td>$key->qty</td>";
          $html .= "<td> Rp.".number_format($key->price * $key->qty)."</td>";
          $html .= "</tr>";
        }


        $html .= "<tr>";
        $html .= "<td colspan='3'>Total Belanja</td>";
        $html .= "<td colspan='1'> Rp." .substr($total, 0, strlen($total)-3). "</td>";
        $html .= "</tr>";
        $html .= "<tr>";
        $html .= "<td colspan='3'>Biaya Kirim</td>";
        $html .= "<td colspan='1'>Rp." .substr($total, 0, strlen($total)-3)."</td>";
        $html .= "</tr>";
        $html .= "<tr>";
        $html .= "<td colspan='3'>Total Pembayaran</td>";
        $html .= "<td colspan='1'>Rp." .substr($total, 0, strlen($total)-3)."</td>";
        $html .= "</tr>";
        $html .= "</tbody>";
        $html .= "</table>";
        $html .= "</div>";
        $html .= "<div class='col-sm-12 col-lg-10 container body'>";
        $html .= "<button type='button' onclick='send()' class='btn btn-primary btn-md' style='float:right;padding:10px;margin:10px;'>Pesan</button>";
        $html .= "<button type='button' class='btn btn-secondary btn-md' style='float:right;padding:10px;margin:10px;'>Batal</button>";
        $html .= "</div>";
        $html .="</div>";

        return response()
          ->json(['status' => true, 'description' => 'done !!!', 'data'=> $html]);

      } catch (\Exception $e) {
        return response()
          ->json(['status' => false, 'description' => $e->getMessage()]);
      }

    }
}
