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


<form class="container body" action="{{ url('/order') }}" method="get">
  <div class="row">
    <div class="col-sm-12 col-lg-10 container">
      <h2>Masukkan Alamat</h2>
      <div class="form-row">
        <div class="form-group col-md-3">
          <label for="province" class="col-form-label">Provinsi</label>
          <select id="province" class="form-control" onchange="changeProvince(this)">Choose
          <option value="0">Pilih Propinsi</option>
              @foreach ($province as $key)
                <option value="{{ $key->id }}">{{ $key->name }}</option>
              @endforeach
          </select>
        </div>
        <div class="form-group col-md-3">
          <label for="district" class="col-form-label">Kabupaten/Kota</label>
          <select id="district" class="form-control" onchange="changeDistrict(this)" disabled>Choose
          </select>
        </div>
        <div class="form-group col-md-3">
          <label for="sub-district" class="col-form-label">Kecamatan</label>
          <select id="subdistrict" class="form-control" onchange="changeSubDistrict(this)" disabled>Choose
          </select>
        </div>
        <div class="form-group col-md-3">
          <label for="village" class="col-form-label">Desa</label>
          <select id="village" class="form-control" disabled>Choose
          </select>
        </div>
      </div>
      <div class="form-group">
        <label for="inputAddress" class="col-form-label">Alamat pengantaran</label>
        <input type="text" class="form-control" id="delivery" placeholder="Masukkan Alamat">
      </div>
      <div class="form-group col-md-2">
        <div class="form-check">
          <input class="form-check-input" type="checkbox" id="gridCheck">
          <label class="form-check-label" for="gridCheck">
            Jadikan alamat penagihan
          </label>
        </div>
      </div>
      <div class="form-group">
        <label for="inputAddress" class="col-form-label">Alamat Penagihan</label>
        <input type="text" class="form-control" id="billing" placeholder="1234 Main St">
      </div>
    </div>
  </div>
  <div class="col-sm-12 col-lg-10 container body">
    <button type="button" class="btn btn-primary btn-md" style="padding:10px;margin:10px;">Pesan</button>
  </div>
</form>

<div class="container body">
  <div class="row">
    <h3 class="header">Rincian Pesanan</h3>
    <div class="col-sm-12 col-lg-8 container">
      <table>
        <tr>
          <td class="down"><b>Alamat Lengkap</b></td>
        </tr>
        <tr>
          <td class="down">Jalan Purwo Pasar IV Dusun II Sei Mencirim, Sunggal, Deli Serdang, Sumatera Utara 20352</td>
        </tr>
        <tr>
          <td class="down"><b>Alamat Penagihan</b></td>
        </tr>
        <tr>
          <td class="down">Jalan Purwo Pasar IV Dusun II Sei Mencirim, Sunggal, Deli Serdang, Sumatera Utara 20352</td>
        </tr>
      </table>
      <table class="table table-striped">
        <tbody>
          <tr>
            <td class="header"><b>Rincian Pesanan</b></td>
          </tr>
          @foreach($c as $detail)
          <tr>
            <td><img src="{{ asset('picture/inputitem/'.$detail->picture) }}" width='100px'/></td>
            <td><strong>{{ $detail->name }}</strong></td>
            <td>{{ $detail->qty }}</td>
            <td> Rp. {{ number_format($detail->price * $detail->qty) }}</td>
          </tr>
          @endforeach
          <tr>
            <td colspan="3">Total Belanja</td>
            <td colspan="1">Rp. {{ substr($total, 0, strlen($total)-3) }}</td>
          </tr>
          <tr>
            <td colspan="3">Biaya Kirim</td>
            <td colspan="1">Rp. {{ substr($total, 0, strlen($total)-3) }}</td>
          </tr>
          <tr>
            <td colspan="3">Total Pembayaran</td>
            <td colspan="1">Rp. {{ substr($total, 0, strlen($total)-3) }}</td>
          </tr>
        </tbody>
      </table>
    </div>
    <div class="col-sm-12 col-lg-10 container body">
      <button type="button" class="btn btn-primary btn-md" style="float:right;padding:10px;margin:10px;">Pesan</button>
      <button type="button" class="btn btn-secondary btn-md" style="float:right;padding:10px;margin:10px;">Batal</button>
    </div>
  </div>
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

  function changeDistrict(){
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

  function changeSubDistrict(){
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
  </script>
@endsection
