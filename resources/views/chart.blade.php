
<!DOCTYPE HTML>
<html>
<head>
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
</header>
<body>
	<div id="chartContainer" style="height: 370px; width: 100%;"></div>
	<button id="showChart">Show chart</button>
    
</body>
<script>
    function getItems(items){
        let dataPoints = [];
        return new Promise((resolve, reject) => {
            items.map((item, i) => {
                    setTimeout(() => {
                        $.ajax({
                            type: 'GET',
                            url: 'https://covid-19-data.p.rapidapi.com/report/country/name',
                            contentType: 'application/json',
                            data: {'date-format': 'YYYY-MM-DD', 'format': 'json', 'date':'2020-04-01','name': item.name},
                            success: function (response) {
                                var dataPoint = {
                                    'y' :response[0].provinces[0].confirmed,
                                    'label' : response[0].country
                                };
                                // console.log(111, dataPoint);
                                dataPoints[i]= dataPoint;
                                // console.log(111, dataPoints);

                                if(i === items.length - 1 ) {
                                    resolve(dataPoints);
                                }
                            },
                            error: function (error) {
                                console.log(error);
                            }
                        })
                     
                }, (i + 1) * 2000);
            })
        })
    }
    

	$("#showChart").click(function() {
		$.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
				'x-rapidapi-host':'covid-19-data.p.rapidapi.com',
          		'x-rapidapi-key':'39f9bc0c33mshed4a3af8b0e5ce7p1a0857jsnbf942780036b',
            }
        });
		new Promise((res, ref) => {
			$.ajax({
				type: 'GET',
			    url: 'https://covid-19-data.p.rapidapi.com/help/countries',
			    contentType: 'application/json',
			    data: { 'format': 'json'},
			    success: function (response) {
                    var contries = response.slice(0, 5);
                    getItems(contries).then(data => {
                        // console.log(111, data);
                        res(data);
                    });
                },
			    error: function (error) {
				    console.log(error);
			    }
            })
        })
        ///
		.then(data => {
            
            data = data.filter((item) => {
                if (!!item.y) { return {"y": item.y, "label": item.label}}
            });
			var chart = new CanvasJS.Chart("chartContainer", {
				title: {
					text: "Push-ups Over a Week"
				},
				axisY: {
					title: "Number of Push-ups"
				},
				data: [{
					type: "line",
					dataPoints: data
				}]
			});
			chart.render();
		})
	});
</script>
<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
</body>
</html>