<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\InputItem;


class IndexController extends Controller
{
  public function index()
  {
      $item = InputItem::where('is_deleted',0)->paginate(10);
      return view('welcome', compact('item'));
  }

  public function data(){
    try {
      $item = InputItem::all();
      return response()->json(['status' => true, 'description' => 200, 'data' => $item]);
    } catch (\Exception $e) {
      return response()
        ->json(['status' => false, 'description' => $e->getMessage()]);
    }
  }
}
