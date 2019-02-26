@extends('index')

@section('content')
<div class="container">   
    <h3>Total Collection:Rs. {{$total}}/-</h3>
    
    <div class="col-md-10">
        <table class="table table-striped">
            <thead>
              <tr>
                <th># SN</th>
                <th>item name</th>
                <th>quantity</th>
              </tr>
            </thead>
            <tbody>@php $i=1;@endphp
                @foreach ($itemdetails as $itemdetail)
                    @if($itemdetail->item_name=='Discount' || $itemdetail->item_name== 'Service Charge')
                                <tr><td>{{$i}}</td><td>{{$itemdetail->item_name}}</td></tr>
                    @else
                          <tr>
                            <td> {{$i}}</td>
                            <td>{{$itemdetail->item_name}}</td>
                            <td>{{$itemdetail->quantity}}</td>
                          </tr>
                    @endif
                    @php $i++; @endphp
                @endforeach
            </tbody>
        </table>
    </div>


	@foreach($transactions as $transaction)            
            <div class="col-md-4">
                <div class="box box-warning">
                    <div class="box-header with-border">
                        <h3 class="box-title">Table No. {{$transaction->table_id}} || {{$transaction->id}} </h3>
                        <div class="box-tools pull-right">
                          <span class="label label-info" style="font-size:14px">Rs: {{$transaction->total}}/-</span>
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body no-padding">
                        <table class="table table-striped height-200px">
                            <tr>
                                <th style="width: 10px">#</th>
                                <th>Menu Item Name</th>
                                <th>Quantity</th>
                                <th>unit price</th>
                                <th>Price</th>
                            </tr>
                            @foreach($transaction->trans_detail as $trans)
                                <tr>
                                    <td>{{ $trans->id }}</td>
                                    <td>{{ $trans->item_name }}</td>
                                    <td>{{ $trans->item_quantity }}</td>
                                    <td> {{ $trans->item_price }}</td>
                                    <td><span class="badge bg-red">{{ $trans->item_rate }}</span></td>
                                </tr>
                            @endforeach
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>Total</td>
                                <td>Rs.{{$transaction->total}}/-</td>
                            </tr>
                            
                        </table>
                    </div>
                </div>
            </div>
    @endforeach
</div>
@endsection