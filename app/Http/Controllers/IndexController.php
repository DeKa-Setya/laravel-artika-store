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
}
