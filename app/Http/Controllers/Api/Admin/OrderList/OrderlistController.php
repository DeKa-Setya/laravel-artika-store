<?php

namespace App\Http\Controllers\Api\Admin\OrderList;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Sale;
use App\SalesDetail;

class OrderlistController extends Controller
{

    public function __construct()
    {
        $this->middleware('token');
    }

      public function index()
      {
          $SaleData = Sale::all();
          $ItemInfo = SalesDetail::all();

          return response()->json(['status' => true, 'description' => 200, 'SaleData' => $SaleData, 'ItemInfo' => $ItemInfo]);
      }
}
