@extends('index')

@section('content')
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>
<div class="container">
    <label>&nbsp; &nbsp; &nbsp;Select Date Range:</label>
            <div class="input-group">
                <button type="button" class="btn btn-default pull-right" id="daterange-btn">
                    <span>
                      <i class="fa fa-calendar"></i> Select Range
                    </span>
                    <i class="fa fa-caret-down"></i>

                </button>
                 <input type="button" class="btn btn-primary" id="postdata" value="click me"/>

            </div>

        <input type="hidden" id="startDate" name="startdate" value="">
        <input type="hidden" id="endDate" name="enddate" value="">

     

      <canvas id="canvas" height="280" width="600"></canvas>

      <canvas id="bar-chart" height="280" width="600"></canvas>
</div>

<script>

        var item = [];
        var qty =[];
    $("#postdata").click(function(){

        //alert("The paragraph was clicked.");
        //alert("Text: " + $("#startDate").val() + $("#endDate").val());
        

         $.post("api/ajaxpost",
        {
          name: "test 123",
          city: "test city",
          startDate: $("#startDate").val(),
          endDate: $("#endDate").val()
        },
        function(data,status){
           $.each(data, function(key, value) {

            item.push(value.item_name);
            qty.push(value.quantity);

           //alert("item name" + item[key] +"  quantity"+ qty[key]);
        });
    });

            alert(item[0]);
            // alert("data length "+ data.length +"item name: " + data[0].item_name +" quantity :"+ data[0].quantity + "\nStatus: " + status);
            var ctx = document.getElementById("canvas").getContext('2d');
                var myChart = new Chart(ctx, {
                  type: 'bar',
                  data: {
                      labels: item,
                      datasets: [{
                          label: 'Infosys Price',
                          data: qty,
                          borderWidth: 1
                      }]
                  },
                  options: {
                      scales: {
                          yAxes: [{
                              ticks: {
                                  beginAtZero:true
                              }
                          }]
                      }
                  }
              });
                myChart.update();
        });
</script>
<script type="text/javascript">
// Bar chart
new Chart(document.getElementById("bar-chart"), {
    type: 'bar',
    data: {
      labels: ["Africa", "Asia", "Europe", "Latin America", "North America"],
      datasets: [
        {
          label: "Population (millions)",
          backgroundColor: ["#3e95cd", "#8e5ea2","#3cba9f","#e8c3b9","#c45850"],
          data: [2478,5267,734,784,433]
        }
      ]
    },
    options: {
      legend: { display: false },
      title: {
        display: true,
        text: 'Predicted world population (millions) in 2050'
      }
    }
});
</script>
@endsection