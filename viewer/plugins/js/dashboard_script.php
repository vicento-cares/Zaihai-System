<script type="text/javascript">
	let month_a_adj_cnt_chart;
	let month_term_usage_chart;
	let month_aioi_chart;

	// DOMContentLoaded function
	document.addEventListener("DOMContentLoaded", () => {
		get_applicator_list_status_count();
		get_month_a_adj_cnt_chart_year_dropdown();
		get_car_maker_dropdown();
		get_car_model_dropdown();
		get_month_term_usage_chart_year_dropdown();
		get_terminal_name_dropdown();
	});

	const get_applicator_list_status_count = () => {
		$.ajax({
			url: '../process/dashboard/dash_g_p.php',
			type: 'GET',
			cache: false,
			dataType: 'json',
			data: {
				method: 'get_applicator_list_status_count'
			},  
			success: response => {
				document.getElementById("total_rtu").innerHTML = `<b>${response.total_rtu}</b>`;
				document.getElementById("total_out").innerHTML = `<b>${response.total_out}</b>`;
				document.getElementById("total_pending").innerHTML = `<b>${response.total_pending}</b>`;
			}
		});
	}

	const get_month_a_adj_cnt_chart_year_dropdown = () => {
		$.ajax({
			url: '../process/dashboard/dash_g_p.php',
			type: 'GET',
			cache: false,
			data: {
				method: 'get_month_a_adj_cnt_chart_year_dropdown'
			},  
			success: response => {
				document.getElementById("month_a_adj_cnt_year_search").innerHTML = response;
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
				document.getElementById("month_a_adj_cnt_car_maker_search").innerHTML = response;
				document.getElementById("month_term_usage_car_maker_search").innerHTML = response;
				document.getElementById("month_aioi_car_maker_search").innerHTML = response;
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
				document.getElementById("month_a_adj_cnt_car_model_search").innerHTML = response;
				document.getElementById("month_term_usage_car_model_search").innerHTML = response;
				document.getElementById("month_aioi_car_model_search").innerHTML = response;
			}
		});
	}

	const get_applicator_no_dropdown = () => {
		let car_maker = document.getElementById("month_a_adj_cnt_car_maker_search").value;
		let car_model = document.getElementById("month_a_adj_cnt_car_model_search").value;
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
				document.getElementById("month_a_adj_cnt_applicator_no_search").innerHTML = response;
			}
		});
	}

	document.getElementById("month_a_adj_cnt_car_model_search").addEventListener("change", e => {
		get_applicator_no_dropdown();
	});

	document.getElementById("month_a_adj_cnt_form").addEventListener("submit", e => {
		e.preventDefault();
		get_month_a_adj_cnt_chart();
	});

	const get_month_a_adj_cnt_chart = () => {
		let year = document.getElementById("month_a_adj_cnt_year_search").value;
		let month = document.getElementById("month_a_adj_cnt_month_search").value;
		let car_maker = document.getElementById("month_a_adj_cnt_car_maker_search").value;
		let car_model = document.getElementById("month_a_adj_cnt_car_model_search").value;
		let applicator_no = document.getElementById("month_a_adj_cnt_applicator_no_search").value;
		let adjustment_content = document.getElementById("month_a_adj_cnt_adjustment_content_search").value;

		$.ajax({
			url: '../process/dashboard/dash_g_p.php',
			type: 'GET',
			cache: false,
			dataType: 'json',
			data: {
				method: 'get_month_a_adj_cnt_chart',
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

				let concat_label = car_maker + ' ';

				if (car_maker != car_model) {
					concat_label += car_model;
				}

				// Convert the data object to an array
				const seriesData = response.data.map(item => {
					return {
						name: item.name,
						data: Object.values(item.data) // Convert the data object to an array
					};
				});

				let ctx = document.querySelector("#month_a_adj_cnt_chart");

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
					text: `Monthly Applicator Adjustment Content Data of ${applicator_no} at ${concat_label} Zaihai Shop (${adjustment_content})`,
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
				if (month_a_adj_cnt_chart) {
					month_a_adj_cnt_chart.destroy();
				}

				month_a_adj_cnt_chart = new ApexCharts(ctx, options);
				month_a_adj_cnt_chart.render();
			}
		});
	}

	const get_month_term_usage_chart_year_dropdown = () => {
		$.ajax({
			url: '../process/dashboard/dash_g_p.php',
			type: 'GET',
			cache: false,
			data: {
				method: 'get_month_term_usage_chart_year_dropdown'
			},  
			success: response => {
				document.getElementById("month_term_usage_year_search").innerHTML = response;
				document.getElementById("month_aioi_year_search").innerHTML = response;
			}
		});
	}

	const get_terminal_name_dropdown = () => {
		$.ajax({
			url: '../process/me/terminal/term_g_p.php',
			type: 'GET',
			cache: false,
			data: {
				method: 'get_terminal_name_dropdown'
			},  
			success: response => {
				document.getElementById("month_term_usage_terminal_name_search").innerHTML = response;
			}
		});
	}

	document.getElementById("month_term_usage_form").addEventListener("submit", e => {
		e.preventDefault();
		get_month_term_usage_chart();
	});

	const get_month_term_usage_chart = () => {
		let year = document.getElementById("month_term_usage_year_search").value;
		let month = document.getElementById("month_term_usage_month_search").value;
		let car_maker = document.getElementById("month_term_usage_car_maker_search").value;
		let car_model = document.getElementById("month_term_usage_car_model_search").value;
		let terminal_name = document.getElementById("month_term_usage_terminal_name_search").value;

		$.ajax({
			url: '../process/dashboard/dash_g_p.php',
			type: 'GET',
			cache: false,
			dataType: 'json',
			data: {
				method: 'get_month_term_usage_chart',
				year: year,
				month: month,
				car_maker: car_maker,
				car_model: car_model,
				terminal_name: terminal_name
			},  
			success: response => {
				console.log(response.categories);
				console.log(response.data);

				let concat_label = car_maker + ' ';

				if (car_maker != car_model) {
					concat_label += car_model;
				}

				// Convert the data object to an array
				const seriesData = response.data.map(item => {
					return {
						name: item.name,
						data: Object.values(item.data) // Convert the data object to an array
					};
				});

				let ctx = document.querySelector("#month_term_usage_chart");

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
					text: `Monthly Terminal Usage Data of ${terminal_name} on all TRD Machines at ${concat_label} Initial`,
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
				if (month_term_usage_chart) {
					month_term_usage_chart.destroy();
				}

				month_term_usage_chart = new ApexCharts(ctx, options);
				month_term_usage_chart.render();
			}
		});
	}

	document.getElementById("month_aioi_form").addEventListener("submit", e => {
		e.preventDefault();
		get_month_aioi_chart();
	});

	const get_month_aioi_chart = () => {
		let year = document.getElementById("month_aioi_year_search").value;
		let month = document.getElementById("month_aioi_month_search").value;
		let car_maker = document.getElementById("month_aioi_car_maker_search").value;
		let car_model = document.getElementById("month_aioi_car_model_search").value;
		let status = document.getElementById("month_aioi_status_search").value;

		$.ajax({
			url: '../process/dashboard/dash_g_p.php',
			type: 'GET',
			cache: false,
			dataType: 'json',
			data: {
				method: 'get_month_aioi_chart',
				year: year,
				month: month,
				car_maker: car_maker,
				car_model: car_model,
				status: status
			},  
			success: response => {
				console.log(response.categories);
				console.log(response.data);

				let concat_label = car_maker + ' ';

				if (car_maker != car_model) {
					concat_label += car_model;
				}

				// Convert the data object to an array
				const seriesData = response.data.map(item => {
					return {
						name: item.name,
						data: Object.values(item.data) // Convert the data object to an array
					};
				});

				let ctx = document.querySelector("#month_aioi_chart");

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
					text: `Monthly Applicator ${status} at ${concat_label} Zaihai Shop`,
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
				if (month_aioi_chart) {
					month_aioi_chart.destroy();
				}

				month_aioi_chart = new ApexCharts(ctx, options);
				month_aioi_chart.render();
			}
		});
	}
</script>