<?php

namespace App\Http\Admin\Gallon;

use App\Http\Controller\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;
use App\Gallon;
use App\User;


class GallonController extends Controller
{

    public function __construct(){
      $this->middleware('auth');
    }

    public function index(){
        return view('');
    }

    public function store(Request $request){
      $validator = Validator::make($request->all(), [
        'qty_in' => 'required'|'numeric'|,
        'qty_out' => 'required|numeric|',
        'qty_remains' => 'required'|'numeric'|,
        'is_debt' => 'required'|'numeric'|,
        'debt' => 'required'|'numeric'|,
        'date' => 'required'|'date'|,
      ]);
      if ($validator -> passes()) {
        $gallon = new Gallon;
        $gallon->qty_in = $request->qty_in;
        $gallon->qty_out = $request->qty_out;
        $gallon->qty_remains =+ $gallon->qty_in - $gallon->qty_out;
        $gallon->is_debt = $request->is_debt;
        $gallon->debt = $request->debt;
        $gallon->date = $request->date;
      }

    }
}
