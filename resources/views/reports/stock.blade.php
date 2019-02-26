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
            <h3 class="box-title">Stock Report Generation on the based of date</h3>
        </div>
        <!-- /.box-header -->
        <!-- form start -->
        {!! Form::open(['route' => 'stock.search','method'=>'POST']) !!}
        <div class="box-body form-inline">
            <div class="form-group">
                <label>Menu Item Type</label>
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-industry"></i></span>
                    <select class="form-control" name="menu_type">
                        <option>--ALL--</option>
                        <option>KOT</option>
                        <option>BOT</option>
                    </select>
                </div>
            </div>
            <!-- Date and time range -->
            <div class="form-group">
                <label>&nbsp; &nbsp; &nbsp;Select Date Range:</label>
                <div class="input-group">
                    <button type="button" class="btn btn-default pull-right" id="daterange-btn">
                    <span>
                      <i class="fa fa-calendar"></i> Select Range
                    </span>
                        <i class="fa fa-caret-down"></i>
                    </button>
                </div>
            </div>
            <input type="hidden" id="startDate" name="startDate" value="">
            <input type="hidden" id="endDate" name="endDate" value="">
            <div class="form-group">
                <button type="submit" class="btn btn-primary">SEARCH</button>
            </div>
        </div>
        <!-- /.box-body -->
        {!! Form::close() !!}
    </div>
    <!-- /.box -->

    <div class="box">
        <div class="box-header">
            <h3 class="box-title">Sales Report</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Menu Name</th>
                    <th>Quantity</th>
                    <th>Category</th>
                    <th>Type</th>
                    <th>Date and Time</th>
                </tr>
                </thead>
                <tbody>
                @foreach($reports as $report)
                    <tr>
                        <td>{{$report->id}}</td>
                        <td>{{$report->menu->name}}</td>
                        <td>{{$report->qty}}</td>
                        <td>{{$report->menu->category->name}}</td>
                        <td>{{$report->menu->category->type}}</td>
                        <td>{{$report->created_at}}</td>
                    </tr>
                @endforeach
                </tbody>
                <tfoot>
                <tr>
                    <th>ID</th>
                    <th>Menu Name</th>
                    <th>Quantity</th>
                    <th>Category</th>
                    <th>Type</th>
                    <th>Date and Time</th>
                </tr>
                </tfoot>
            </table>
        </div>
        <!-- /.box-body -->
    </div>
    <!-- /.box -->
@endsection

