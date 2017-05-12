
@extends('layouts.index')

@section('title', 'AlgebraBox | The greatest cloud storage')

@section('content')
<div class="row">
  <ol class="breadcrumb">
    <li class="active">Home</li>
  </ol>
</div>
<div class="row panel-body">
<table class="table table-hover">
	<tr>
		<th> Naziv dokumenta </th>
		<th> Kreiran </th>
		<th> Azuriran </th>
		<th> Upravljanje </th>
	</tr>
    @foreach($files as $key=>$value)
    <tr>
        <th><a>{{$value["name"]}}</a></th>
		<th>{{$value["created_at"]}}</th>
		<th>{{$value["updated_at"]}}</th>
		<td>
			<a href="" class="btn btn-primary btn-sm" role="button">Uredi</a> 
			<form method="GET"><button class="btn btn-danger btn-sm" id="delete_{{$value["name"]}}"       name="delete_{{$value["name"]}}">Izbrisi</button></form>
		</td>
    </tr>
    @endforeach
</table>

<div class="panel-body">
	<form method="GET">
		<div class="form-group">
			<label for="nazivUpload">Naziv novog direktorija</label>
			<input type="text" name="nazivDir" id="nazivDir" class="form-control" placeholder="Upisite naziv direktorija">
		</div>					
		<div class="form-group">
			<button class="btn btn-primary btn-lg" name="uploadDir" id="uploadDir">Kreiraj!</button>
			<a class="btn btn-danger btn-lg" role="button">Odustani</a>
		</div>
	</form>
</div>
</div>
@stop
