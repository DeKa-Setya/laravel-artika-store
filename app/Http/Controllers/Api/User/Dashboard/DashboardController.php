<?php

namespace App\Http\Controllers\Api\User\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\InputItem;

class DashboardController extends Controller
{

  public function __construct()
  {
      $this->middleware('token');
  }

    public function index()
    {
      try {
        $item = InputItem::all();
        return response()->json(['status' => true, 'description' => 200, 'data' => $item]);
      } catch (\Exception $e) {
        return response()
          ->json(['status' => false, 'description' => $e->getMessage()]);
      }
    }
}
