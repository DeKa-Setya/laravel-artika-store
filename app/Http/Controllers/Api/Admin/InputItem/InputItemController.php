<?php

namespace App\Http\Controllers\Api\Admin\InputItem;

use App\User;
use App\InputItem;
use Illuminate\Http\Request;
use Validator;
use App\Http\Controllers\Controller;

class InputItemController extends Controller
{

  public function __construct()
  {
      $this->middleware('token');
  }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
          'name' => 'required',
          'price' => 'required',
          'description' => 'required',
          'picture' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        if($validator->passes()) {
          $input = $request->all();
          $input['picture'] = time().'.'.$request->picture->getClientOriginalExtension();
          $request->picture->move(public_path('picture/inputitem'), $input['picture']);

          InputItem::create($input);
          return response()->json(['success'=>'Berhasil']);
        }

        return response()->json(['error'=>$validator->errors()->all()]);
    }

    public function showAllData(){
        $item = InputItem::all();
        return response()->json(['status' => true, 'description' => 200, 'data' => $item]);
    }
}
