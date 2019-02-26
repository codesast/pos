@extends('index')

@section('content')
<script>
  var randomScalingFactor = function(){ return Math.round(Math.random()*100)};
var url = "{{url('/test/chart')}}";
        var nm = new Array();
        var qty = new Array();
  $.get(url, function(response){
            response.forEach(function(data){
                nm.push(data.item_name);
                qty.push(data.quantity);
            });
          });
  var barChartData = {
    labels : nm,
    datasets : [
      {
        fillColor : "rgba(151,187,205,0.5)",
        strokeColor : "rgba(151,187,205,0.8)",
        highlightFill : "rgba(151,187,205,0.75)",
        highlightStroke : "rgba(151,187,205,1)",
        data : qty
      }
    ]

  }
  window.onload = function(){
//     var ctx = document.getElementById("canvas").getContext("2d");
//     var myBarChart = new Chart(ctx, {
//     type: 'bar',
//     data: barChartData,
//     options: 'options'
// });
    var ctx = document.getElementById("canvas").getContext("2d");
    window.myBar = new Chart(ctx).Bar(barChartData, {
      responsive : true
    });
  }

  </script>
<div class="container">         
      <form class="horizontal-form" method="POST" action="/viewreport">
        {{csrf_field()}}
         <div class="box-body form-inline">
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
        <input type="hidden" id="startDate" name="startdate" value="">
        <input type="hidden" id="endDate" name="enddate" value="">

          <div class="form-group">
            <button type="submit" class="btn btn-primary">SEARCH</button>
        </div>
        </div>
        </form>

</div>
@if(!empty($itemdetails))
<div class="container">         
  <table class="table table-striped">
    <thead>
      <tr>
        <th># SN</th>
        <th>item name</th>
        <th>quantity</th>
      </tr>
    </thead>
    <tbody>
      @foreach($itemdetails as $key => $itemdetail)
      @php $key++; @endphp
      
      @if($itemdetail->item_name =="Discount" || $itemdetail->item_name=="Service Charge")
      
      @else
       <tr>
        <td> {{ $key }} </td>
        <td> {{ $itemdetail->item_name}}</td>
        <td> {{ $itemdetail->quantity}}</td>
      </tr>

      @endif
      @endforeach

    </tbody>
  </table>


</div>
@endif

  <div class="col-md-9">
    
    <div style="width: 50%" id="test">
      tetc sn
     
    </div>
    <canvas id="canvas" height="280" width="600"></canvas>
  </div>

@endsection
