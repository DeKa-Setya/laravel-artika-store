@extends('layouts.user')

@section('content')

@if(Session::has('message'))
<p class="alert alert-info">{{ Session::get('message') }}</p>
@endif

<div class="modal fade" id="listopen" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Daftar Keranjang Anda</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="cart">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                <a href="{{ url('/order') }}" class="btn btn-primary">Lanjutkan Pembayaran</a>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="popup" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail Produk</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-4-sm-4" id="popup-content">
                    </div>
                    <div class="col-8-sm-8 detail">
                        <h4 id="popup-title"></h4>
                        <p id="popup-description"></p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary">Lihat Rincian</button>
            </div>
        </div>
    </div>
</div>

<div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
  <ol class="carousel-indicators">
    @foreach ($item as $n)
      <li data-target="#carouselExampleIndicators" data-slide-to="{{$n->i}}" class="active"></li>
    @endforeach
  </ol>
  <div class="carousel-inner">
    @foreach ($item as $slide)
    <div class="carousel-item active">
      <img class="d-block w-100" src="{{ asset('picture/inputitem/'.$slide->picture) }}" alt="First slide">
    </div>
    @endforeach
  </div>

  <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="sr-only">Previous</span>
  </a>
  <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="sr-only">Next</span>
  </a>
</div>

<div class="container margin">
    <div class="row">
        @foreach ($item as $items)
        <div class="col-12 col-sm-4 col-lg-3">
          <div class="card">
              <img class="card-img-top" src="{{ asset('picture/inputitem/'.$items->picture) }}" alt="Card image cap">
              <div class="card-body">
                  <h5 class="card-title">{{ $items->name }}</h5>
                  <p class="card-text">Rp. {{ $items->price }}</p>
                  <button onclick="showDetail(this)" type="button" class="btn btn-secondary btn-sm" href="#product" data-val="{{ json_encode($items) }}">Lihat Rincian</button>
                  <button type="button" class="btn btn-primary btn-sm" onclick="add( {{ $items->id }} )" id="product-item-{{ $items->id }}">Beli</button>
              </div>
              <div class="card-footer">
                  <small class="text-muted">Last updated {{ $items->updated_at }}</small>
              </div>
          </div>
        </div>
        @endforeach
    </div>
</div>

@endsection

@section('script')
<script type="text/javascript">

  $('.carousel').carousel({
    interval: 10000
  })

    function ListOpen() {
        $('#listopen').modal('show');
        fetch();
    }

    function Product() {
        $('#product').modal('show');
    }

    function showDetail(obj) {
        $('#popup').modal('show');
        if ($(obj).attr('data-val')) {
            var data = JSON.parse($(obj).attr('data-val'));
            $("#popup-title").text(data.name);
            $("#popup-content").html('<img src="/picture/inputitem/' + data.picture + '" class="popup-picture" />');
            $('#popup-description').text(data.description);
        }
    }

    function add(id) {
        $.ajax({
            url: '/dashboard',
            type: 'POST',
            data: {
                '_token': $('meta[name="csrf-token"]').attr('content'),
                'id': id
            },
            success: function(data) {
                if (data.status) {
                    fetch();
                } else {
                    console.log(data);
                }
            }
        }, 'json');
    }

    function removeItem(id) {
        $.ajax({
            url: '/dashboard/destroy',
            type: 'POST',
            data: {
                '_token': $('meta[name="csrf-token"]').attr('content'),
                'id': id
            },
            success: function(data) {
                if (data.status) {
                    fetch();
                } else {
                    console.log(data);
                }
            }
        }, 'json');
    }

    function removeQty(id) {
        $.ajax({
            url: '/dashboard/remove',
            type: 'POST',
            data: {
                '_token': $('meta[name="csrf-token"]').attr('content'),
                'id': id
            },
            success: function(data) {
                if (data.status) {
                    fetch();
                } else {
                    console.log(data);
                }
            }
        }, 'json');
    }

    function addQty(id) {
        $.ajax({
            url: '/dashboard/add',
            type: 'POST',
            data: {
                '_token': $('meta[name="csrf-token"]').attr('content'),
                'id': id
            },
            success: function(data) {
                if (data.status) {
                    fetch();
                } else {
                    console.log(data);
                }
            }
        }, 'json');
    }

    function fetch() {
        $.ajax({
            url: '/dashboard/fetch',
            type: 'POST',
            data: {
                '_token': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(data) {
                $("#cart").html(data);
            }
        });
    }

    /*funtion order(){
      $.ajax({
        url: '/dashboard/order',
        type: 'POST',
        data: {'_token': $('meta[name="csrf-token"]').attr('content')},
        success: function (data){
          window.location.href = '/order';
        }
      })
    }


    function searchData() {
        var item = $( ".product" );
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
      }*/
</script>
@endsection
