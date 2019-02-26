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
            {{ $message }}
        @endif
    </div>

    <div class="panel box box-primary margin-10px">
        <div class="box-header with-border">
            <h4 class="box-title">
                <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
                    Add New Category
                </a>
            </h4>
        </div>
        <div id="collapseOne" class="panel-collapse collapse">
            <div class="box-body">
                <!-- new user form elements -->
                <div class="box box-primary">
                    <!-- /.box-header -->
                    <!-- form start -->
                    {!! Form::open(array('route' => 'category.store','method'=>'POST')) !!}
                    <div class="box-body">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Category Name</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-sitemap"></i></span>
                                <input type="text" class="form-control" id="name" name="name" placeholder="Enter Category Name">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Description</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-briefcase"></i></span>
                                <input type="text" class="form-control" id="description" name="description" placeholder="Enter Category Description">
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Category Type</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-industry"></i></span>
                                <select class="form-control" name="type">
                                    <option>KOT</option>
                                    <option>BOT</option>
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
            <h3 class="box-title">All Categories</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Category Name</th>
                    <th>Type</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach($categories as $category)
                    <tr>
                        <td>{{$category->id}}</td>
                        <td>{{$category->name}}</td>
                        <td>{{$category->type}}</td>
                        <td>
                            @if($category->status)
                                Enable
                            @else
                                Disable
                            @endif
                        </td>
                        <td><div class="timeline-footer">
                                <a href="{{ route('category.update', $category->id) }}" class="btn btn-primary btn-xs">Edit Category</a>
                                <a class="btn btn-danger btn-xs">Delete Category</a>
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
                <tfoot>
                <tr>
                    <th>ID</th>
                    <th>Category Name</th>
                    <th>Type</th>
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