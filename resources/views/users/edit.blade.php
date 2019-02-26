@extends('index')

@section('content')

    <!-- general form elements -->
    <div class="box box-primary margin-10px">
        <div class="box-header with-border">
            <h3 class="box-title">Edit Existing User</h3>
        </div>
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        @if($message = Session::get('success'))
                {{ $message }}
        @endif

    <!-- /.box-header -->
        <!-- form start -->
        {!! Form::open(array('route' => ['user.update', $user->id],'method'=>'PATCH')) !!}
        <div class="box-body">
            <div class="form-group">
                <label for="exampleInputEmail1">Full Name</label>
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-user"></i></span>
                    <input type="text" class="form-control" id="name" name="name" placeholder="Enter Name" value="{{ $user->name }}">
                </div>
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">Username</label>
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-user"></i></span>
                    <input type="text" class="form-control" id="username" name="username" placeholder="Enter Username" value="{{ $user->username }}">
                </div>
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">Email address</label>
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                    <input type="email" class="form-control" id="email" name="email" placeholder="Enter email" value="{{ $user->email }}" disabled>
                </div>
            </div>
            <div class="form-group">
                <label>Role</label>
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-flag"></i></span>
                    <select class="form-control" name="role">
                        @if($user->role == 'Waiter')
                            <option selected>Waiter</option>
                        @else
                            <option>Waiter</option>
                        @endif
                        @if($user->role == 'Cashier')
                            <option selected>Cashier</option>
                        @else
                            <option>Cashier</option>
                        @endif
                        @if($user->role == 'Admin')
                            <option selected>Admin</option>
                        @else
                            <option>Admin</option>
                        @endif
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">Address</label>
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-map-marker"></i></span>
                    <input type="text" class="form-control" id="address" name="address" placeholder="Enter Address" value="{{ $user->address }}">
                </div>
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">Phone Number</label>
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-phone"></i></span>
                    <input type="number" class="form-control" id="phone" name="phone" placeholder="Enter Phone Number" value="{{ $user->phone }}">
                </div>
            </div>
            <div class="form-group">
                <label>Status</label>
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-flag"></i></span>
                    <select class="form-control" name="status">
                        @if($user->status)
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
            <button type="submit" class="btn btn-primary">Update</button>
        </div>
        {!! Form::close() !!}
    </div>
    <!-- /.box -->


@endsection