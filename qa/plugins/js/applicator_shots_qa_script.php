<script type="text/javascript">
    // Global Variables for Realtime
	var realtime_get_recent_applicator_shots_qa;

	// DOMContentLoaded function
	document.addEventListener("DOMContentLoaded", () => {
		get_car_maker_dropdown_search();
		get_car_model_dropdown_search();
		get_applicator_no_datalist_search();
		get_location_datalist_search();
		get_recent_applicator_shots_qa();
		realtime_get_recent_applicator_shots_qa = setInterval(get_recent_applicator_shots_qa, 30000);
	});

	const get_car_maker_dropdown_search = () => {
		$.ajax({
			url: '../process/shop/applicator_list/al_g_p.php',
			type: 'GET',
			cache: false,
			data: {
				method: 'get_car_maker_dropdown_search'
			},  
			success: response => {
				document.getElementById("asqa_car_maker_search").innerHTML = response;
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
				document.getElementById("asqa_car_model_search").innerHTML = response;
			}
		});
	}

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
				document.getElementById("asqa_applicator_no_search_list").innerHTML = response;
			}
		});
	}

	const get_location_datalist_search = () => {
		$.ajax({
			url: '../process/shop/applicator_list/al_g_p.php',
			type: 'GET',
			cache: false,
			data: {
				method: 'get_location_datalist_search',
				page: 'shop'
			},  
			success: response => {
				document.getElementById("asqa_location_search_list").innerHTML = response;
			}
		});
	}

	var typingTimerAlApplicatorNoSearch;
    var typingTimerAlLocationSearch;
    var doneTypingInterval = 250; // Time in ms

    // On keyup, start the countdown
    document.getElementById("asqa_applicator_no_search").addEventListener('keyup', e => {
        clearTimeout(typingTimerAlApplicatorNoSearch);
        typingTimerAlApplicatorNoSearch = setTimeout(doneTypingGetRecentApplicatorShotsQa, doneTypingInterval);
    });

    // On keydown, clear the countdown
    document.getElementById("asqa_applicator_no_search").addEventListener('keydown', e => {
        clearTimeout(typingTimerAlApplicatorNoSearch);
    });

    // On keyup, start the countdown
    document.getElementById("asqa_location_search").addEventListener('keyup', e => {
        clearTimeout(typingTimerAlLocationSearch);
        typingTimerAlLocationSearch = setTimeout(doneTypingGetRecentApplicatorShotsQa, doneTypingInterval);
    });

    // On keydown, clear the countdown
    document.getElementById("asqa_location_search").addEventListener('keydown', e => {
        clearTimeout(typingTimerAlLocationSearch);
    });

    // User is "finished typing," do something
    const doneTypingGetRecentApplicatorShotsQa = () => {
        get_recent_applicator_shots_qa();
    }

    const get_recent_applicator_shots_qa = () => {
		let car_maker = document.getElementById('asqa_car_maker_search').value;
		let car_model = document.getElementById('asqa_car_model_search').value;
		let status = document.getElementById('asqa_status_search').value;
		let applicator_no = document.getElementById('asqa_applicator_no_search').value;
		let location = document.getElementById('asqa_location_search').value;
		let shot_limit_status = document.getElementById('asqa_shot_limit_status_search').value;

		sessionStorage.setItem('zs_asqa_car_maker_search', car_maker);
		sessionStorage.setItem('zs_asqa_car_model_search', car_model);
		sessionStorage.setItem('zs_asqa_status_search', status);
		sessionStorage.setItem('zs_asqa_applicator_no_search', applicator_no);
		sessionStorage.setItem('zs_asqa_location_search', location);
		sessionStorage.setItem('zs_asqa_shot_limit_status_search', shot_limit_status);

		$.ajax({
			type: "GET",
			url: "../process/applicator_shots/as_g_p.php",
			cache: false,
			data: {
				method: "get_recent_applicator_shots_qa",
				car_maker: car_maker,
				car_model: car_model,
				status: status,
				applicator_no: applicator_no,
				location: location,
				shot_limit_status: shot_limit_status
			},
			success: (response) => {
                $('#recentApplicatorShotsQaData').html(response);
				let table_rows = parseInt(document.getElementById("recentApplicatorShotsQaData").childNodes.length);
				$('#count_view').html("Total: " + table_rows);
			}
		});
	}

	const export_recent_applicator_shots_qa = (table_id, separator = ',') => {
		let car_maker = sessionStorage.getItem('zs_asqa_car_maker_search');
		let car_model = sessionStorage.getItem('zs_asqa_car_model_search');
		let status = sessionStorage.getItem('zs_asqa_status_search');
		let applicator_no = sessionStorage.getItem('zs_asqa_applicator_no_search');
		let location = sessionStorage.getItem('zs_asqa_location_search');
		let shot_limit_status = sessionStorage.getItem('zs_asqa_shot_limit_status_search');

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
        var filename = 'ZaihaiSystem_ApplicatorShotsQa';
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

	const clear_log_applicator_appearance_details = () => {
        document.getElementById('asqa_inspected_by').value = '';
        document.getElementById('asqa_inspection_date').value = '';
		document.getElementById('asqa_applicator_no_label').innerHTML = '';

		document.getElementById('asqa_shotcnt_u_qa_status_label').innerHTML = '';
        document.getElementById('asqa_shotcnt_d_qa_status_label').innerHTML = '';
        document.getElementById('asqa_shotcnt_i_u_qa_status_label').innerHTML = '';
        document.getElementById('asqa_shotcnt_i_d_qa_status_label').innerHTML = '';
        document.getElementById('asqa_shotcnt_c_qa_status_label').innerHTML = '';
    }

	$("#log_applicator_appearance").on('hidden.bs.modal', e => {
        clear_log_applicator_appearance_details();
    });

    const get_applicator_shot_qa_details = param => {
		var string = param.split('~!~');
        var applicator_no = string[0];

		var shotcnt_u_qa_status = string[1];
        var shotcnt_d_qa_status = string[2];
        var shotcnt_i_u_qa_status = string[3];
        var shotcnt_i_d_qa_status = string[4];
        var shotcnt_c_qa_status = string[5];

        document.getElementById('asqa_applicator_no').value = applicator_no;
		document.getElementById('asqa_applicator_no_label').innerHTML = applicator_no;

		document.getElementById('asqa_shotcnt_u_qa_status_label').innerHTML = shotcnt_u_qa_status;
        document.getElementById('asqa_shotcnt_d_qa_status_label').innerHTML = shotcnt_d_qa_status;
        document.getElementById('asqa_shotcnt_i_u_qa_status_label').innerHTML = shotcnt_i_u_qa_status;
        document.getElementById('asqa_shotcnt_i_d_qa_status_label').innerHTML = shotcnt_i_d_qa_status;
        document.getElementById('asqa_shotcnt_c_qa_status_label').innerHTML = shotcnt_c_qa_status;
	}

    document.getElementById('log_applicator_appearance_form').addEventListener('submit', e => {
        e.preventDefault();
        log_applicator_appearance();
    });

    const log_applicator_appearance = () => {
        let applicator_no = document.getElementById('asqa_applicator_no').value;
        let inspected_by = document.getElementById('asqa_inspected_by').value;
        let inspection_date = document.getElementById('asqa_inspection_date').value;

        $.ajax({
            url: '../process/applicator_shots/as_p.php',
            type: 'POST',
            cache: false,
            data: {
                method: 'log_applicator_appearance',
                applicator_no: applicator_no,
                inspected_by: inspected_by,
                inspection_date: inspection_date
            }, success: function (response) {
                if (response == 'success') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Succesfully Recorded!!!',
                        text: 'Success',
                        showConfirmButton: false,
                        timer: 1000
                    });
                    get_recent_applicator_shots_qa();
                    $('#log_applicator_appearance').modal('hide');
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