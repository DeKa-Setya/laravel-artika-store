@extends('layouts.user')

@section('content')

  <section class="jumbotron text-center">
    <div class="container body">
      <h1 class="jumbotron-heading">Selamat Datang di Artika Store</h1>
      <p class="lead text-muted">Inilah Dagangan Kami. Selamat Belanja dan Selamat Menikmati. </p>
      <p>
        <a href="{{ route('login') }}" class="btn btn-primary">Login Untuk Mulai Belanja</a>
        <p class="lead text-muted">Belum Punya Akun ?</p>
        <a href="{{ route('login') }}" class="btn btn-primary green">Daftar Disini</a>
      </p>
    </div>
  </section>
<div class="container">
  <div class="row content">
    @foreach ($item as $it)
      <div class="col-6 col-md-3 down">
        <div class="card item">
          <img class="card-img-top" src="{{ asset('picture/inputitem/'.$it->picture) }}" style="max-width: 100%;" alt="Card image cap">
          <div class="card-title">
            <h4>{{ $it->name }}</h4>
            <div class="rating">
              <h5>* * * * *</h5>
            </div>
          </div>
          <div class="card-body">
            <p class="card-text">Rp. {{ $it->price }}</p>
          </div>
          <div class="card-footer">
            <small class="text-muted">Last updated {{ $it->updated_at}}</small>
          </div>
        </div>
      </div>
    @endforeach
  </div>
</div>

@endsection

@section('script')
  <script type="text/javascript">
    function ListOpen(){
      $('#listopen').modal('show');
    }

    /*$(document).ready(function(){
      var item = $( ".item" );
      var filter = $( "#search" ).val().toUpperCase().trim();
        for(var i=0; i<item.length; i++ ){
        var product_name = $(item[i]).text().toUpperCase().trim();
        var data = JSON.parse($(item[i]).attr('data-val'));
        var data_id = data.id;
        $("#card-title-"+ data_id).show();
        if( product_name.indexOf(filter) == -1 ){
          $("#card-title-"+ data_id).hide();
        }
      }
  });*/
  </script>
@endsection
