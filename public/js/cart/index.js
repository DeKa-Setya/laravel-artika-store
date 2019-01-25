function add(id) {
  $.ajax({
    url: '/dashboard',
    type: 'POST',
    data: {'_token': $('meta[name="csrf-token"]').attr('content'), 'id': id},
    success: function (data){
      if (data.status) {
        fetch();
      }
      else {
        console.log(data);
      }
    }
  }, 'json');
}

function fetch(){
  $.ajax({
    url: '/dashboard/fetch',
    type: 'POST',
    data: {'_token': $('meta[name="csrf-token"]').attr('content')},
    success: function (data){
      $("#cart").html(data);
    }
  })
}
