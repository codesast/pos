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
    <div class="box-body margin-10px">
        <!-- new user form elements -->
        <div class="box box-primary margin-10px">
            <!-- /.box-header -->
            <div class="box-header with-border">
                <h3 class="box-title">Edit Existing Category</h3>
            </div>
            <!-- form start -->
            {!! Form::open(array('route' => ['category.update', $category->id],'method'=>'PATCH')) !!}
            <div class="box-body">
                <div class="form-group">
                    <label for="exampleInputEmail1">Category Name</label>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-sitemap"></i></span>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Enter Category Name" value="{{ $category->name }}">
                    </div>
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Description</label>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-briefcase"></i></span>
                        <input type="text" class="form-control" id="description" name="description" placeholder="Enter Category Description" value="{{ $category->description }}">
                    </div>
                </div>
                <div class="form-group">
                    <label>Category Type</label>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-industry"></i></span>
                        <select class="form-control" name="type">
                            @if($category->status)
                                <option selected>KOT</option>
                                <option>BOT</option>
                            @else
                                <option>KOT</option>
                                <option selected>BOT</option>
                            @endif
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label>Status</label>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-flag"></i></span>
                        <select class="form-control" name="status">
                            @if($category->status)
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
    </div>


@endsection