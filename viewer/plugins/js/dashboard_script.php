<script type="text/javascript">
	let applicator_adj_cnt_chart;

	// DOMContentLoaded function
	document.addEventListener("DOMContentLoaded", () => {
		get_applicator_adj_cnt_chart_year_dropdown();
		get_car_maker_dropdown();
		get_car_model_dropdown();
	});

	const get_applicator_adj_cnt_chart_year_dropdown = () => {
		$.ajax({
			url: '../process/dashboard/dash_g_p.php',
			type: 'GET',
			cache: false,
			data: {
				method: 'get_applicator_adj_cnt_chart_year_dropdown'
			},  
			success: response => {
				document.getElementById("applicator_adj_cnt_year_search").innerHTML = response;
			}
		});
	}

	const get_car_maker_dropdown = () => {
		$.ajax({
			url: '../process/me/car_maker/cm_g_p.php',
			type: 'GET',
			cache: false,
			data: {
				method: 'get_car_maker_dropdown'
			},  
			success: response => {
				document.getElementById("applicator_adj_cnt_car_maker_search").innerHTML = response;
			}
		});
	}

	const get_car_model_dropdown = () => {
		$.ajax({
			url: '../process/me/car_maker/cm_g_p.php',
			type: 'GET',
			cache: false,
			data: {
				method: 'get_car_model_dropdown'
			},  
			success: response => {
				document.getElementById("applicator_adj_cnt_car_model_search").innerHTML = response;
			}
		});
	}

	const get_applicator_no_dropdown = () => {
		let car_maker = document.getElementById("applicator_adj_cnt_car_maker_search").value;
		let car_model = document.getElementById("applicator_adj_cnt_car_model_search").value;
		$.ajax({
			url: '../process/dashboard/dash_g_p.php',
			type: 'GET',
			cache: false,
			data: {
				method: 'get_applicator_no_dropdown',
				car_maker: car_maker,
				car_model: car_model
			},  
			success: response => {
				document.getElementById("applicator_adj_cnt_applicator_no_search").innerHTML = response;
			}
		});
	}

	document.getElementById("applicator_adj_cnt_car_model_search").addEventListener("change", e => {
		get_applicator_no_dropdown();
	});

	const get_applicator_adj_cnt_chart = () => {
		let year = document.getElementById("applicator_adj_cnt_year_search").value;
		let month = document.getElementById("applicator_adj_cnt_month_search").value;
		let car_maker = document.getElementById("applicator_adj_cnt_car_maker_search").value;
		let car_model = document.getElementById("applicator_adj_cnt_car_model_search").value;
		let applicator_no = document.getElementById("applicator_adj_cnt_applicator_no_search").value;
		let adjustment_content = document.getElementById("applicator_adj_cnt_adjustment_content_search").value;
		$.ajax({
			url: '../process/dashboard/dash_g_p.php',
			type: 'GET',
			cache: false,
			dataType: 'json',
			data: {
				method: 'get_applicator_adj_cnt_chart',
				year: year,
				month: month,
				car_maker: car_maker,
				car_model: car_model,
				applicator_no: applicator_no,
				adjustment_content: adjustment_content
			},  
			success: response => {
				console.log(response.categories);
				console.log(response.data);

				// Convert the data object to an array
				const seriesData = response.data.map(item => {
					return {
						name: item.name,
						data: Object.values(item.data) // Convert the data object to an array
					};
				});

				let ctx = document.querySelector("#applicator_adj_cnt_chart");

				var options = {
					chart: {
						type: 'line',
						height: 350
					},
					series: seriesData,
					xaxis: {
						categories: response.categories
					},
					title: {
						text: 'Applicator Adjustment Content Data',
						align: 'left'
					},
					stroke: {
						curve: 'smooth'
					},
					markers: {
						size: 5
					},
					tooltip: {
						shared: true,
						intersect: false
					}
				};

				// Destroy previous chart instance before creating a new one
				if (applicator_adj_cnt_chart) {
					applicator_adj_cnt_chart.destroy();
				}

				applicator_adj_cnt_chart = new ApexCharts(ctx, options);
				applicator_adj_cnt_chart.render();
			}
		});
	}
</script>