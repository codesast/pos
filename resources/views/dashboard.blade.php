@extends('index')

@section('content')
    <div class="row margin-left-40px">
        {{--Table for checkout--}}
        <h2 class="page-header">Checkout Requests</h2>
        
            @if($errors->any())
                <div class="col-md3">
                    <div class="alert alert-danger" role="alert">
                        @foreach ($errors->all() as $error)
                            <ul>
                                <li>{{ $error }}</li>
                            </ul>
                            
                        @endforeach
                    </div>
                </div>
            @endif
                    
        
        @foreach($tableWaiting as $table)
                    
            
            <div class="col-md-3">
                <div class="box box-warning">
                    <div class="box-header with-border">
                        <h3 class="box-title">Table No. {{$table->table_no}} | {{$table->table_name}}</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body no-padding">
                        <table class="table table-striped height-200px">
                            <tr>
                                <th style="width: 10px">#</th>
                                <th>Menu Item Name</th>
                                <th>Quantity</th>
                                <th>Price</th>
                            </tr>
                            @php $total = 0 @endphp
                            @foreach($table->orders as $key => $order)
                                @php $total += $order->menu->price * $order->qty @endphp
                                <tr>
                                    <td>{{ $key + 1}}</td>
                                    <td>{{ $order->menu->name }}</td>
                                    <td>{{ $order->qty }}</td>
                                    <td><span class="badge bg-red">{{ $order->menu->price }}</span></td>
                                </tr>
                            @endforeach
                            <tr>
                                <td>#</td>
                                <td colspan="2">Total</td>
                                <td>{{$total}}</td>
                                 @php $total1 = $total * 0.1 @endphp
                                
                            </tr>
                            
                        </table>
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer bg-yellow">
                        <button type="BUTTON" class="btn btn-danger pull-right" data-toggle="modal" data-target="#modal-warning-{{$table->id}}">Check Out</button>
                    </div>
                    <!-- /.box-footer -->
                </div>
            </div>
            <div class="modal modal-warning fade" id="modal-warning-{{$table->id}}">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title">Are you Sure?</h4>
                        </div>
                        <div class="modal-body">
                            <p>Do you want to make Table No. {{ $table->table_no }} free?</p>
                            <form action="{{route('checkoutTable',$table->id)}}" method="POST">
                                {{ csrf_field() }}
                                
                                <label class="">service charge</label>
                                <input class="form-control" type="text" name="service_charge" value="{{ $total1 }}">
                                
                                <label class="">Discount amount</label>
                                <input class="form-control" type="text" name="discount" value="0">
                                <div class="modal-footer">
                                    <button type="reset" class="btn btn-outline pull-left" data-dismiss="modal">Cancel</button>

                                    <button type="submit" class="btn btn-outline">Checkout</button>
                                </div>
                                
                            </form>
                        </div>
                        
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
        @endforeach
    </div>

    <div class="row margin-left-40px">
        {{--Table for reserved--}}
        <h2 class="page-header">Busy Table</h2>

        @foreach($tableBusy as $table)
            <div class="col-md-3">
                <div class="box box-danger">
                    <div class="box-header with-border">
                        <h3 class="box-title">Table No. {{$table->table_no}} | {{$table->table_name}}</h3>
                            <label class=""> To</label>

                            <a class="pull-right" data-toggle="collapse" data-parent="#accordion" href="#collapseForm{{$table->table_no}}">
                                <label>Move table</label>
                            </a>
                            <!--pop up button-->
                            <div id="collapseForm{{$table->table_no}}" class="panel-collapse collapse">
                                <form class="form-inline" action="{{ route('movetable',$table->table_no ) }}" 
                                    method="post">
                                        {{ csrf_field() }}
                                            <select id="moveto" class="form-control" style="width:70%;" name="moveto">
                                                @foreach($tableFree as $tbl)
                                                    <option value="{{$tbl->table_no}}">{{$tbl->table_no}}</option>
                                                @endforeach
                                            </select>
                                            <input type="submit" value="move" class="btn btn-primary"/>
                                </form>
                            </div>
                            
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body no-padding">
                        <table class="table table-striped height-200px">
                            <tr>
                                <th style="width: 10px">#</th>
                                <th>Menu Item Name</th>
                                <th>Quantity</th>
                                <th>Price</th>
                            </tr>
                            @foreach($table->orders as $order)
                                <tr>
                                    <td>{{ $order->id }}</td>
                                    <td>{{ $order->menu->name }}</td>
                                    <td>{{ $order->qty }}</td>
                                    <td><span class="badge bg-red">{{ $order->menu->price }}</span></td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer bg-red">
                         <a href="{{ route('changetablestatus', $table->id) }}"> <button type="submit" class="btn btn-primary pull-left">Checkout</button></a>
                        <a href="{{ route('editorder', $table->id) }}"> <button type="submit" class="btn btn-warning pull-right">Edit</button></a>
                    </div>
                    <!-- /.box-footer -->
                </div>
            </div>
        @endforeach
    </div>

    <div class="row margin-left-40px">
        {{--Table for free--}}
        <h2 class="page-header">Free Table</h2>
        @foreach($tableFree as $table)
            <div class="col-md-3">
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">Table No. {{$table->table_no}} | {{$table->table_name}}</h3>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

@endsection