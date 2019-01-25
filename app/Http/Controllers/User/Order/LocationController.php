<?php

namespace App\Http\Controllers\User\Order;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\InfLokasi;

class LocationController extends Controller
{
    public function select($request)
    {
      $location = InfLokasi::->where('lokasi_propinsi', )
    }
}
