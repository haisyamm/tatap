@extends('app')
@section('content')
<form action="{{ route('positions.update', $position->id ) }}" method="POST" enctype="multipart/form-data">
  @csrf
  @method('PUT')
  <div class="row">
      <div class="col-xs-12 col-sm-12 col-md-12">
          <div class="form-group">
              <strong>Position Name:</strong>
              <input type="text" name="name" value="{{ $position->name }}" class="form-control" placeholder="Position Name">
              @error('name')
              <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
              @enderror
          </div>
      </div>
      <div class="col-xs-12 col-sm-12 col-md-12">
          <div class="form-group">
              <strong>Keterangan:</strong>
              <input type="text" name="keterangan" value="{{ $position->keterangan }}" class="form-control" placeholder="Keterangan">
              @error('keterangan')
              <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
              @enderror
          </div>
      </div>
      <div class="col-xs-12 col-sm-12 col-md-12">
          <div class="form-group">
              <strong>Singkatan :</strong>
              <input type="text" name="alias" value="{{ $position->alias }}" class="form-control" placeholder="Singkatan">
              @error('alias')
              <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
              @enderror
          </div>
      </div>
      <button type="submit" class="btn btn-primary mt-3 ml-3">Submit</button>
  </div>
</form>
@endsection