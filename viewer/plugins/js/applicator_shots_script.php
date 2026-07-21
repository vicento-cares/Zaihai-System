<script type="text/javascript">
	let shotcnt_good_vs_exceeded_qa_chart;
	let shotcnt_good_vs_exceeded_ee_chart;
	let shotcnt_exceeded_prio_ee_chart;
	let shotcnt_exceeded_prio_qa_chart;
	let shotcnt_exceeded_appstat_ee_chart;
	let shotcnt_exceeded_appstat_qa_chart;
	let shotcnt_u_ranges_chart;
	let shotcnt_d_ranges_chart;
	let shotcnt_i_u_ranges_chart;
	let shotcnt_i_d_ranges_chart;
	let shotcnt_c_ranges_chart;
	let current_hourly_exceeded_chart;
	let current_week_exceeded_chart;
	let current_month_exceeded_chart;

    // Global Variables for Realtime
	var realtime_get_recent_applicator_shots;

	// DOMContentLoaded function
	document.addEventListener("DOMContentLoaded", () => {
		get_current_overall_shotcnt();
		get_shotcnt_good_vs_exceeded_qa_chart();
		get_shotcnt_good_vs_exceeded_ee_chart();
		get_shotcnt_exceeded_prio_ee_chart();
		get_shotcnt_exceeded_prio_qa_chart();
		get_shotcnt_exceeded_appstat_ee_chart();
		get_shotcnt_exceeded_appstat_qa_chart();
		get_shotcnt_u_ranges_chart();
		get_shotcnt_d_ranges_chart();
		// get_shotcnt_i_u_ranges_chart();
		// get_shotcnt_i_d_ranges_chart();
		// get_shotcnt_c_ranges_chart();
		get_current_hourly_exceeded_chart();
		get_current_week_exceeded_chart();
		get_current_month_exceeded_chart();
		
		get_car_maker_dropdown_search();
		get_car_model_dropdown_search();
		get_applicator_no_datalist_search();
		get_location_datalist_search();
		get_recent_applicator_shots();
		realtime_get_recent_applicator_shots = setInterval(get_recent_applicator_shots, 10000);
	});

	const get_current_overall_shotcnt = () => {
		$.ajax({
			url: '../process/applicator_shots/as_dash_g_p.php',
			type: 'GET',
			cache: false,
			dataType: 'json',
			data: {
				method: 'get_current_overall_shotcnt'
			},  
			success: response => {
				// Good
				// document.getElementById("total_appshot_good_ee").innerHTML = `<b>${response.total_appshot_good_ee}</b>`;
				document.getElementById("total_appshot_good_prio_ee").innerHTML = `<b>${response.total_appshot_good_prio_ee}</b>`;
				document.getElementById("total_appshot_good_prod_prio_ee").innerHTML = `<b>${response.total_appshot_good_prod_prio_ee}</b>`;
				// document.getElementById("total_appshot_good_normal_ee").innerHTML = `<b>${response.total_appshot_good_normal_ee}</b>`;

				// document.getElementById("total_appshot_good_qa").innerHTML = `<b>${response.total_appshot_good_qa}</b>`;
				document.getElementById("total_appshot_good_prio_qa").innerHTML = `<b>${response.total_appshot_good_prio_qa}</b>`;
				document.getElementById("total_appshot_good_prod_prio_qa").innerHTML = `<b>${response.total_appshot_good_prod_prio_qa}</b>`;
				// document.getElementById("total_appshot_good_normal_qa").innerHTML = `<b>${response.total_appshot_good_normal_qa}</b>`;

				document.getElementById("total_shotcnt_u_ee_good").innerHTML = `<b>${response.total_shotcnt_u_ee_good}</b>`;
				document.getElementById("total_shotcnt_d_ee_good").innerHTML = `<b>${response.total_shotcnt_d_ee_good}</b>`;
				// document.getElementById("total_shotcnt_i_u_ee_good").innerHTML = `<b>${response.total_shotcnt_i_u_ee_good}</b>`;
				// document.getElementById("total_shotcnt_i_d_ee_good").innerHTML = `<b>${response.total_shotcnt_i_d_ee_good}</b>`;
				// document.getElementById("total_shotcnt_c_ee_good").innerHTML = `<b>${response.total_shotcnt_c_ee_good}</b>`;

				document.getElementById("total_shotcnt_u_qa_good").innerHTML = `<b>${response.total_shotcnt_u_qa_good}</b>`;
				document.getElementById("total_shotcnt_d_qa_good").innerHTML = `<b>${response.total_shotcnt_d_qa_good}</b>`;
				// document.getElementById("total_shotcnt_i_u_qa_good").innerHTML = `<b>${response.total_shotcnt_i_u_qa_good}</b>`;
				// document.getElementById("total_shotcnt_i_d_qa_good").innerHTML = `<b>${response.total_shotcnt_i_d_qa_good}</b>`;
				// document.getElementById("total_shotcnt_c_qa_good").innerHTML = `<b>${response.total_shotcnt_c_qa_good}</b>`;

				// Exceeded
				// document.getElementById("total_appshot_exceeded_ee").innerHTML = `<b>${response.total_appshot_exceeded_ee}</b>`;
				document.getElementById("total_appshot_exceeded_prio_ee").innerHTML = `<b>${response.total_appshot_exceeded_prio_ee}</b>`;
				document.getElementById("total_appshot_exceeded_prod_prio_ee").innerHTML = `<b>${response.total_appshot_exceeded_prod_prio_ee}</b>`;
				// document.getElementById("total_appshot_exceeded_normal_ee").innerHTML = `<b>${response.total_appshot_exceeded_normal_ee}</b>`;

				// document.getElementById("total_appshot_exceeded_qa").innerHTML = `<b>${response.total_appshot_exceeded_qa}</b>`;
				document.getElementById("total_appshot_exceeded_prio_qa").innerHTML = `<b>${response.total_appshot_exceeded_prio_qa}</b>`;
				document.getElementById("total_appshot_exceeded_prod_prio_qa").innerHTML = `<b>${response.total_appshot_exceeded_prod_prio_qa}</b>`;
				// document.getElementById("total_appshot_exceeded_normal_qa").innerHTML = `<b>${response.total_appshot_exceeded_normal_qa}</b>`;

				document.getElementById("total_shotcnt_u_ee_exceeded").innerHTML = `<b>${response.total_shotcnt_u_ee_exceeded}</b>`;
				document.getElementById("total_shotcnt_d_ee_exceeded").innerHTML = `<b>${response.total_shotcnt_d_ee_exceeded}</b>`;
				// document.getElementById("total_shotcnt_i_u_ee_exceeded").innerHTML = `<b>${response.total_shotcnt_i_u_ee_exceeded}</b>`;
				// document.getElementById("total_shotcnt_i_d_ee_exceeded").innerHTML = `<b>${response.total_shotcnt_i_d_ee_exceeded}</b>`;
				// document.getElementById("total_shotcnt_c_ee_exceeded").innerHTML = `<b>${response.total_shotcnt_c_ee_exceeded}</b>`;

				document.getElementById("total_shotcnt_u_qa_exceeded").innerHTML = `<b>${response.total_shotcnt_u_qa_exceeded}</b>`;
				document.getElementById("total_shotcnt_d_qa_exceeded").innerHTML = `<b>${response.total_shotcnt_d_qa_exceeded}</b>`;
				// document.getElementById("total_shotcnt_i_u_qa_exceeded").innerHTML = `<b>${response.total_shotcnt_i_u_qa_exceeded}</b>`;
				// document.getElementById("total_shotcnt_i_d_qa_exceeded").innerHTML = `<b>${response.total_shotcnt_i_d_qa_exceeded}</b>`;
				// document.getElementById("total_shotcnt_c_qa_exceeded").innerHTML = `<b>${response.total_shotcnt_c_qa_exceeded}</b>`;
			}
		});
	}

	const get_shotcnt_good_vs_exceeded_qa_chart = () => {
		$.ajax({
			url: '../process/applicator_shots/as_dash_g_p.php',
			type: 'GET',
			cache: false,
			dataType: 'json',
			data: {
				method: 'get_shotcnt_good_vs_exceeded_qa_chart'
			},  
			success: response => {
				console.log(response.categories);
				console.log(response.data);

				// Define Bootstrap 4 colors
				// const bootstrapColors = ['#28a745', '#dc3545'];
				const bootstrapColors = ['#dc3545'];

				// Convert the data object to an array
				const seriesData = response.data.map(item => {
					return {
						name: item.name,
						data: Object.values(item.data)
					};
				});

				let ctx = document.querySelector("#shotcnt_good_vs_exceeded_qa_chart");

				var options = {
					chart: {
						type: 'bar',
						height: 350
					},
					plotOptions: {
						bar: {
							horizontal: false,
							columnWidth: '55%'
						},
					},
					dataLabels: {
						enabled: true
					},
					series: seriesData,
					colors: bootstrapColors,
					xaxis: {
						categories: response.categories
					},
					yaxis: {
						title: {
							text: 'Applicator Count'
						}
					},
					title: {
						text: `Applicator Count In 50k Shot Count Exceeded Condition (Wire Crimper or Wire Anvil Only)`,
						align: 'left'
					}
				};

				// Destroy previous chart instance before creating a new one
				if (shotcnt_good_vs_exceeded_qa_chart) {
					shotcnt_good_vs_exceeded_qa_chart.destroy();
				}

				shotcnt_good_vs_exceeded_qa_chart = new ApexCharts(ctx, options);
				shotcnt_good_vs_exceeded_qa_chart.render();
			}
		});
	}

	const get_shotcnt_good_vs_exceeded_ee_chart = () => {
		$.ajax({
			url: '../process/applicator_shots/as_dash_g_p.php',
			type: 'GET',
			cache: false,
			dataType: 'json',
			data: {
				method: 'get_shotcnt_good_vs_exceeded_ee_chart'
			},  
			success: response => {
				console.log(response.categories);
				console.log(response.data);

				// Define Bootstrap 4 colors
				// const bootstrapColors = ['#28a745', '#dc3545'];
				const bootstrapColors = ['#dc3545'];

				// Convert the data object to an array
				const seriesData = response.data.map(item => {
					return {
						name: item.name,
						data: Object.values(item.data)
					};
				});

				let ctx = document.querySelector("#shotcnt_good_vs_exceeded_ee_chart");

				var options = {
					chart: {
						type: 'bar',
						height: 350
					},
					plotOptions: {
						bar: {
							horizontal: false,
							columnWidth: '55%'
						},
					},
					dataLabels: {
						enabled: true
					},
					series: seriesData,
					colors: bootstrapColors,
					xaxis: {
						categories: response.categories
					},
					yaxis: {
						title: {
							text: 'Applicator Count'
						}
					},
					title: {
						text: `Applicator Count In 100k Shot Count Exceeded Condition (Wire Crimper or Wire Anvil Only)`,
						align: 'left'
					}
				};

				// Destroy previous chart instance before creating a new one
				if (shotcnt_good_vs_exceeded_ee_chart) {
					shotcnt_good_vs_exceeded_ee_chart.destroy();
				}

				shotcnt_good_vs_exceeded_ee_chart = new ApexCharts(ctx, options);
				shotcnt_good_vs_exceeded_ee_chart.render();
			}
		});
	}

	const get_shotcnt_exceeded_prio_ee_chart = () => {
		$.ajax({
			url: '../process/applicator_shots/as_dash_g_p.php',
			type: 'GET',
			cache: false,
			dataType: 'json',
			data: {
				method: 'get_shotcnt_exceeded_prio_ee_chart'
			},  
			success: response => {
				console.log(response.categories);
				console.log(response.data);

				// Define Bootstrap 4 colors
				const bootstrapColors = ['#dc3545', '#ffc107', '#28a745'];

				// Convert the data object to an array
				const seriesData = response.data.map(item => {
					return {
						name: item.name,
						data: Object.values(item.data)
					};
				});

				let ctx = document.querySelector("#shotcnt_exceeded_prio_ee_chart");

				var options = {
					chart: {
						type: 'bar',
						height: 350
					},
					plotOptions: {
						bar: {
							horizontal: false,
							columnWidth: '55%'
						},
					},
					dataLabels: {
						enabled: true
					},
					series: seriesData,
					colors: bootstrapColors,
					xaxis: {
						categories: response.categories
					},
					yaxis: {
						title: {
							text: 'Applicator Count'
						}
					},
					title: {
						text: `Applicator Count In 100k Shot Count Exceeded Based On Priority (Wire Crimper or Wire Anvil Only)`,
						align: 'left'
					}
				};

				// Destroy previous chart instance before creating a new one
				if (shotcnt_exceeded_prio_ee_chart) {
					shotcnt_exceeded_prio_ee_chart.destroy();
				}

				shotcnt_exceeded_prio_ee_chart = new ApexCharts(ctx, options);
				shotcnt_exceeded_prio_ee_chart.render();
			}
		});
	}

	const get_shotcnt_exceeded_prio_qa_chart = () => {
		$.ajax({
			url: '../process/applicator_shots/as_dash_g_p.php',
			type: 'GET',
			cache: false,
			dataType: 'json',
			data: {
				method: 'get_shotcnt_exceeded_prio_qa_chart'
			},  
			success: response => {
				console.log(response.categories);
				console.log(response.data);

				// Define Bootstrap 4 colors
				const bootstrapColors = ['#dc3545', '#ffc107', '#28a745'];

				// Convert the data object to an array
				const seriesData = response.data.map(item => {
					return {
						name: item.name,
						data: Object.values(item.data)
					};
				});

				let ctx = document.querySelector("#shotcnt_exceeded_prio_qa_chart");

				var options = {
					chart: {
						type: 'bar',
						height: 350
					},
					plotOptions: {
						bar: {
							horizontal: false,
							columnWidth: '55%'
						},
					},
					dataLabels: {
						enabled: true
					},
					series: seriesData,
					colors: bootstrapColors,
					xaxis: {
						categories: response.categories
					},
					yaxis: {
						title: {
							text: 'Applicator Count'
						}
					},
					title: {
						text: `Applicator Count In 50k Shot Count Exceeded Based On Priority (Wire Crimper or Wire Anvil Only)`,
						align: 'left'
					}
				};

				// Destroy previous chart instance before creating a new one
				if (shotcnt_exceeded_prio_qa_chart) {
					shotcnt_exceeded_prio_qa_chart.destroy();
				}

				shotcnt_exceeded_prio_qa_chart = new ApexCharts(ctx, options);
				shotcnt_exceeded_prio_qa_chart.render();
			}
		});
	}

	const get_shotcnt_exceeded_appstat_ee_chart = () => {
		$.ajax({
			url: '../process/applicator_shots/as_dash_g_p.php',
			type: 'GET',
			cache: false,
			dataType: 'json',
			data: {
				method: 'get_shotcnt_exceeded_appstat_ee_chart'
			},  
			success: response => {
				console.log(response.categories);
				console.log(response.data);

				// Define Bootstrap 4 colors
				// const bootstrapColors = ['#28a745', '#ffc107', '#dc3545'];
				const bootstrapColors = ['#ffc107', '#dc3545'];

				// Convert the data object to an array
				const seriesData = response.data.map(item => {
					return {
						name: item.name,
						data: Object.values(item.data)
					};
				});

				let ctx = document.querySelector("#shotcnt_exceeded_appstat_ee_chart");

				var options = {
					chart: {
						type: 'bar',
						height: 350
					},
					plotOptions: {
						bar: {
							horizontal: false,
							columnWidth: '55%'
						},
					},
					dataLabels: {
						enabled: true
					},
					series: seriesData,
					colors: bootstrapColors,
					xaxis: {
						categories: response.categories
					},
					yaxis: {
						title: {
							text: 'Applicator Count'
						}
					},
					title: {
						text: `Applicator Count In 100k Shot Count Exceeded Based On Applicator List Status (Wire Crimper or Wire Anvil Only)`,
						align: 'left'
					}
				};

				// Destroy previous chart instance before creating a new one
				if (shotcnt_exceeded_appstat_ee_chart) {
					shotcnt_exceeded_appstat_ee_chart.destroy();
				}

				shotcnt_exceeded_appstat_ee_chart = new ApexCharts(ctx, options);
				shotcnt_exceeded_appstat_ee_chart.render();
			}
		});
	}

	const get_shotcnt_exceeded_appstat_qa_chart = () => {
		$.ajax({
			url: '../process/applicator_shots/as_dash_g_p.php',
			type: 'GET',
			cache: false,
			dataType: 'json',
			data: {
				method: 'get_shotcnt_exceeded_appstat_qa_chart'
			},  
			success: response => {
				console.log(response.categories);
				console.log(response.data);

				// Define Bootstrap 4 colors
				// const bootstrapColors = ['#28a745', '#ffc107', '#dc3545'];
				const bootstrapColors = ['#ffc107', '#dc3545'];

				// Convert the data object to an array
				const seriesData = response.data.map(item => {
					return {
						name: item.name,
						data: Object.values(item.data)
					};
				});

				let ctx = document.querySelector("#shotcnt_exceeded_appstat_qa_chart");

				var options = {
					chart: {
						type: 'bar',
						height: 350
					},
					plotOptions: {
						bar: {
							horizontal: false,
							columnWidth: '55%'
						},
					},
					dataLabels: {
						enabled: true
					},
					series: seriesData,
					colors: bootstrapColors,
					xaxis: {
						categories: response.categories
					},
					yaxis: {
						title: {
							text: 'Applicator Count'
						}
					},
					title: {
						text: `Applicator Count In 50k Shot Count Exceeded Based On Applicator List Status (Wire Crimper or Wire Anvil Only)`,
						align: 'left'
					}
				};

				// Destroy previous chart instance before creating a new one
				if (shotcnt_exceeded_appstat_qa_chart) {
					shotcnt_exceeded_appstat_qa_chart.destroy();
				}

				shotcnt_exceeded_appstat_qa_chart = new ApexCharts(ctx, options);
				shotcnt_exceeded_appstat_qa_chart.render();
			}
		});
	}

	const get_shotcnt_u_ranges_chart = () => {
		$.ajax({
			url: '../process/applicator_shots/as_dash_g_p.php',
			type: 'GET',
			cache: false,
			dataType: 'json',
			data: {
				method: 'get_shotcnt_u_ranges_chart'
			},  
			success: response => {
				console.log(response.categories);
				console.log(response.data);

				// Define Bootstrap 4 colors
				const bootstrapColors = ['#27ae60', '#28a745', '#ffc107', '#f39c12', '#e74c3c', '#e74c3c', '#dc3545'];

				// Convert the data object to an array
				const seriesData = response.data.map(item => {
					return {
						name: item.name,
						data: Object.values(item.data)
					};
				});

				let ctx = document.querySelector("#shotcnt_u_ranges_chart");

				var options = {
					chart: {
						type: 'bar',
						stacked: true,
						toolbar: {
							show: true
						}
					},
					series: seriesData,
					colors: bootstrapColors,
					xaxis: {
						categories: response.categories
					},
					yaxis: {
						title: {
							text: 'Applicator Count'
						}
					},
					title: {
						text: `Applicator Count With Wire Crimper Shot Count Accumulated`,
						align: 'left'
					},
					plotOptions: {
						bar: {
							horizontal: false,
							columnWidth: '55%'
						},
					}
				};

				// Destroy previous chart instance before creating a new one
				if (shotcnt_u_ranges_chart) {
					shotcnt_u_ranges_chart.destroy();
				}

				shotcnt_u_ranges_chart = new ApexCharts(ctx, options);
				shotcnt_u_ranges_chart.render();
			}
		});
	}

	const get_shotcnt_d_ranges_chart = () => {
		$.ajax({
			url: '../process/applicator_shots/as_dash_g_p.php',
			type: 'GET',
			cache: false,
			dataType: 'json',
			data: {
				method: 'get_shotcnt_d_ranges_chart'
			},  
			success: response => {
				console.log(response.categories);
				console.log(response.data);

				// Define Bootstrap 4 colors
				const bootstrapColors = ['#27ae60', '#28a745', '#ffc107', '#f39c12', '#e74c3c', '#e74c3c', '#dc3545'];

				// Convert the data object to an array
				const seriesData = response.data.map(item => {
					return {
						name: item.name,
						data: Object.values(item.data)
					};
				});

				let ctx = document.querySelector("#shotcnt_d_ranges_chart");

				var options = {
					chart: {
						type: 'bar',
						stacked: true,
						toolbar: {
							show: true
						}
					},
					series: seriesData,
					colors: bootstrapColors,
					xaxis: {
						categories: response.categories
					},
					yaxis: {
						title: {
							text: 'Applicator Count'
						}
					},
					title: {
						text: `Applicator Count With Wire Anvil Shot Count Accumulated`,
						align: 'left'
					},
					plotOptions: {
						bar: {
							horizontal: false,
							columnWidth: '55%'
						},
					}
				};

				// Destroy previous chart instance before creating a new one
				if (shotcnt_d_ranges_chart) {
					shotcnt_d_ranges_chart.destroy();
				}

				shotcnt_d_ranges_chart = new ApexCharts(ctx, options);
				shotcnt_d_ranges_chart.render();
			}
		});
	}

	const get_shotcnt_i_u_ranges_chart = () => {
		$.ajax({
			url: '../process/applicator_shots/as_dash_g_p.php',
			type: 'GET',
			cache: false,
			dataType: 'json',
			data: {
				method: 'get_shotcnt_i_u_ranges_chart'
			},  
			success: response => {
				console.log(response.categories);
				console.log(response.data);

				// Define Bootstrap 4 colors
				const bootstrapColors = ['#27ae60', '#28a745', '#ffc107', '#f39c12', '#e74c3c', '#e74c3c', '#dc3545'];

				// Convert the data object to an array
				const seriesData = response.data.map(item => {
					return {
						name: item.name,
						data: Object.values(item.data)
					};
				});

				let ctx = document.querySelector("#shotcnt_i_u_ranges_chart");

				var options = {
					chart: {
						type: 'bar',
						stacked: true,
						toolbar: {
							show: true
						}
					},
					series: seriesData,
					colors: bootstrapColors,
					xaxis: {
						categories: response.categories
					},
					yaxis: {
						title: {
							text: 'Applicator Count'
						}
					},
					title: {
						text: `Applicator Count With Insulation Crimper Shot Count Accumulated`,
						align: 'left'
					},
					plotOptions: {
						bar: {
							horizontal: false,
							columnWidth: '55%'
						},
					}
				};

				// Destroy previous chart instance before creating a new one
				if (shotcnt_i_u_ranges_chart) {
					shotcnt_i_u_ranges_chart.destroy();
				}

				shotcnt_i_u_ranges_chart = new ApexCharts(ctx, options);
				shotcnt_i_u_ranges_chart.render();
			}
		});
	}

	const get_shotcnt_i_d_ranges_chart = () => {
		$.ajax({
			url: '../process/applicator_shots/as_dash_g_p.php',
			type: 'GET',
			cache: false,
			dataType: 'json',
			data: {
				method: 'get_shotcnt_i_d_ranges_chart'
			},  
			success: response => {
				console.log(response.categories);
				console.log(response.data);

				// Define Bootstrap 4 colors
				const bootstrapColors = ['#27ae60', '#28a745', '#ffc107', '#f39c12', '#e74c3c', '#e74c3c', '#dc3545'];

				// Convert the data object to an array
				const seriesData = response.data.map(item => {
					return {
						name: item.name,
						data: Object.values(item.data)
					};
				});

				let ctx = document.querySelector("#shotcnt_i_d_ranges_chart");

				var options = {
					chart: {
						type: 'bar',
						stacked: true,
						toolbar: {
							show: true
						}
					},
					series: seriesData,
					colors: bootstrapColors,
					xaxis: {
						categories: response.categories
					},
					yaxis: {
						title: {
							text: 'Applicator Count'
						}
					},
					title: {
						text: `Applicator Count With Insulation Anvil Shot Count Accumulated`,
						align: 'left'
					},
					plotOptions: {
						bar: {
							horizontal: false,
							columnWidth: '55%'
						},
					}
				};

				// Destroy previous chart instance before creating a new one
				if (shotcnt_i_d_ranges_chart) {
					shotcnt_i_d_ranges_chart.destroy();
				}

				shotcnt_i_d_ranges_chart = new ApexCharts(ctx, options);
				shotcnt_i_d_ranges_chart.render();
			}
		});
	}

	const get_shotcnt_c_ranges_chart = () => {
		$.ajax({
			url: '../process/applicator_shots/as_dash_g_p.php',
			type: 'GET',
			cache: false,
			dataType: 'json',
			data: {
				method: 'get_shotcnt_c_ranges_chart'
			},  
			success: response => {
				console.log(response.categories);
				console.log(response.data);

				// Define Bootstrap 4 colors
				const bootstrapColors = ['#27ae60', '#28a745', '#ffc107', '#f39c12', '#e74c3c', '#e74c3c', '#dc3545'];

				// Convert the data object to an array
				const seriesData = response.data.map(item => {
					return {
						name: item.name,
						data: Object.values(item.data)
					};
				});

				let ctx = document.querySelector("#shotcnt_c_ranges_chart");

				var options = {
					chart: {
						type: 'bar',
						stacked: true,
						toolbar: {
							show: true
						}
					},
					series: seriesData,
					colors: bootstrapColors,
					xaxis: {
						categories: response.categories
					},
					yaxis: {
						title: {
							text: 'Applicator Count'
						}
					},
					title: {
						text: `Applicator Count With Slide Cutter Shot Count Accumulated`,
						align: 'left'
					},
					plotOptions: {
						bar: {
							horizontal: false,
							columnWidth: '55%'
						},
					}
				};

				// Destroy previous chart instance before creating a new one
				if (shotcnt_c_ranges_chart) {
					shotcnt_c_ranges_chart.destroy();
				}

				shotcnt_c_ranges_chart = new ApexCharts(ctx, options);
				shotcnt_c_ranges_chart.render();
			}
		});
	}

	let current_hourly_exceeded_charts = [];

	const get_current_hourly_exceeded_chart = () => {
		$.ajax({
			url: '../process/applicator_shots/as_dash_g_p.php',
			type: 'GET',
			cache: false,
			dataType: 'json',
			data: {
				method: 'get_current_hourly_exceeded_chart'
			},  
			success: response => {
				// Clear previous charts
                $('#current_hourly_exceeded_chart').empty();
                current_hourly_exceeded_charts = []; // Reset the arrays of charts

				// Loop through response to generate charts for each maker_model_label
                for (const maker_model_label in response) {
                    // Define Bootstrap 4 colors
				    const bootstrapColors = ['#dc3545'];

                    const maker_model_data = response[maker_model_label];
                    
                    // Create a unique container for each maker_model_label chart
                    const chartId = `chexchart_${maker_model_label.replace(/\s/g, '_')}`; // Create an ID, replace spaces with underscores
                    $('#current_hourly_exceeded_chart').append(`<div class="col-lg-6 col-sm-12" id="${chartId}"></div>`); // Append a new div for the chart

                    // Define options for the chart
                    var options = {
                        chart: {
                            type: 'bar',
                            height: 250
                        },
                        plotOptions: {
                            bar: {
                                horizontal: false,
                                columnWidth: '50%',
                                endingShape: 'flat',
                            },
                        },
                        dataLabels: {
                            enabled: true
                        },
                        series: [{
                            name: maker_model_label, // Use the route name as the series name
                            data: maker_model_data.data
                        }],
                        colors: bootstrapColors,
						yaxis: {
							title: {
								text: 'Applicator Count'
							}
						},
                        xaxis: {
                            categories: maker_model_data.categories
                        },
                        title: {
                            text: `${maker_model_label} Exceeded Count`, // Add specific day context
                            align: 'left'
                        }
                    };

                    // Create and render the chart
                    const ctx = document.querySelector(`#${chartId}`);
                    const chart = new ApexCharts(ctx, options);
                    chart.render();
                    current_hourly_exceeded_charts.push(chart); // Store the chart instance
				}
			}
		});
	}

	let current_week_exceeded_charts = [];

	const get_current_week_exceeded_chart = () => {
		$.ajax({
			url: '../process/applicator_shots/as_dash_g_p.php',
			type: 'GET',
			cache: false,
			dataType: 'json',
			data: {
				method: 'get_current_week_exceeded_chart'
			},  
			success: response => {
				// Clear previous charts
                $('#current_week_exceeded_chart').empty();
                current_week_exceeded_charts = []; // Reset the arrays of charts

				// Loop through response to generate charts for each maker_model_label
                for (const maker_model_label in response) {
					const maker_model_data = response[maker_model_label];

                    // Define Bootstrap 4 colors
				    const bootstrapColors = [maker_model_data.color];

                    // Create a unique container for each maker_model_label chart
                    const chartId = `cwchart_${maker_model_label.replace(/\s/g, '_')}`; // Create an ID, replace spaces with underscores
                    $('#current_week_exceeded_chart').append(`<div class="col-lg-6 col-sm-12" id="${chartId}"></div>`); // Append a new div for the chart

                    // Define options for the chart
                    var options = {
                        chart: {
                            type: 'line',
                            height: 250,
                            toolbar: {
                                show: true
                            }
                        },
                        series: [{
                            name: maker_model_label, // Use the route name as the series name
                            data: maker_model_data.data
                        }],
                        stroke: {
                            width: [5, 5]
                        },
						markers: {
                            size: 4,
                            colors: ['#fff'],
                            strokeColors: '#333',
                            strokeWidth: 2
                        },
						dataLabels: {
                            enabled: true,
                            style: {
                                colors: ['#fff'],
                                fontSize: '13px',
                                fontWeight: 'bold'
                            },
                            background: {
                                enabled: true,
                                foreColor: '#000',
                                borderRadius: 3,
                                padding: 2
                            }
                        },
						xaxis: {
                            categories: maker_model_data.categories
                        },
						yaxis: {
							title: {
								text: 'Applicator Count'
							}
						},
						colors: bootstrapColors,
						legend: {
                            position: 'top',
                            labels: {
                                colors: '#000',
                                fontSize: '14px',
                                fontWeight: 'bold'
                            }
                        },
						tooltip: {
                            shared: true,
                            intersect: false,
                            theme: "light"
                        },
                        title: {
                            text: `${maker_model_label} Exceeded Count`, // Add specific day context
                            align: 'left'
                        }
                    };

                    // Create and render the chart
                    const ctx = document.querySelector(`#${chartId}`);
                    const chart = new ApexCharts(ctx, options);
                    chart.render();
                    current_week_exceeded_charts.push(chart); // Store the chart instance
				}
			}
		});
	}
	
	let current_month_exceeded_charts = [];

	const get_current_month_exceeded_chart = () => {
		$.ajax({
			url: '../process/applicator_shots/as_dash_g_p.php',
			type: 'GET',
			cache: false,
			dataType: 'json',
			data: {
				method: 'get_current_month_exceeded_chart'
			},  
			success: response => {
				current_month_exceeded_charts.forEach(chart => chart.destroy());
				current_month_exceeded_charts = [];

				$("#current_month_exceeded_chart").empty();

				Object.entries(response.data).forEach(([shotCategory, series], index) => {
					const chartId = `current_month_exceeded_chart_${index}`;

					$("#current_month_exceeded_chart").append(`
						<div class="col-lg-6 col-sm-12 mb-3">
							<div class="row">
								<div class="col-12">
									<div id="${chartId}"></div>
								</div>
							</div>
						</div>
					`);

					const colors = series.map(item =>
						response.colorMap[item.name] || "#343a40"
					);

					const options = {
						chart: {
							type: "line",
							height: 300
						},
						series: series,
						colors: colors,
						yaxis: {
							title: {
								text: 'Applicator Count'
							}
						},
						xaxis: {
							categories: response.categories
						},
						title: {
							text: shotCategory,
							align: "left"
						},
						stroke: {
							curve: "straight"
						},
						markers: {
							size: 5
						},
						tooltip: {
							shared: true,
							intersect: false
						}
					};

					const chart = new ApexCharts(
						document.querySelector(`#${chartId}`),
						options
					);

					chart.render();

					current_month_exceeded_charts.push(chart);
				});
			}
		});
	}

	const get_car_maker_dropdown_search = () => {
		$.ajax({
			url: '../process/shop/applicator_list/al_g_p.php',
			type: 'GET',
			cache: false,
			data: {
				method: 'get_car_maker_dropdown_search'
			},  
			success: response => {
				document.getElementById("as_car_maker_search").innerHTML = response;
			}
		});
	}

	const get_car_model_dropdown_search = () => {
		$.ajax({
			url: '../process/shop/applicator_list/al_g_p.php',
			type: 'GET',
			cache: false,
			data: {
				method: 'get_car_model_dropdown_search'
			},  
			success: response => {
				document.getElementById("as_car_model_search").innerHTML = response;
			}
		});
	}

	const get_applicator_no_datalist_search = () => {
		$.ajax({
			url: '../process/shop/applicator_list/al_g_p.php',
			type: 'GET',
			cache: false,
			data: {
				method: 'get_applicator_no_datalist_search'
			},  
			success: response => {
				document.getElementById("as_applicator_no_search_list").innerHTML = response;
			}
		});
	}

	const get_location_datalist_search = () => {
		$.ajax({
			url: '../process/shop/applicator_list/al_g_p.php',
			type: 'GET',
			cache: false,
			data: {
				method: 'get_location_datalist_search'
			},  
			success: response => {
				document.getElementById("as_location_search_list").innerHTML = response;
			}
		});
	}

	var typingTimerAlApplicatorNoSearch;
    var typingTimerAlLocationSearch;
    var doneTypingInterval = 250; // Time in ms

    // On keyup, start the countdown
    document.getElementById("as_applicator_no_search").addEventListener('keyup', e => {
        clearTimeout(typingTimerAlApplicatorNoSearch);
        typingTimerAlApplicatorNoSearch = setTimeout(doneTypingGetRecentApplicatorShots, doneTypingInterval);
    });

    // On keydown, clear the countdown
    document.getElementById("as_applicator_no_search").addEventListener('keydown', e => {
        clearTimeout(typingTimerAlApplicatorNoSearch);
    });

    // On keyup, start the countdown
    document.getElementById("as_location_search").addEventListener('keyup', e => {
        clearTimeout(typingTimerAlLocationSearch);
        typingTimerAlLocationSearch = setTimeout(doneTypingGetRecentApplicatorShots, doneTypingInterval);
    });

    // On keydown, clear the countdown
    document.getElementById("as_location_search").addEventListener('keydown', e => {
        clearTimeout(typingTimerAlLocationSearch);
    });

    // User is "finished typing," do something
    const doneTypingGetRecentApplicatorShots = () => {
        get_recent_applicator_shots();
    }

    const get_recent_applicator_shots = () => {
		let car_maker = document.getElementById('as_car_maker_search').value;
		let car_model = document.getElementById('as_car_model_search').value;
		let status = document.getElementById('as_status_search').value;
		let applicator_no = document.getElementById('as_applicator_no_search').value;
		let location = document.getElementById('as_location_search').value;
		let shot_limit_status = document.getElementById('as_shot_limit_status_search').value;

		sessionStorage.setItem('zs_as_car_maker_search', car_maker);
		sessionStorage.setItem('zs_as_car_model_search', car_model);
		sessionStorage.setItem('zs_as_status_search', status);
		sessionStorage.setItem('zs_as_applicator_no_search', applicator_no);
		sessionStorage.setItem('zs_as_location_search', location);
		sessionStorage.setItem('zs_as_shot_limit_status_search', shot_limit_status);

		$.ajax({
			type: "GET",
			url: "../process/applicator_shots/as_g_p.php",
			cache: false,
			data: {
				method: "get_recent_applicator_shots",
				car_maker: car_maker,
				car_model: car_model,
				status: status,
				applicator_no: applicator_no,
				location: location,
				shot_limit_status: shot_limit_status
			},
			success: (response) => {
                $('#recentApplicatorShotsData').html(response);
				let table_rows = parseInt(document.getElementById("recentApplicatorShotsData").childNodes.length);
				$('#count_view').html("Total: " + table_rows);
			}
		});
	}

	const export_recent_applicator_shots = (table_id, separator = ',') => {
		let car_maker = sessionStorage.getItem('zs_as_car_maker_search');
		let car_model = sessionStorage.getItem('zs_as_car_model_search');
		let status = sessionStorage.getItem('zs_as_status_search');
		let applicator_no = sessionStorage.getItem('zs_as_applicator_no_search');
		let location = sessionStorage.getItem('zs_as_location_search');
		let shot_limit_status = sessionStorage.getItem('zs_as_shot_limit_status_search');

        // Select rows from table_id
        var rows = document.querySelectorAll('table#' + table_id + ' tr');

        // Construct csv
        var csv = [];
        for (var i = 0; i < rows.length; i++) {
            var row = [], cols = rows[i].querySelectorAll('td, th');
            for (var j = 0; j < cols.length; j++) {
                var data = cols[j].innerText.replace(/(\r\n|\n|\r)/gm, '').replace(/(\s\s)/gm, ' ')
                data = data.replace(/"/g, '""');
                // Push escaped string
                row.push('"' + data + '"');
            }
            csv.push(row.join(separator));
        }

        var csv_string = csv.join('\n');

        // Download it
        var filename = 'ZaihaiSystem_ApplicatorShots';
		if (car_maker) {
			filename += '_' + car_maker;
		}
		if (car_model) {
			filename += '_' + car_model;
		}
		if (status) {
			filename += '_' + status;
		}
		if (applicator_no) {
			filename += '_' + applicator_no;
		}
		if (location) {
			filename += '_' + location;
		}
		if (shot_limit_status) {
			filename += '_' + shot_limit_status;
		}
		filename += '_' + new Date().toJSON().slice(0, 10) + '.csv';
        var link = document.createElement('a');
        link.style.display = 'none';
        link.setAttribute('target', '_blank');
        link.setAttribute('href', 'data:text/csv;charset=utf-8,%EF%BB%BF' + encodeURIComponent(csv_string));
        link.setAttribute('download', filename);
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
    }
</script>