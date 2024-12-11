<script type="text/javascript">
	let current_applicator_list_status_count_chart;
	let current_applicators_terminals_count_chart;
	let month_a_adj_cnt_chart;
	let month_a_adj_cnt2_chart;
	let month_a_adj_cnt3_chart;
	let month_term_usage_chart;
	let month_aioi_chart;
	let month_amd_chart;

	// DOMContentLoaded function
	document.addEventListener("DOMContentLoaded", () => {
		get_applicator_list_status_count();
		get_current_applicator_list_status_count_chart();
		get_total_applicator_terminal_count();
		get_current_applicators_terminals_count_chart();
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

	const get_current_applicator_list_status_count_chart = () => {
		$.ajax({
			url: '../process/dashboard/dash_g_p.php',
			type: 'GET',
			cache: false,
			dataType: 'json',
			data: {
				method: 'get_current_applicator_list_status_count_chart'
			},  
			success: response => {
				console.log(response.categories);
				console.log(response.data);

				// Define Bootstrap 4 colors
				const bootstrapColors = ['#28a745', '#dc3545', '#ffc107'];

				// Convert the data object to an array
				const seriesData = response.data.map(item => {
					return {
						name: item.name,
						data: Object.values(item.data)
					};
				});

				let ctx = document.querySelector("#current_applicator_list_status_count_chart");

				var options = {
					chart: {
						type: 'bar',
						height: 350
					},
					plotOptions: {
						bar: {
							horizontal: false,
							columnWidth: '55%',
							endingShape: 'rounded'
						},
					},
					dataLabels: {
						enabled: false
					},
					series: seriesData,
					colors: bootstrapColors,
					xaxis: {
						categories: response.categories
					},
					title: {
						text: `Current Applicator Status Count`,
						align: 'left'
					}
				};

				// Destroy previous chart instance before creating a new one
				if (current_applicator_list_status_count_chart) {
					current_applicator_list_status_count_chart.destroy();
				}

				current_applicator_list_status_count_chart = new ApexCharts(ctx, options);
				current_applicator_list_status_count_chart.render();
			}
		});
	}

	const get_total_applicator_terminal_count = () => {
		$.ajax({
			url: '../process/dashboard/dash_g_p.php',
			type: 'GET',
			cache: false,
			dataType: 'json',
			data: {
				method: 'get_total_applicator_terminal_count'
			},  
			success: response => {
				document.getElementById("total_applicator").innerHTML = `<b>${response.total_applicator}</b>`;
				document.getElementById("total_terminal").innerHTML = `<b>${response.total_terminal}</b>`;
				document.getElementById("total_applicator_terminal").innerHTML = `<b>${response.total_applicator_terminal}</b>`;
			}
		});
	}

	const get_current_applicators_terminals_count_chart = () => {
		$.ajax({
			url: '../process/dashboard/dash_g_p.php',
			type: 'GET',
			cache: false,
			dataType: 'json',
			data: {
				method: 'get_current_applicators_terminals_count_chart'
			},  
			success: response => {
				console.log(response.categories);
				console.log(response.data);

				// Convert the data object to an array
				const seriesData = response.data.map(item => {
					return {
						name: item.name,
						data: Object.values(item.data)
					};
				});

				let ctx = document.querySelector("#current_applicators_terminals_count_chart");

				// Define colors
				const colors = ['#3c8dbc', '#20c997'];

				var options = {
					chart: {
						type: 'bar',
						height: 350
					},
					plotOptions: {
						bar: {
							horizontal: false,
							columnWidth: '55%',
							endingShape: 'rounded'
						},
					},
					dataLabels: {
						enabled: false
					},
					series: seriesData,
					colors: colors,
					xaxis: {
						categories: response.categories
					},
					title: {
						text: `Current Applicator and Terminal Count`,
						align: 'left'
					}
				};

				// Destroy previous chart instance before creating a new one
				if (current_applicators_terminals_count_chart) {
					current_applicators_terminals_count_chart.destroy();
				}

				current_applicators_terminals_count_chart = new ApexCharts(ctx, options);
				current_applicators_terminals_count_chart.render();
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
				document.getElementById("month_a_adj_cnt2_year_search").innerHTML = response;
				document.getElementById("month_a_adj_cnt3_year_search").innerHTML = response;
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
				document.getElementById("month_a_adj_cnt3_car_maker_search").innerHTML = response;
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
				document.getElementById("month_a_adj_cnt3_car_model_search").innerHTML = response;
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

	document.getElementById("month_a_adj_cnt2_form").addEventListener("submit", e => {
		e.preventDefault();
		get_month_a_adj_cnt2_chart();
	});

	const get_month_a_adj_cnt2_chart = () => {
		let year = document.getElementById("month_a_adj_cnt2_year_search").value;
		let month = document.getElementById("month_a_adj_cnt2_month_search").value;

		$.ajax({
			url: '../process/dashboard/dash_g_p.php',
			type: 'GET',
			cache: false,
			dataType: 'json',
			data: {
				method: 'get_month_a_adj_cnt2_chart',
				year: year,
				month: month
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

				let ctx = document.querySelector("#month_a_adj_cnt2_chart");

				// Define colors
				const colors = ['#f39c12', '#fd7e14', '#e74c3c', '#e83e8c'];

				var options = {
					chart: {
						type: 'bar',
						height: 350
					},
					plotOptions: {
						bar: {
							horizontal: false,
							columnWidth: '55%',
							endingShape: 'rounded'
						},
					},
					dataLabels: {
						enabled: false
					},
					series: seriesData,
					colors: colors,
					xaxis: {
						categories: response.categories
					},
					title: {
						text: `Monthly Applicator Adjustment Content Data (Adjust, Repair, Replace, Beyond The Limit)`,
						align: 'left'
					}
				};

				// Destroy previous chart instance before creating a new one
				if (month_a_adj_cnt2_chart) {
					month_a_adj_cnt2_chart.destroy();
				}

				month_a_adj_cnt2_chart = new ApexCharts(ctx, options);
				month_a_adj_cnt2_chart.render();
			}
		});
	}

	document.getElementById("month_a_adj_cnt3_form").addEventListener("submit", e => {
		e.preventDefault();
		get_month_a_adj_cnt3_chart();
	});

	const get_month_a_adj_cnt3_chart = () => {
		let year = document.getElementById("month_a_adj_cnt3_year_search").value;
		let month = document.getElementById("month_a_adj_cnt3_month_search").value;
		let car_maker = document.getElementById("month_a_adj_cnt3_car_maker_search").value;
		let car_model = document.getElementById("month_a_adj_cnt3_car_model_search").value;

		$.ajax({
			url: '../process/dashboard/dash_g_p.php',
			type: 'GET',
			cache: false,
			dataType: 'json',
			data: {
				method: 'get_month_a_adj_cnt3_chart',
				year: year,
				month: month,
				car_maker: car_maker,
				car_model: car_model
			},  
			success: response => {
				console.log(response.categories);
				console.log(response.data);

				let concat_label = car_maker + ' ';
				if (car_maker != car_model) {
					concat_label += car_model;
				}

				let concat_label_whole = `Monthly Applicator Adjustment Content Data (Adjust Repair, Replace, Beyond The Limit)`;
				if (car_maker != '' && car_maker != '') {
					concat_label_whole += ` at ${concat_label} Zaihai Shop`;
				}
				
				// Convert the data object to an array
				const seriesData = response.data.map(item => {
					return {
						name: item.name,
						data: Object.values(item.data) // Convert the data object to an array
					};
				});

				let ctx = document.querySelector("#month_a_adj_cnt3_chart");

				// Define colors
				const colors = ['#f39c12', '#fd7e14', '#e74c3c', '#e83e8c'];

				var options = {
					chart: {
						type: 'line',
						height: 350
					},
					series: seriesData,
					colors: colors,
					xaxis: {
						categories: response.categories
					},
					title: {
						text: concat_label_whole,
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
				if (month_a_adj_cnt3_chart) {
					month_a_adj_cnt3_chart.destroy();
				}

				month_a_adj_cnt3_chart = new ApexCharts(ctx, options);
				month_a_adj_cnt3_chart.render();
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
				document.getElementById("month_amd_year_search").innerHTML = response;
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

	document.getElementById("month_amd_form").addEventListener("submit", e => {
		e.preventDefault();
		get_month_amd_chart();
	});

	const get_month_amd_chart = () => {
		let year = document.getElementById("month_amd_year_search").value;
		let month = document.getElementById("month_amd_month_search").value;
		let between_element = document.getElementById("month_amd_between_search");
		let between = between_element.value;
		let between_label = '';

		// Loop through the options in the select element
		for (let i = 0; i < between_element.options.length; i++) {
			if (between_element.options[i].value === between) {
				between_label = between_element.options[i].innerHTML; // Get the inner HTML
				break; // Exit the loop once found
			}
		}

		$.ajax({
			url: '../process/dashboard/dash_g_p.php',
			type: 'GET',
			cache: false,
			dataType: 'json',
			data: {
				method: 'get_month_amd_chart',
				year: year,
				month: month,
				between: between
			},  
			success: response => {
				console.log(response.categories);
				console.log(response.data);

				// Convert the data object to an array
				const seriesData = response.data.map(item => {
					return {
						name: item.name,
						data: Object.values(item.data), // Convert the data object to an array
						elapsed_time: Object.values(item.elapsed_time) // Include elapsed time
					};
				});

				let ctx = document.querySelector("#month_amd_chart");

				var options = {
					chart: {
						type: 'bar',
						height: 350
					},
					plotOptions: {
						bar: {
							horizontal: false,
							columnWidth: '55%',
							endingShape: 'rounded'
						},
					},
					dataLabels: {
						enabled: false
					},
					series: seriesData,
					xaxis: {
						categories: response.categories
					},
					title: {
						text: `Monthly Average and Max Delay between ${between_label}`,
						align: 'left'
					},
					tooltip: {
						shared: true,
						intersect: false,
						followCursor: true, // Ensure this is set to true
						custom: function({ series, seriesIndex, dataPointIndex, w }) {
							dataPointIndex = parseInt(dataPointIndex);
							// Access elapsed time for average and max
							const averageElapsedTime = seriesData[0]['elapsed_time'][dataPointIndex];
							const maxElapsedTime = seriesData[1]['elapsed_time'][dataPointIndex];
							return `
								<div>
									<strong>${w.globals.labels[dataPointIndex]}</strong><br>
									Average: ${series[0][dataPointIndex]}<br>
									Elapsed Time: ${averageElapsedTime}<br>
									Max: ${series[1][dataPointIndex]}<br>
									Elapsed Time: ${maxElapsedTime}
								</div>
							`;
						}
					}
				};

				// Destroy previous chart instance before creating a new one
				if (month_amd_chart) {
					month_amd_chart.destroy();
				}

				month_amd_chart = new ApexCharts(ctx, options);
				month_amd_chart.render();
			}
		});
	}
</script>