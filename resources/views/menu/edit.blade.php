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
        <!-- /.box-header -->
        <div class="box-header with-border">
            <h3 class="box-title">Edit Existing Menu</h3>
        </div>
        <!-- form start -->
        {!! Form::open(['route' => ['menu.update', $menu->id],'method'=>'PATCH','files' => true]) !!}
        <div class="box-body">
            <div class="form-group">
                <label for="exampleInputEmail1">Menu Name</label>
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-sitemap"></i></span>
                    <input type="text" class="form-control" id="name" name="name" placeholder="Enter Menu Name" value="{{ $menu->name }}">
                </div>
            </div>
            <div class="form-group">
                <label>Category</label>
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-industry"></i></span>
                    <select class="form-control" name="category">
                        @foreach($categories as $category)
                            @if($menu->category->id == $category->id)
                                <option value="{{$category->id}}" selected>{{ $category->name }}</option>
                            @else
                                <option value="{{$category->id}}">{{ $category->name }}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label>Price</label>
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-briefcase"></i></span>
                    <input type="number" class="form-control" id="price" name="price" placeholder="Enter Menu Unit Price" value="{{ $menu->price }}">
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
                        @if($menu->stockable)
                            <option selected>Stockable</option>
                            <option>Non-Stockable</option>
                        @else
                            <option>Stockable</option>
                            <option selected>Non-Stockable</option>
                        @endif
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label>Status</label>
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-flag"></i></span>
                    <select class="form-control" name="status">
                        @if($menu->status)
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