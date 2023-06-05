@extends('app')
@section('content')
<form action="{{ route('rabs.store') }}" method="POST" enctype="multipart/form-data">
  @csrf
  <div class="row">
      <div class="col-xs-12 col-sm-12 col-md-12">
          <div class="form-group">
              <strong>NO RAB:</strong>
              <input type="text" name="no_rab" class="form-control" placeholder="NO RAB">
              @error('no_rab')
              <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
              @enderror
          </div>
      </div>
      <div class="col-xs-12 col-sm-12 col-md-12">
          <div class="form-group">
              <strong>Tanggal RAB:</strong>
              <input type="date" name="tgl_rab" class="form-control" placeholder="Tanggal RAB">
              @error('tgl_rab')
              <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
              @enderror
          </div>
      </div>
      <div class="col-xs-12 col-sm-12 col-md-12">
          <div class="form-group">
              <strong>Penyusun :</strong>
              <select name="id_penyusun" id="id_penyusun" class="form-select">
                <option value="">Pilih</option>
                @foreach ($managers as $item)
                <option value="{{ $item->id }}" >{{ $item->name }}</option>
                @endforeach
              </select>
              @error('id_penyusun')
              <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
              @enderror
          </div>
      </div>
      <div class="row col-xs-12 col-sm-12 col-md-12 mt-3">
          <div class="form-group col-10">
              <input type="text" name="search" id="search" class="form-control" placeholder="Masukan Nama Product">
              @error('search')
              <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
              @enderror
          </div>
          <div class="form-group col-2">
              <button type="text" class="btn btn-secondary"> Tambah </button>
          </div>
      </div>
      <div class="col-xs-12 col-sm-12 col-md-12 mt-3">
        <table id="example" class="table table-striped" style="width:100%">
            <thead>
                <tr>
                <th scope="col">#</th>
                <th scope="col">Name Product</th>
                <th scope="col">Price</th>
                <th scope="col">QTY</th>
                <th scope="col">Sub Total</th>
                <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody id="detail">
                
            </tbody>
        </table>
      </div>
      <button type="submit" class="btn btn-primary mt-3 ml-3">Submit</button>
  </div>
</form>
@endsection
@section('js')
<script type="text/javascript">
    var path = "{{ route('search.product') }}";
  
    $( "#search" ).autocomplete({
        source: function( request, response ) {
          $.ajax({
            url: path,
            type: 'GET',
            dataType: "json",
            data: {
               search: request.term
            },
            success: function( data ) {
               response( data );
            }
          });
        },
        select: function (event, ui) {
           $('#search').val(ui.item.label);
           add(ui.item.id);
        //    console.log(ui.item); 
           return false;
        }
      });

    function add(id){
        // console.log(id);
        const path = "{{ route('products.index') }}/"+id;
        var html = "";
        var no=0;
        $.ajax({
            url: path,
            type: 'GET',
            dataType: "json",
            
            success: function( data ) {
                if($('#detail tr').length > no){
                    html = $('#detail').html();
                    no = $('#detail tr').length;
                }
                no++;
                html+='<tr>'+
                        '<td>'+
                            '<input type="hidden" name="productId'+no+'" class="form-control" value="'+data.id+'">'+
                            '<span>'+no+'</span>'+
                        '</td>'+
                        '<td>'+
                            '<input type="text" name="productName'+no+'" class="form-control" value="'+data.name+'" >'+
                        '</td>'+
                        '<td>'+
                            '<input type="text" name="price'+no+'" class="form-control" value="'+data.price+'" >'+
                        '</td>'+
                        '<td>'+
                            '<input type="number" name="qty'+no+'" class="form-control" oninput="sumQty('+no+',this.value)">'+
                        '</td>'+
                        '<td>'+
                            '<input type="number" name="sub_total'+no+'" class="form-control" >'+
                        '</td>'+
                    '</tr>';

                    $('#detail').html(html);
            }
          });
    }

    function sumQty(no, q){
        var price = $("input[name=price"+no+"]").val();
        var subtotal = q*parseInt(price);
        $("input[name=sub_total"+no+"]").val(subtotal);
        console.log(q+"*"+price+"="+subtotal);
    }
  
</script>
@endsection