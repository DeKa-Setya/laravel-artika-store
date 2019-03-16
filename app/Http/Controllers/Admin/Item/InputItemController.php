<?php

namespace App\Http\Controllers\Admin\Item;
use Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\DataTables;
use App\InputItem;
use App\Tools\Slim;

class InputItemController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
          $item = InputItem::all();

          return DataTables::of($item)
          ->editColumn('picture', function($item){
            return '<img src="'. asset('picture/inputitem/'.$item->picture, false) .'"></img>';
          })
            ->addColumn('action', function($item){
              return '<div class="btn-group btn-group-sm" role="group" aria-label="First Group">' .
                '<button onclick="showDetail(\''.json_encode($item).'\')" class="btn btn-light"><i class="fa fa-eye"></i>Show</button>' .
                '<button onclick="openPopup('. json_encode($item) .')" class="btn btn-light"><i class="fa fa-edit"></i>Edit</button>' .
                '<button onclick="delete('. json_encode($item) .')" class="btn btn-light"><i class="mdi mdi-delete-empty"></i>Delete</button>' .
                '</div>';
            })
            ->rawColumns(['action', 'picture'])
            ->make(true);
        }
        else {
          $item = InputItem::orderBy('id', 'DESC')->paginate(5);
          return view('admin.input.index', compact('item'));
        }

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
          'name' => 'required',
          'price' => 'required|numeric|',
          'description' => 'required',
          'qty' => 'numeric',
        ]);



        if($validator->passes()) {
          //$imageName = time().'.'.$request->picture->getClientOriginalExtension();
          //$request->picture->move(public_path('picture/inputitem'), $input->picture);

          $image = Slim::getImages('picture')[0];

          if (isset($image['output']['data'])) {
            // Save the file
            $name = $image['output']['name'];

            // We'll use the output crop data
            $data = $image['output']['data'];
            $output = Slim::saveFile($data, $name, './picture/inputitem');

            $item = new InputItem;
            $item->name = $request->name;
            $item->price = $request->price;
            $item->qty = $request->qty;
            $item->description = $request->description;
            $item->picture = $output['name'];
            $item->save();
          }

          return response()->json(['status'=>true, 'description' => 'Success']);
        }
        else{
          return response()->json(['error'=>$validator->errors()->all()]);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $item = InputItem::findOrFail($id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $item = InputItem::findOrFail($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      $item = InputItem::findOrFail($id);
      $item->is_deleted += 1;
      return redirect()->route('admin.inputitem.index')->with('message', 'berhasil dihapus !');
    }
}
