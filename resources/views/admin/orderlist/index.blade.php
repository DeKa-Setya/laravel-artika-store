@extends('layouts.core')
@section('content')
<div class="row grid-margin">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Daftar Pemesan</h4>
                <div class="table-responsive">
                    <table id="order-listing" class="table">
                        <thead>
                            <tr>
                                <th>No. Order</th>
                                <th>Nama Pemesan</th>
                                <th>Alamat Penerima</th>
                                <th>Alamat Penagihan</th>
                                <th>Total</th>
                                <th>Status Pembayaran</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($item as $key)
                            <tr>
                                <td>{{ $key->sales_code }}</td>
                                <td>{{ $key->user }}</td>
                                <td>{{ $key->delivery_address }}</td>
                                <td>{{ $key->billing_address }}</td>
                                <td>Rp.{{ $key->total }}.000</td>
                                <td><label class="badge badge-danger">Pending</label></td>
                                <td>
                                    <button onclick="showDetails(this)" class="btn btn-light" data-val="{{ json_encode($key) }}"><i class="fas fa-eye"></i>Show</button>
                                </td>
                                <td>
                                    <button onclick="accept(id)" class="btn btn-primary btn-sm active" role="button" aria-pressed="true">Terima</button>
                                </td>
                                <td>
                                    <button onclick="decline(id)" class="btn btn-danger btn-sm active" role="button" aria-pressed="true">Tolak</button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="detailproduct" aria-hidden="true">
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
                    <div class="col-12 col-md-12 col-lg-12 container">
                        <table class="table table-striped">
                            <thead>
                                <td>Nama</td>
                                <td></td>
                                <td>Total Unit</td>
                                <td>Harga</td>
                                <td></td>
                            </thead>
                            <tbody>
                                <tr>
                                    <td id="id"></td>
                                    <td id="photo"></td>
                                    <td id="qty"></td>
                                    <td id="price"></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script type="text/javascript">
    function showDetails(obj) {
        $('#detailproduct').modal('show');
        if ($(obj).attr('data-val')) {
            var data = JSON.parse($(obj).attr('data-val'));
            $("#id").html(data.product_name);
            $("#photo").html('<img src="/picture/inputitem/' + data.photo + '" class="popup-picture" />');
            $("#qty").html(data.product_qty);
            $("#price").html(data.product_price);
        }
        console.log(data);
    }

    function accept(id) {
        $.ajax({
            url: '/orderlist/accept',
            type: 'POST',
            data: {
                '_token': $('meta[name="csrf-token"]').attr('content'),
                'id': id
            },
            success: function(data) {
                if (data.status) {
                    window.location.href = '/orderlist';
                } else {
                    console.log(data);
                }
            }
        }, 'json');
    }
</script>
@endsection
