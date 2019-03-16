@extends('layouts.user')

@section('content')
<div class="container order">
  <div class="alert alert-primary" role="alert">
    Berikut daftar troli anda. Harap mengisi alamat anda !!!
  </div>
</div>

<div class="container">
  <div class="row">
    <div class="col-sm-12 col-lg-8 container">
      <table class="table table-striped">
        <tbody>
          @foreach($c as $detail)
          <tr>
            <td><img src="{{ asset('picture/inputitem/'.$detail->picture) }}" width='100px'/></td>
            <td><strong>{{ $detail->name }}</strong></td>
            <td>{{ $detail->qty }}</td>
            <td> Rp. {{ number_format($detail->price * $detail->qty) }}</td>
          </tr>
          @endforeach
          <tr>
            <td colspan="3">Total</td>
            <td colspan="1">Rp. {{ substr($total, 0, strlen($total)-3) }}</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</div>


<form id="addressdetail" class="container body">
  {{ csrf_field() }}
  <div class="row">
    <div class="col-sm-12 col-lg-10 container">
      <h2>Masukkan Alamat</h2>
      <div class="form-row">
        <div class="form-group col-md-3">
          <label for="province" class="col-form-label">Provinsi</label>
          <select id="province" name="province" class="form-control" onchange="changeProvince(this)">Choose
          <option value="0">-Pilih Propinsi-</option>
              @foreach ($province as $key)
                <option value="{{ $key->id }}">{{ $key->name }}</option>
              @endforeach
          </select>
        </div>
        <div class="form-group col-md-3">
          <label for="district" class="col-form-label">Kabupaten/Kota</label>
          <select id="district" name="district" class="form-control" onchange="changeDistrict(this)" disabled>Choose
          </select>
        </div>
        <div class="form-group col-md-3">
          <label for="sub-district" class="col-form-label">Kecamatan</label>
          <select id="subdistrict" name="subdistrict" class="form-control" onchange="changeSubDistrict(this)" disabled>Choose
          </select>
        </div>
        <div class="form-group col-md-3">
          <label for="village" class="col-form-label">Desa</label>
          <select id="village" name="village" class="form-control" disabled>Choose
          </select>
        </div>
      </div>
      <div class="form-group">
        <label for="inputAddress" class="col-form-label">Alamat pengantaran</label>
        <input  id="delivery" name="delivery" type="text" class="form-control" placeholder="Masukkan Alamat">
      </div>

      <div class="form-group">
        <label for="inputAddress" class="col-form-label">Alamat Penagihan</label>
        <input id="billing" name="billing" type="text" class="form-control" placeholder="1234 Main St">
      </div>
    </div>
  </div>
  <div class="col-sm-12 col-lg-10 container body">
    <button type="button" onclick="getDetail(this)" class="btn btn-primary btn-md" style="padding:10px;margin:10px;">Pesan</button>
  </div>
</form>

<div id="orderdetail" class="container body">

</div>
@endsection
@section('script')
  <script type="text/javascript">
  function changeProvince(obj){
    $.ajax({
      url: '/order/district',
      type: 'POST',
      data: {'_token': $('meta[name="csrf-token"]').attr('content'), 'id': $("#province").val()},
      success: function (data){
        if (data.status) {
          $("#district").removeAttr('disabled', 'disabled');
          $("#district").html(data.data);
        }
        else {
          console.log(data);
        }
      }
    },'json');
  }

  function changeDistrict(obj){
    $.ajax({
      url: '/order/subdistrict',
      type: 'POST',
      data: {'_token': $('meta[name="csrf-token"]').attr('content'), 'id': $("#district").val()},
      success: function (data){
        if (data.status) {
          $("#subdistrict").removeAttr('disabled', 'disabled');
          $("#subdistrict").html(data.data);
        }
        else {
          console.log(data);
        }
      }
    },'json');
  }

  function changeSubDistrict(obj){
    $.ajax({
      url: '/order/village',
      type: 'POST',
      data: {'_token': $('meta[name="csrf-token"]').attr('content'), 'id': $("#subdistrict").val()},
      success: function (data){
        if (data.status) {
          $("#village").removeAttr('disabled', 'disabled');
          $("#village").html(data.data);
        }
        else {
          console.log(data);
        }
      }
    },'json');
  }

  function getDetail(){
    $.ajax({
      url: 'order/getdetail',
      type: 'POST',
      data: $("#addressdetail").serialize(),
      success: function (data){
        if (data.status) {
          $("#orderdetail").html(data.data);
        }
        else {
          console.log(data);
        }
      }
    },'json');
  }

  function send(){
    $.ajax({
      url: 'order/store',
      type: 'post',
      data: $("#addressdetail").serialize(),
      success: function (data){
        if (data.status) {
          window.location.href = '/dashboard?orderfinished=true';
        }
        else {
          console.log(data);
        }
      }
    },'json');
  }
  </script>
@endsection
