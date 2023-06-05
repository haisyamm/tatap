@extends('layout')
@section('content')
<table class="table">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Name</th>
      <th scope="col">Location</th>
      <th scope="col">Manager Name</th>
    </tr>
  </thead>
  <tbody>
    <?php $no=1; ?>
    @foreach ($departements as $item)
        <tr>
            <td>{{ $no }}</td>
            <td>{{ $item->name }}</td>
            <td>{{ $item->location }}</td>
            <td>{{ (isset($item->getManager->name) ? 
                    $item->getManager->name : 
                    'Data Not Found') }}</td>
        </tr>        
    <?php $no++; ?>
    @endforeach
  </tbody>
</table>
@endsection