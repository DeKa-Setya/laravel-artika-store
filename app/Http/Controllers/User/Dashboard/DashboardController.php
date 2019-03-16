<?php

namespace App\Http\Controllers\User\Dashboard;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Gloudemans\Shoppingcart\Cart;
use App\Http\Controllers\Controller;
use App\InputItem;


class DashboardController extends Controller
{
  public function __construct()
  {
      $this->middleware('auth');
      $this->middleware('user');
  }

  public function index()
  {
      $item = InputItem::where('is_deleted',0)->paginate(10);

      if (isset($_GET['orderfinished=true'])){
        return view('user.dashboard.index', compact('item'))->with('message', 'Order Has Been Proceed');
      }
      else{
        return view('user.dashboard.index', compact('item'));
      }
  }

  public function store(Request $request, Cart $cart){
    $inputitem = InputItem::where('id',$request->id)->first();
    if(empty($inputitem)){
      return response()
        ->json(['status' => false, 'description' => 'Tidak Ada !']);
    }

    else {
      if ($inputitem->qty > 0) {
        $cart->add([
          'id' => $inputitem->id,
          'name' => $inputitem->name,
          'picture' => $inputitem->picture,
          'qty' => 1,
          'price' => $inputitem->price
        ]);


      }
      else {
        return response()
          ->json(['status' => false, 'description' => 'stok'.$inputitem->name.'kosong !']);
      }

      return response()
        ->json(['status' => true, 'description' => 'success']);
    }

  }

  public function fetch(Cart $cart)
  {
      $c = $cart->content();
      if ($cart->count() == 0) {
        $html = "";
      }
      else {
        $i = 1;
        $html = "<div class='row'>";
          $html .= "<div class='col-12 col-sm-12'>";
            $html .= "<table class='table table-striped'>";
              $html .= "<tbody>";
                foreach ($c as $key) {
                  $html .= "<tr>";
                    $html .= "<td><a href='javascript:void(0)' onclick='removeItem(\"".$key->rowId."\")' class='text-danger'>&times;</a></td>";
                    $html .= "<td class='image-item'><img src='". asset("picture/inputitem/".$key->picture) ."'/></td>";
                    $html .= "<td><strong>".$key->name."</strong></td>";
                    $html .= "<td>";
                    $html .= "<div class='btn-group btn-group-sm' role='group' aria-label='First Group'>";
                    $html .= "<button type='button' class='btn btn-secondary' onclick='removeQty(\"".$key->rowId."\")'>-</button>";
                    $html .= "<button type='button' class='btn btn-secondary disabled'>$key->qty</button>";
                    $html .= "<button type='button' class='btn btn-secondary' onclick='addQty(\"".$key->rowId."\")'>+</button>";
                    $html .= "</div>";
                    $html .="</td>";
                    $html .= "<td>Rp ".number_format($key->price * $key->qty)."</td>";
                  $html .= "</tr>";
                }
              $html .= "</tbody>";
            $html .= "</table>";
          $html .= "</div>";
        $html .= "</div>";

        return $html;
      }
  }

  public function destroy(Request $request, Cart $cart)
  {
    try {

      $rowId = $request->id;
      $cart->get($rowId);
      $cart->remove($rowId);

      return response()
        ->json(['status' => true, 'description' => 'success']);

    } catch (\Exception $e) {
      return response()
        ->json(['status' => false, 'description' => $e->getMessage()]);
    }

  }

  public function add(Request $request,Cart $cart)
  {
    try {

      $c = $cart->get($request->id);

      $inputitem = InputItem::where('id',$c->id)->first();
      if ($inputitem->qty == 0) {
        return response()
          ->json(['status' => false, 'description' => 'Stok kosong!']);
      }
      else {
        $c->qty += 1;

        return response()
          ->json(['status' => true, 'description' => 'Kuantitas berhasil ditambah!']);
      }

    } catch (\Exception $e) {
      return response()
        ->json(['status' => false, 'description' => $e->getMessage()]);
    }

  }

  public function remove(Request $request,Cart $cart)
  {
    try {

      $c = $cart->get($request->id);

      $inputitem = InputItem::where('id',$c->id)->first();

      if ($c->qty == 1) {
        return response()
          ->json(['status' => false, 'description' => 'Kuantitas harus lebih besar dari 1']);
      }
      else {
        $c->qty -= 1;

        return response()
          ->json(['status' => true, 'description' => 'Kuantitas berhasil dikurang']);
      }


    } catch (\Exception $e) {
      return response()
        ->json(['status' => false, 'description' => $e->getMessage()]);
    }

  }

}
