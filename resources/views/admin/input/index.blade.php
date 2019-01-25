@extends('layouts.core')

@section('content')

<div class="row grid-margin">
  <div class="col-12">
    <div class="card">
      <div class="card-body">
        <h4 class="card-title">Input Barang</h4>
        <div class="d-flex table-responsive">
          <div class="btn-group mr-2">
            <a onclick="addForm()" class="btn btn-sm btn-primary" href="#modal-form"><i class="mdi mdi-plus-circle-outline"></i> Add</a>
          </div>
        </div>
        <!--end modal-->
        <div class="table-responsive mt-3">
          <table id="item-table" class="table mt-2">
            <thead>
              <tr>
                <th>ID</th>
                <th>Nama Barang</th>
                <th>Description</th>
                <th>Harga</th>
                <th>Stok</th>
                <th>Gambar Barang</th>
                <th></th>
              </tr>
            </thead>
            <tbody></tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- modal -->
  <div class="container">
    <div class="modal fade" id="modal-form" aria-hidden="true">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
          </div>
          <div class="modal-body">
            <div class="col-12 grid-margin">
              <form id="itemsinput" onsubmit="return false">
                {{ csrf_field() }}
                <p class="card-description">
                  Personal info
                </p>
                <div class="row">
                  <div class="col-md-4">
                    <div class="form-group row">
                      <label class="col-sm-3 col-form-label">Nama Barang</label>
                      <div class="col-sm-9">
                        <input type="text" name="name" class="form-control" />
                      </div>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group row">
                      <label class="col-sm-3 col-form-label">Harga</label>
                      <div class="col-sm-9">
                        <input type="text" name="price" class="form-control" />
                      </div>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group row">
                      <label class="col-sm-3 col-form-label">Stok</label>
                      <div class="col-sm-9">
                        <input type="text" name="qty" class="form-control" />
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group row">
                      <label class="col-sm-3 col-form-label">Deskripsi</label>
                      <div class="col-sm-12">
                        <input type="text" name="description" class="form-control" />
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group row">
                      <div class="slim"
                           data-ratio="4:3"
                           data-force-type="JPG"
                           data-size="600,450">
                          <input type="file" name="picture[]"/>
                      </div>
                    </div>
                  </div>
                </div>
            </div>
          </div>
          <div class="modal-footer">
            <button onclick="save()" class="btn btn-success" type="button">Submit</button>
            <button type="button" class="btn btn-light" data-dismiss="modal">Cancel</button>
          </div>
         </form>
        </div>
      </div>
    </div>
<!-- modal -->
  </div>


@endsection

@section('script')
  <script type="text/javascript">
     table = $("#item-table").dataTable({
       processing: true,
       serverSide: true,
       ajax: "inputitem",
       columns: [
        {data: 'id', name: 'id'},
        {data: 'name', name: 'name'},
        {data: 'description', name: 'description', orderable: false, searchable: false},
        {data: 'price', name: 'price'},
        {data: 'qty', name: 'qty'},
        {data: 'picture', name: 'picture'},
        {data: 'action', name: 'action', orderable: false, searchable: false}
       ]
     });

     function addForm(){
       $('#modal-form').modal('show');
       $('#modal-form form')[0].reset();
     }

     function save() {
       $.ajax({
         url: '{{ route('inputitem.store') }}',
         method: 'post',
         data: $("#itemsinput").serialize(),
         success: function (data) {
           if (data.status) {
             swal('Success', data.description, 'success');
             $('#item-table').DataTable().ajax.reload();
             $('#modal-form').modal('hide');
           }
           else {
             swal('Oops', 'Something when wrong', 'error');
           }
         }
      }, 'json');
     }
  </script>

@endsection
