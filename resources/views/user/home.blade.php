@extends('layouts.index')

@section('title', 'AlgebraBox | The greatest cloud storage')

@section('content')
<div class="row">
  <ol class="breadcrumb">
    <li class="active">Home</li>
  </ol>
</div>
<div class="row">
	<div class="col-md-3">
		<div class="list-group">
		  <a href="#" class="list-group-item list-group-item-info" data-toggle="modal" data-target="#createDir"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Create New Directory</a>
		  <a href="#" class="list-group-item list-group-item-info"><span class="glyphicon glyphicon-cloud-upload" aria-hidden="true"></span> Upload Files</a>
		</div>
	</div>
	<div class="col-md-9">
		<table class="table table-hover">
			<tr>
				<th>Name</th>
				<th>Action</th>
			</tr>
			@foreach($directories as $directory)
			<tr>
				<td>
					<span class="glyphicon glyphicon-folder-close" aria-hidden="true"></span> &nbsp; 
					<a href="{{ route('home.directory', str_replace('/','', strstr($directory, '/'))) }}"><b>{{ str_replace('/','', strstr($directory, '/')) }}</b></a>
				</td>
				<td>
					<a href="{{ route('home.directory.delete', str_replace('/','', strstr($directory, '/'))) }}" data-method="delete" data-token="{{ csrf_token() }}" class="btn btn-danger btn-sm action_confirm"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a>
				</td>
			</tr>
			@endforeach
			@foreach($files as $file)
			<tr>
				<td>
					<span class="glyphicon glyphicon-file" aria-hidden="true"></span> &nbsp; 
					<a href="">{{ str_replace('/','', strstr($file, '/')) }}</a>
				</td>
				<td></td>
			</tr>
			@endforeach
		</table>
	</div>
</div>

<!-- Create Directory Modal -->
<!-- Modal -->
<div class="modal fade" id="createDir" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Create New Directory</h4>
      </div>
	  <form method="POST" action="{{ route('home.directory.create') }}">
		<div class="modal-body">
			{{ csrf_field() }}
			<div class="form-group">
				<label for="dir_name">Create new directory</label>
				<input type="text" class="form-control" id="dir_name" name="dir_name" placeholder="Enter name for directory" required>
			</div>
		</div>
		<div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			<button type="submit" class="btn btn-primary">Create</button>
		</div>
	  </form>
    </div>
  </div>
</div>
@stop






