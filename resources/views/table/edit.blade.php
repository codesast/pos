@extends('index')

@section('content')
    <!-- collapse effect for new user form -->
    <div class="margin-10px">
        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h4><i class="icon fa fa-ban"></i> Error!</h4>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        @if($message = Session::get('success'))
            <div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h4><i class="icon fa fa-check"></i> Success!</h4>
                {{ $message }}
            </div>
        @endif
    </div>

    <div class="box box-primary margin-10px">
        <div class="box-header with-border">
            <h3 class="box-title">Edit Existing Table</h3>
        </div>
        <!-- /.box-header -->
        <!-- form start -->
        {!! Form::open(['route' => ['table.update', $table->id],'method'=>'PATCH']) !!}
        <div class="box-body">
            <div class="form-group">
                <label for="exampleInputEmail1">Table No</label>
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-sitemap"></i></span>
                    <input type="text" class="form-control" id="table_no" name="table_no" placeholder="Enter Table No" value = "{{ $table->table_no }}">
                </div>
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">Table Name</label>
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-sitemap"></i></span>
                    <input type="text" class="form-control" id="name" name="name" placeholder="Enter Table Name" value = "{{ $table->table_name }}">

                </div>
            </div>
            <div class="form-group">
                <label>Mode</label>
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-flag"></i></span>
                    <select class="form-control" name="mode" disabled>
                        @if($table->mode == "FREE")
                            <option selected>FREE</option>
                            <option>BUSY</option>
                            <option>WAITING</option>
                        @elseif($table->mode == "BUSY")
                            <option>FREE</option>
                            <option selected>BUSY</option>
                            <option>WAITING</option>
                        @elseif($table->mode == "WAITING")
                            <option>FREE</option>
                            <option>BUSY</option>
                            <option selected>WAITING</option>
                        @endif
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label>Status</label>
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-flag"></i></span>
                    <select class="form-control" name="status">
                        @if($table->status)
                            <option selected>Enable</option>
                            <option>Disable</option>
                        @else
                            <option>Enable</option>
                            <option selected>Disable</option>
                        @endif
                    </select>
                </div>
            </div>
        </div>
        <!-- /.box-body -->
        <div class="box-footer">
            <button type="submit" class="btn btn-primary">UPDATE</button>
        </div>
        {!! Form::close() !!}
    </div>
    <!-- /.box -->
@endsection