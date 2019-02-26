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
                    Add New User
                </a>
            </h4>
        </div>
        <div id="collapseOne" class="panel-collapse collapse">
            <div class="box-body">
                <!-- new user form elements -->
                <div class="box box-primary">
                <!-- /.box-header -->
                    <!-- form start -->
                    {!! Form::open(array('route' => 'user.store','method'=>'POST')) !!}
                    <div class="box-body">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Full Name</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                <input type="text" class="form-control" id="name" name="name" placeholder="Enter Name">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Username</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                <input type="text" class="form-control" id="username" name="username" placeholder="Enter Username">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Email address</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                                <input type="email" class="form-control" id="email" name="email" placeholder="Enter email">
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Role</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-flag"></i></span>
                                <select class="form-control" name="role">
                                    <option>Waiter</option>
                                    <option>Cashier</option>
                                    <option>Admin</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Password</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-asterisk"></i></span>
                                <input type="password" class="form-control" id="password" name="password" placeholder="Enter Your Password">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Confirm Password</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-asterisk"></i></span>
                                <input type="password" class="form-control" id="confirm-password" name="confirm-password" placeholder="Enter Your Password Again">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Address</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-map-marker"></i></span>
                                <input type="text" class="form-control" id="address" name="address" placeholder="Enter Address">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Phone Number</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-phone"></i></span>
                                <input type="number" class="form-control" id="phone" name="phone" placeholder="Enter Phone Number">
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
            <h3 class="box-title">Existing User</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Full Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Phone Number</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach($users as $user)
                    <tr>
                        <td>{{$user->id}}</td>
                        <td>{{$user->name}}</td>
                        <td>{{$user->email}}</td>
                        <td>{{$user->role}}</td>
                        <td>{{$user->phone}}</td>
                        <td>
                            @if($user->status)
                                Enable
                            @else
                                Disable
                            @endif
                        </td>
                        <td><div class="timeline-footer">
                                <a href="{{ route('user.update', $user->id) }}" class="btn btn-primary btn-xs">Edit User</a>
                                <a class="btn btn-danger btn-xs">Delete User</a>
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
                <tfoot>
                <tr>
                    <th>ID</th>
                    <th>Full Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Phone Number</th>
                    <th>Action</th>
                </tr>
                </tfoot>
            </table>
        </div>
        <!-- /.box-body -->
    </div>
    <!-- /.box -->


@endsection