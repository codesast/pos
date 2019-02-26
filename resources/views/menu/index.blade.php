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
                    Add New Menu
                </a>
            </h4>
        </div>
        <div id="collapseOne" class="panel-collapse collapse">
            <div class="box-body">
                <!-- new user form elements -->
                <div class="box box-primary">
                    <!-- /.box-header -->
                    <!-- form start -->
                    {!! Form::open(['route' => 'menu.store','method'=>'POST','files' => true]) !!}
                    <div class="box-body">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Menu Name</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-sitemap"></i></span>
                                <input type="text" class="form-control" id="name" name="name" placeholder="Enter Menu Name">
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Category</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-industry"></i></span>
                                <select class="form-control" name="category">
                                    @foreach($categories as $category)
                                        <option value="{{$category->id}}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Price</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-briefcase"></i></span>
                                <input type="number" class="form-control" id="price" name="price" placeholder="Enter Menu Unit Price">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputFile">Menu Image</label>
                            <input type="file" id="exampleInputFile" accept=".png,.jpg,.jpeg"  name="image">
                            <p class="help-block">Please select image with appropriate size.</p>
                        </div>
                        <div class="form-group">
                            <label>Menu Type</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-industry"></i></span>
                                <select class="form-control" name="stockable">
                                    <option>Stockable</option>
                                    <option>Non-Stockable</option>
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
            <h3 class="box-title">All Menus</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Menu Name</th>
                    <th>Price</th>
                    <th>Category</th>
                    <th>Sockable</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach($menus as $menu)
                    <tr>
                        <td>{{$menu->id}}</td>
                        <td>{{$menu->name}}</td>
                        <td>{{$menu->price}}</td>
                        <td>{{$menu->category->name}}</td>
                        <td>
                            @if($menu->stockable)
                                Stockable
                            @else
                                Non-Stockable
                            @endif
                        </td>
                        <td>
                            @if($menu->status)
                                Enable
                            @else
                                Disable
                            @endif
                        </td>
                        <td>
                            <div class="timeline-footer">
                                <a href="{{ route('menu.edit', $menu->id) }}" class="btn btn-primary btn-xs">Edit Menu</a>
                                <a class="btn btn-danger btn-xs">Delete Menu</a>
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