<script type="text/javascript">
    // Global Variables for Realtime
	var realtime_get_recent_applicator_shots_mc;

	// DOMContentLoaded function
	document.addEventListener("DOMContentLoaded", () => {
		// get_car_maker_dropdown_search();
		// get_car_model_dropdown_search();
		get_applicator_no_datalist_search();
		get_recent_applicator_shots_mc();
		realtime_get_recent_applicator_shots_mc = setInterval(get_recent_applicator_shots_mc, 30000);
	});

	// const get_car_maker_dropdown_search = () => {
	// 	$.ajax({
	// 		url: '../process/shop/applicator_list/al_g_p.php',
	// 		type: 'GET',
	// 		cache: false,
	// 		data: {
	// 			method: 'get_car_maker_dropdown_search'
	// 		},  
	// 		success: response => {
	// 			document.getElementById("asmc_car_maker_search").innerHTML = response;
	// 		}
	// 	});
	// }

	// const get_car_model_dropdown_search = () => {
	// 	$.ajax({
	// 		url: '../process/shop/applicator_list/al_g_p.php',
	// 		type: 'GET',
	// 		cache: false,
	// 		data: {
	// 			method: 'get_car_model_dropdown_search'
	// 		},  
	// 		success: response => {
	// 			document.getElementById("asmc_car_model_search").innerHTML = response;
	// 		}
	// 	});
	// }

	const get_applicator_no_datalist_search = () => {
		$.ajax({
			url: '../process/shop/applicator_list/al_g_p.php',
			type: 'GET',
			cache: false,
			data: {
				method: 'get_applicator_no_datalist_search',
				page: 'shop'
			},  
			success: response => {
				document.getElementById("asmc_applicator_no_search_list").innerHTML = response;
			}
		});
	}

	var typingTimerAlApplicatorNoSearch;
    var doneTypingInterval = 250; // Time in ms

    // On keyup, start the countdown
    document.getElementById("asmc_applicator_no_search").addEventListener('keyup', e => {
        clearTimeout(typingTimerAlApplicatorNoSearch);
        typingTimerAlApplicatorNoSearch = setTimeout(doneTypingGetRecentApplicatorShotsMc, doneTypingInterval);
    });

    // On keydown, clear the countdown
    document.getElementById("asmc_applicator_no_search").addEventListener('keydown', e => {
        clearTimeout(typingTimerAlApplicatorNoSearch);
    });

    // User is "finished typing," do something
    const doneTypingGetRecentApplicatorShotsMc = () => {
        get_recent_applicator_shots_mc();
    }

    const get_recent_applicator_shots_mc = () => {
		let car_maker = document.getElementById('asmc_car_maker_search').value;
		let car_model = document.getElementById('asmc_car_model_search').value;
		let applicator_no = document.getElementById('asmc_applicator_no_search').value;

		sessionStorage.setItem('zs_asmc_car_maker_search', car_maker);
		sessionStorage.setItem('zs_asmc_car_model_search', car_model);
		sessionStorage.setItem('zs_asmc_applicator_no_search', applicator_no);

		$.ajax({
			type: "GET",
			url: "../process/applicator_shots/as_g_p.php",
			cache: false,
			data: {
				method: "get_recent_applicator_shots_mc",
				car_maker: car_maker,
				car_model: car_model,
				applicator_no: applicator_no
			},
			success: (response) => {
                $('#recentApplicatorShotsMcData').html(response);
				let table_rows = parseInt(document.getElementById("recentApplicatorShotsMcData").childNodes.length);
				$('#count_view').html("Total: " + table_rows);
			}
		});
	}

	const export_recent_applicator_shots_mc = (table_id, separator = ',') => {
		let car_maker = sessionStorage.getItem('zs_asmc_car_maker_search');
		let car_model = sessionStorage.getItem('zs_asmc_car_model_search');
		let applicator_no = sessionStorage.getItem('zs_asmc_applicator_no_search');

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
        var filename = 'ZaihaiSystem_ApplicatorShotsMc';
		if (car_maker) {
			filename += '_' + car_maker;
		}
		if (car_model) {
			filename += '_' + car_model;
		}
		if (applicator_no) {
			filename += '_' + applicator_no;
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

	const clear_log_applicator_maintenance_details = () => {
        document.getElementById('asmc_maitenance_by').value = '';
        document.getElementById('asmc_maitenance_date').value = '';
    }

	$("#log_applicator_maintenance").on('hidden.bs.modal', e => {
        clear_log_applicator_maintenance_details();
    });

    const get_applicator_shot_mc_details = param => {
		var string = param.split('~!~');
        var id = string[0];
        var applicator_no = string[1];

        document.getElementById('asmc_id').value = id;
        document.getElementById('asmc_applicator_no').value = applicator_no;
	}

    document.getElementById('log_applicator_maintenance_form').addEventListener('submit', e => {
        e.preventDefault();
        log_applicator_maintenance();
    });

    const log_applicator_maintenance = () => {
        let id = document.getElementById('asmc_id').value;
        let applicator_no = document.getElementById('asmc_applicator_no').value;
        let maintenance_by = document.getElementById('asmc_maitenance_by').value;
        let maintenance_date = document.getElementById('asmc_maitenance_date').value;

        $.ajax({
            url: '../process/applicator_shots/as_p.php',
            type: 'POST',
            cache: false,
            data: {
                method: 'log_applicator_maintenance',
                id: id,
                applicator_no: applicator_no,
                maintenance_by: maintenance_by,
                maintenance_date: maintenance_date
            }, success: function (response) {
                if (response == 'success') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Succesfully Recorded!!!',
                        text: 'Success',
                        showConfirmButton: false,
                        timer: 1000
                    });
                    get_recent_applicator_shots_mc();
                    $('#log_applicator_maintenance').modal('hide');
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error !!!',
                        text: 'Error',
                        showConfirmButton: false,
                        timer: 2000
                    });
                }
            }
        });
    }
</script>