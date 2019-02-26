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

    <div class="panel box box-primary margin-10px">
        <div class="box-header with-border">
            <h4 class="box-title">
                <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
                    Add New Table
                </a>
            </h4>
        </div>
        <div id="collapseOne" class="panel-collapse collapse">
            <div class="box-body">
                <!-- new user form elements -->
                <div class="box box-primary">
                    <!-- /.box-header -->
                    <!-- form start -->
                    {!! Form::open(['route' => 'table.store','method'=>'POST']) !!}
                    <div class="box-body">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Table No</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-sitemap"></i></span>
                                <input type="text" class="form-control" id="table_no" name="table_no" placeholder="Enter Table No" value = {{ $tableNo }}>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Table Name</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-sitemap"></i></span>
                                <input type="text" class="form-control" id="name" name="name" placeholder="Enter Table Name">
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Mode</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-flag"></i></span>
                                <select class="form-control" name="mode">
                                    <option>FREE</option>
                                    <option>BUSY</option>
                                    <option>WAITING</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Status</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-flag"></i></span>
                                <select class="form-control" name="status">
                                    <option>Enable</option>
                                    <option>Disable</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary">CREATE</button>
                    </div>
                    {!! Form::close() !!}
                </div>
                <!-- /.box -->
            </div>
        </div>
    </div>





    <div class="box">
        <div class="box-header">
            <h3 class="box-title">All Tables</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Table No.</th>
                    <th>Table Name</th>
                    <th>Mode</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach($tables as $table)
                    <tr>
                        <td>{{$table->id}}</td>
                        <td>{{$table->table_no}}</td>
                        <td>{{$table->table_name}}</td>
                        <td>{{$table->mode}}</td>
                        <td>
                            @if($table->status)
                                Enable
                            @else
                                Disable
                            @endif
                        </td>
                        <td>
                            <div class="timeline-footer">
                                <a href="{{ route('table.edit', $table->id) }}" class="btn btn-primary btn-xs">Edit Table</a>
                                <a class="btn btn-danger btn-xs">Delete Table</a>
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
                <tfoot>
                <tr>
                    <th>ID</th>
                    <th>Table No.</th>
                    <th>Table Name</th>
                    <th>Mode</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
                </tfoot>
            </table>
        </div>
        <!-- /.box-body -->
    </div>
    <!-- /.box -->
@endsection