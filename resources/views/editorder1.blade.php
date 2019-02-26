@extends('index')

@section('content')

    <div class="box">
        <div class="box-header">
            <h3 class="box-title">Edit Order for Table No. </h3>
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
                    <tr>
                        <form action="{{ route('updateorder') }}" method="POST">
                            {{ csrf_field() }}
                        <td><input type="text" name="order_id"value="{{$order->id or ''}}" /></td>
                        <td><input type="text" name="menu_name"value="{{$order->menu->name or ''}}"/></td>
                        <td><input type="text" name="qty" value="{{$order->qty or ''}}"/></td>
                        <td><input type="text" name="price" value="{{$order->menu->price or ''}}"/></td>
                        <td><input type="text" name="note" value="{{$order->note or ''}}"/></td>
                        <td><input type="submit" value="Update Order" class="btn btn-primary btn-xs"/>

                        </form>

                    </tr>
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