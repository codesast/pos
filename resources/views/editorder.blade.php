@extends('index')

@section('content')

    <div class="box">
        <div class="box-header">
            <h3 class="box-title">Edit Order for Table No. {{ $table->table_no }}</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Menu Name</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Extra Note</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach($table->order as $order)
                    <tr>
                        <td>{{$order->id}}</td>
                        <td>{{$order->menu->name}}</td>
                        <td>{{$order->qty}}</td>
                        <td>{{$order->menu->price}}</td>
                        <td>{{$order->note}}</td>
                        <td><div class="timeline-footer">
                                <a href="{{ route('show',$order->id)}}" class="btn btn-primary btn-xs">Edit Order</a>
                                <a href="{{ route('deleteOrder', $order->id) }}" class="btn btn-danger btn-xs">Delete Order</a>
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
                <tfoot>
                <tr>
                    <th>Order ID</th>
                    <th>Menu Name</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Extra Note</th>
                    <th>Action</th>
                </tr>
                </tfoot>
            </table>
        </div>
        <!-- /.box-body -->
    </div>
    <!-- /.box -->

@endsection