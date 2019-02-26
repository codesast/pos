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
            <h3 class="box-title">Add Stock</h3>
        </div>
        <!-- /.box-header -->
        <!-- form start -->
        {!! Form::open(['route' => 'stock.store','method'=>'POST']) !!}
        <div class="box-body">
            <div class="form-group">
                <label>Stock Item</label>
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-industry"></i></span>
                    <select class="form-control" name="stock_id">
                        @foreach($stocks as $stock)
                            <option value="{{$stock->id}}">{{ $stock->menu->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label>Quantity</label>
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-briefcase"></i></span>
                    <input type="number" class="form-control" id="quantity" name="quantity" placeholder="Enter Quantity Unit">
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





    <div class="box">
        <div class="box-header">
            <h3 class="box-title">Stocks Available</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Category</th>
                    <th>Quantity</th>
                    <th>Status</th>
                </tr>
                </thead>
                <tbody>
                @foreach($stocks as $stock)
                    <tr>
                        <td>{{$stock->id}}</td>
                        <td>{{$stock->menu->name}}</td>
                        <td>{{$stock->menu->category->name}}</td>
                        <td>{{$stock->qty}}</td>
                        <td>
                            @if($stock->menu->status)
                                Enable
                            @else
                                Disable
                            @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
                <tfoot>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Category</th>
                    <th>Quantity</th>
                    <th>Status</th>
                </tr>
                </tfoot>
            </table>
        </div>
        <!-- /.box-body -->
    </div>
    <!-- /.box -->


@endsection