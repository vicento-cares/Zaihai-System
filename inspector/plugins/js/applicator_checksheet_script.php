<script type="text/javascript">
    // Global Variables for Realtime
	var realtime_get_recent_applicator_in_pending;

    // DOMContentLoaded function
    document.addEventListener("DOMContentLoaded", () => {
		get_car_maker_dropdown_in_search();
		get_car_model_dropdown_in_search();
		get_applicator_no_datalist_in_search();
		get_terminal_name_datalist_in_search();
		get_location_datalist_in_search();
        get_recent_applicator_in_pending();
        realtime_get_recent_applicator_in_pending = setInterval(get_recent_applicator_in_pending, 15000);
    });

	const get_car_maker_dropdown_in_search = () => {
		$.ajax({
			url: '../process/shop/applicator_in_out/aio_g_p.php',
			type: 'GET',
			cache: false,
			data: {
				method: 'get_car_maker_dropdown_in_search'
			},  
			success: response => {
				document.getElementById("ai_car_maker_search").innerHTML = response;
			}
		});
	}

	const get_car_model_dropdown_in_search = () => {
		$.ajax({
			url: '../process/shop/applicator_in_out/aio_g_p.php',
			type: 'GET',
			cache: false,
			data: {
				method: 'get_car_model_dropdown_in_search'
			},  
			success: response => {
				document.getElementById("ai_car_model_search").innerHTML = response;
			}
		});
	}

	const get_applicator_no_datalist_in_search = () => {
		$.ajax({
			url: '../process/shop/applicator_in_out/aio_g_p.php',
			type: 'GET',
			cache: false,
			data: {
				method: 'get_applicator_no_datalist_in_search'
			},  
			success: response => {
				document.getElementById("ai_applicator_no_search_list").innerHTML = response;
			}
		});
	}

	const get_terminal_name_datalist_in_search = () => {
		$.ajax({
			url: '../process/shop/applicator_in_out/aio_g_p.php',
			type: 'GET',
			cache: false,
			data: {
				method: 'get_terminal_name_datalist_in_search'
			},  
			success: response => {
				document.getElementById("ai_terminal_name_search_list").innerHTML = response;
			}
		});
	}

	const get_location_datalist_in_search = () => {
		$.ajax({
			url: '../process/shop/applicator_in_out/aio_g_p.php',
			type: 'GET',
			cache: false,
			data: {
				method: 'get_location_datalist_in_search'
			},  
			success: response => {
				document.getElementById("ai_location_search_list").innerHTML = response;
			}
		});
	}

	var typingTimerAiApplicatorNoSearch;
	var typingTimerAiTerminalNameSearch;
    var typingTimerAiLocationSearch;
    var doneTypingInterval = 250; // Time in ms

    // On keyup, start the countdown
    document.getElementById("ai_applicator_no_search").addEventListener('keyup', e => {
        clearTimeout(typingTimerAiApplicatorNoSearch);
        typingTimerAiApplicatorNoSearch = setTimeout(doneTypingGetRecentApplicatorIn, doneTypingInterval);
    });

    // On keydown, clear the countdown
    document.getElementById("ai_applicator_no_search").addEventListener('keydown', e => {
        clearTimeout(typingTimerAiApplicatorNoSearch);
    });

	// On keyup, start the countdown
    document.getElementById("ai_terminal_name_search").addEventListener('keyup', e => {
        clearTimeout(typingTimerAiTerminalNameSearch);
        typingTimerAiTerminalNameSearch = setTimeout(doneTypingGetRecentApplicatorIn, doneTypingInterval);
    });

    // On keydown, clear the countdown
    document.getElementById("ai_terminal_name_search").addEventListener('keydown', e => {
        clearTimeout(typingTimerAiTerminalNameSearch);
    });

    // On keyup, start the countdown
    document.getElementById("ai_location_search").addEventListener('keyup', e => {
        clearTimeout(typingTimerAiLocationSearch);
        typingTimerAiLocationSearch = setTimeout(doneTypingGetRecentApplicatorIn, doneTypingInterval);
    });

    // On keydown, clear the countdown
    document.getElementById("ai_location_search").addEventListener('keydown', e => {
        clearTimeout(typingTimerAiLocationSearch);
    });

    // User is "finished typing," do something
    const doneTypingGetRecentApplicatorIn = () => {
        get_recent_applicator_in_pending();
    }

    const get_recent_applicator_in_pending = () => {
		let car_maker = document.getElementById('ai_car_maker_search').value;
		let car_model = document.getElementById('ai_car_model_search').value;
		let applicator_no = document.getElementById('ai_applicator_no_search').value;
		let terminal_name = document.getElementById('ai_terminal_name_search').value;
		let location = document.getElementById('ai_location_search').value;

		sessionStorage.setItem('zs_ai_car_maker_search', car_maker);
		sessionStorage.setItem('zs_ai_car_model_search', car_model);
		sessionStorage.setItem('zs_ai_applicator_no_search', applicator_no);
		sessionStorage.setItem('zs_ai_terminal_name_search', terminal_name);
		sessionStorage.setItem('zs_ai_location_search', location);

		$.ajax({
			type: "GET",
			url: "../process/inspector/applicator_checksheet/ac_g_p.php",
			cache: false,
			data: {
				method: "get_recent_applicator_in_pending",
				car_maker: car_maker,
				car_model: car_model,
				applicator_no: applicator_no,
				terminal_name: terminal_name,
				location: location
			},
			success: (response) => {
                $('#recentApplicatorInData').html(response);
				let table_rows = parseInt(document.getElementById("recentApplicatorInData").childNodes.length);
				$('#count_view').html("Total: " + table_rows);
			}
		});
	}

	const export_recent_applicator_in_pending = (table_id, separator = ',') => {
		let car_maker = sessionStorage.getItem('zs_ai_car_maker_search');
		let car_model = sessionStorage.getItem('zs_ai_car_model_search');
		let applicator_no = sessionStorage.getItem('zs_ai_applicator_no_search');
		let terminal_name = sessionStorage.getItem('zs_ai_terminal_name_search');
		let location = sessionStorage.getItem('zs_ai_location_search');

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
        var filename = 'ZaihaiSystem_ApplicatorInPending';
		if (car_maker) {
			filename += '_' + car_maker;
		}
		if (car_model) {
			filename += '_' + car_model;
		}
		if (applicator_no) {
			filename += '_' + applicator_no;
		}
		if (terminal_name) {
			filename += '_' + terminal_name;
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

	const convert_num_to_desc_symbol = num => {
		var value = '';
		switch (num) {
			case 1:
				value = '◯';
				break;
			case 2:
				value = '△';
				break;
			case 3:
				value = 'X';
				break;
			case 4:
				value = 'N/A';
				break;
			default:
		}
		return value;
	}

	const get_ac_details = param => {
        var string = param.split('~!~');
        var serial_no = string[0];
        var equipment_no = string[1];
        var applicator_no = string[2];
		var terminal_name = string[3];
        var inspection_date = string[4];
        var inspection_time = string[5];
        var inspection_shift = string[6];

		var adjustment_content = string[7];
		var cross_section_result = parseInt(string[8]);
		var inspected_by = string[9];
		var checked_by = string[10];
		var confirmed_by = string[11];
		var judgement = parseInt(string[12]);

		var ac1 = parseInt(string[13]);
		var ac2 = parseInt(string[14]);
		var ac3 = parseInt(string[15]);
		var ac4 = parseInt(string[16]);
		var ac5 = parseInt(string[17]);
		var ac6 = parseInt(string[18]);
		var ac7 = parseInt(string[19]);
		var ac8 = parseInt(string[20]);
		var ac9 = parseInt(string[21]);
		var ac10 = parseInt(string[22]);

		var ac1_s = string[23];
		var ac2_s = string[24];
		var ac3_s = string[25];
		var ac4_s = string[26];
		var ac5_s = string[27];
		var ac6_s = string[28];
		var ac7_s = string[29];
		var ac8_s = string[30];
		var ac9_s = string[31];
		var ac10_s = string[32];

		var ac1_r = string[33];
		var ac2_r = string[34];
		var ac3_r = string[35];
		var ac4_r = string[36];
		var ac5_r = string[37];
		var ac6_r = string[38];
		var ac7_r = string[39];
		var ac8_r = string[40];
		var ac9_r = string[41];
		var ac10_r = string[42];

        document.getElementById('serial_no_acv').innerHTML = serial_no;
        document.getElementById('equipment_no_acv').innerHTML = equipment_no;
        document.getElementById('machine_no_acv').innerHTML = applicator_no;
		document.getElementById('terminal_name_acv').innerHTML = terminal_name;
        document.getElementById('inspection_date_acv').innerHTML = inspection_date;
        document.getElementById('inspection_time_acv').innerHTML = inspection_time;
        document.getElementById('inspection_shift_acv').innerHTML = inspection_shift;

		document.getElementById('adjustment_content_acv').innerHTML = adjustment_content;
		document.getElementById('inspected_by_acv').innerHTML = inspected_by;
		document.getElementById('checked_by_acv').innerHTML = checked_by;
		document.getElementById('confirmed_by_no_acv').innerHTML = confirmed_by;

		document.getElementById('cross_section_result_acv').innerHTML = convert_num_to_desc_symbol(cross_section_result);
		document.getElementById('judgement_acv').innerHTML = convert_num_to_desc_symbol(judgement);

		document.getElementById('ac1_acv').innerHTML = convert_num_to_desc_symbol(ac1);
		document.getElementById('ac2_acv').innerHTML = convert_num_to_desc_symbol(ac2);
		document.getElementById('ac3_acv').innerHTML = convert_num_to_desc_symbol(ac3);
		document.getElementById('ac4_acv').innerHTML = convert_num_to_desc_symbol(ac4);
		document.getElementById('ac5_acv').innerHTML = convert_num_to_desc_symbol(ac5);
		document.getElementById('ac6_acv').innerHTML = convert_num_to_desc_symbol(ac6);
		document.getElementById('ac7_acv').innerHTML = convert_num_to_desc_symbol(ac7);
		document.getElementById('ac8_acv').innerHTML = convert_num_to_desc_symbol(ac8);
		document.getElementById('ac9_acv').innerHTML = convert_num_to_desc_symbol(ac9);
		document.getElementById('ac10_acv').innerHTML = convert_num_to_desc_symbol(ac10);

		document.getElementById('cont_1s_acv').innerHTML = ac1_s;
		document.getElementById('cont_2s_acv').innerHTML = ac2_s;
		document.getElementById('cont_3s_acv').innerHTML = ac3_s;
		document.getElementById('cont_4s_acv').innerHTML = ac4_s;
		document.getElementById('cont_5s_acv').innerHTML = ac5_s;
		document.getElementById('cont_6s_acv').innerHTML = ac6_s;
		document.getElementById('cont_7s_acv').innerHTML = ac7_s;
		document.getElementById('cont_8s_acv').innerHTML = ac8_s;
		document.getElementById('cont_9s_acv').innerHTML = ac9_s;
		document.getElementById('cont_10s_acv').innerHTML = ac10_s;

		document.getElementById('cont_1r_acv').innerHTML += ac1_r;
		document.getElementById('cont_2r_acv').innerHTML += ac2_r;
		document.getElementById('cont_3r_acv').innerHTML += ac3_r;
		document.getElementById('cont_4r_acv').innerHTML += ac4_r;
		document.getElementById('cont_5r_acv').innerHTML += ac5_r;
		document.getElementById('cont_6r_acv').innerHTML += ac6_r;
		document.getElementById('cont_7r_acv').innerHTML += ac7_r;
		document.getElementById('cont_8r_acv').innerHTML += ac8_r;
		document.getElementById('cont_9r_acv').innerHTML += ac9_r;
		document.getElementById('cont_10r_acv').innerHTML += ac10_r;
    }

    const get_applicator_in_pending_details = param => {
        var string = param.split('~!~');
        var applicator_no = string[0];
        var terminal_name = string[1];
        var location_before = string[2];

		$.ajax({
			type: "GET",
			url: "../process/shop/applicator_in_out/aio_g_p.php",
			cache: false,
			data: {
				method: "get_applicator_in_pending_details",
				applicator_no: applicator_no,
				terminal_name: terminal_name,
				location_before: location_before
			},
			success: (response) => {
				try {
                    let response_array = JSON.parse(response);
                    if (response_array.message == 'success') {
                        document.getElementById('serial_no_ac_i').innerHTML = response_array.serial_no;
						document.getElementById('equipment_no_ac_i').innerHTML = response_array.equipment_no;
                        document.getElementById('machine_no_split_ac_i').innerHTML = response_array.applicator_no;
						document.getElementById('machine_no_ac_i').value = applicator_no;
						document.getElementById('terminal_name_ac_i').innerHTML = response_array.terminal_name;
						document.getElementById('inspection_date_time_ac_i').value = response_array.inspection_date_time;
						document.getElementById('inspection_date_ac_i').innerHTML = response_array.inspection_date;
						document.getElementById('inspection_time_ac_i').innerHTML = response_array.inspection_time;
						document.getElementById('inspection_shift_ac_i').innerHTML = response_array.inspection_shift;
						document.getElementById('inspected_by_ac_i').innerHTML = response_array.inspected_by;
						document.getElementById('inspected_by_no_ac_i').value = response_array.inspected_by_no;
						$('#applicator_checksheet').modal("show");
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error !!!',
                            text: 'Error: ' + response_array.message,
                            showConfirmButton: false,
                            timer: 2000
                        });
                        console.log(response);
                    }
                } catch (e) {
                    console.log(response);
                }
			}
		});
	}

	$("#applicator_checksheet").on('show.bs.modal', e => {
        load_adjustment_content_textarea();
    });

    const load_adjustment_content_textarea = () => {
        setTimeout(() => {
            var max_length = document.getElementById("adjustment_content_ac_i").getAttribute("maxlength");
            var adjustment_content_length = document.getElementById("adjustment_content_ac_i").value.length;
            var adjustment_content_count = `${adjustment_content_length} / ${max_length}`;
            document.getElementById("adjustment_content_ac_i_count").innerHTML = adjustment_content_count;
        }, 100);
    }

    const count_adjustment_content_char = () => {
        var max_length = document.getElementById("adjustment_content_ac_i").getAttribute("maxlength");
        var adjustment_content_length = document.getElementById("adjustment_content_ac_i").value.length;
        var adjustment_content_count = `${adjustment_content_length} / ${max_length}`;
        document.getElementById("adjustment_content_ac_i_count").innerHTML = adjustment_content_count;
    }

	const clear_checked_radio_button = name => {
		var element = document.getElementsByName(name);
		for (var i = 0; i < element.length; i++) {
			element[i].checked = false;
		}
	}

	// Radio Button Value Checker 1
	var cont_1_ac_i = document.getElementsByName("cont_1_ac_i");
	var prev_cont_1_ac_i = null;
	for (var i = 0; i < cont_1_ac_i.length; i++) {
		cont_1_ac_i[i].addEventListener('change', function() {
			if (this !== prev_cont_1_ac_i) {
				prev_cont_1_ac_i = this;
			}
			document.getElementById("cont_1s_ac_i").value = '';
			document.getElementById("cont_1r_ac_i").value = '';
			if (this.value == 2) {
				document.getElementById("cont_1s_ac_i").disabled = false;
				document.getElementById("cont_1r_ac_i").disabled = false;
			} else if (this.value == 3) {
				document.getElementById("cont_1s_ac_i").disabled = true;
				document.getElementById("cont_1r_ac_i").disabled = false;
			} else {
				document.getElementById("cont_1s_ac_i").disabled = true;
				document.getElementById("cont_1r_ac_i").disabled = true;
			}
		});
	}

	// Radio Button Value Checker 2
	var cont_2_ac_i = document.getElementsByName("cont_2_ac_i");
	var prev_cont_2_ac_i = null;
	for (var i = 0; i < cont_2_ac_i.length; i++) {
		cont_2_ac_i[i].addEventListener('change', function() {
			if (this !== prev_cont_2_ac_i) {
				prev_cont_2_ac_i = this;
			}
			document.getElementById("cont_2s_ac_i").value = '';
			document.getElementById("cont_2r_ac_i").value = '';
			if (this.value == 2) {
				document.getElementById("cont_2s_ac_i").disabled = false;
				document.getElementById("cont_2r_ac_i").disabled = false;
			} else if (this.value == 3) {
				document.getElementById("cont_2s_ac_i").disabled = true;
				document.getElementById("cont_2r_ac_i").disabled = false;
			} else {
				document.getElementById("cont_2s_ac_i").disabled = true;
				document.getElementById("cont_2r_ac_i").disabled = true;
			}
		});
	}

	// Radio Button Value Checker 3
	var cont_3_ac_i = document.getElementsByName("cont_3_ac_i");
	var prev_cont_3_ac_i = null;
	for (var i = 0; i < cont_3_ac_i.length; i++) {
		cont_3_ac_i[i].addEventListener('change', function() {
			if (this !== prev_cont_3_ac_i) {
				prev_cont_3_ac_i = this;
			}
			document.getElementById("cont_3s_ac_i").value = '';
			document.getElementById("cont_3r_ac_i").value = '';
			if (this.value == 2) {
				document.getElementById("cont_3s_ac_i").disabled = false;
				document.getElementById("cont_3r_ac_i").disabled = false;
			} else if (this.value == 3) {
				document.getElementById("cont_3s_ac_i").disabled = true;
				document.getElementById("cont_3r_ac_i").disabled = false;
			} else {
				document.getElementById("cont_3s_ac_i").disabled = true;
				document.getElementById("cont_3r_ac_i").disabled = true;
			}
		});
	}

	// Radio Button Value Checker 4
	var cont_4_ac_i = document.getElementsByName("cont_4_ac_i");
	var prev_cont_4_ac_i = null;
	for (var i = 0; i < cont_4_ac_i.length; i++) {
		cont_4_ac_i[i].addEventListener('change', function() {
			if (this !== prev_cont_4_ac_i) {
				prev_cont_4_ac_i = this;
			}
			document.getElementById("cont_4s_ac_i").value = '';
			document.getElementById("cont_4r_ac_i").value = '';
			if (this.value == 2) {
				document.getElementById("cont_4s_ac_i").disabled = false;
				document.getElementById("cont_4r_ac_i").disabled = false;
			} else if (this.value == 3) {
				document.getElementById("cont_4s_ac_i").disabled = true;
				document.getElementById("cont_4r_ac_i").disabled = false;
			} else {
				document.getElementById("cont_4s_ac_i").disabled = true;
				document.getElementById("cont_4r_ac_i").disabled = true;
			}
		});
	}

	// Radio Button Value Checker 5
	var cont_5_ac_i = document.getElementsByName("cont_5_ac_i");
	var prev_cont_5_ac_i = null;
	for (var i = 0; i < cont_5_ac_i.length; i++) {
		cont_5_ac_i[i].addEventListener('change', function() {
			if (this !== prev_cont_5_ac_i) {
				prev_cont_5_ac_i = this;
			}
			document.getElementById("cont_5s_ac_i").value = '';
			document.getElementById("cont_5r_ac_i").value = '';
			if (this.value == 2) {
				document.getElementById("cont_5s_ac_i").disabled = false;
				document.getElementById("cont_5r_ac_i").disabled = false;
			} else if (this.value == 3) {
				document.getElementById("cont_5s_ac_i").disabled = true;
				document.getElementById("cont_5r_ac_i").disabled = false;
			} else {
				document.getElementById("cont_5s_ac_i").disabled = true;
				document.getElementById("cont_5r_ac_i").disabled = true;
			}
		});
	}

	// Radio Button Value Checker 6
	var cont_6_ac_i = document.getElementsByName("cont_6_ac_i");
	var prev_cont_6_ac_i = null;
	for (var i = 0; i < cont_6_ac_i.length; i++) {
		cont_6_ac_i[i].addEventListener('change', function() {
			if (this !== prev_cont_6_ac_i) {
				prev_cont_6_ac_i = this;
			}
			document.getElementById("cont_6s_ac_i").value = '';
			document.getElementById("cont_6r_ac_i").value = '';
			if (this.value == 2) {
				document.getElementById("cont_6s_ac_i").disabled = false;
				document.getElementById("cont_6r_ac_i").disabled = false;
			} else if (this.value == 3) {
				document.getElementById("cont_6s_ac_i").disabled = true;
				document.getElementById("cont_6r_ac_i").disabled = false;
			} else {
				document.getElementById("cont_6s_ac_i").disabled = true;
				document.getElementById("cont_6r_ac_i").disabled = true;
			}
		});
	}

	// Radio Button Value Checker 7
	var cont_7_ac_i = document.getElementsByName("cont_7_ac_i");
	var prev_cont_7_ac_i = null;
	for (var i = 0; i < cont_7_ac_i.length; i++) {
		cont_7_ac_i[i].addEventListener('change', function() {
			if (this !== prev_cont_7_ac_i) {
				prev_cont_7_ac_i = this;
			}
			document.getElementById("cont_7s_ac_i").value = '';
			document.getElementById("cont_7r_ac_i").value = '';
			if (this.value == 2) {
				document.getElementById("cont_7s_ac_i").disabled = false;
				document.getElementById("cont_7r_ac_i").disabled = false;
			} else if (this.value == 3) {
				document.getElementById("cont_7s_ac_i").disabled = true;
				document.getElementById("cont_7r_ac_i").disabled = false;
			} else {
				document.getElementById("cont_7s_ac_i").disabled = true;
				document.getElementById("cont_7r_ac_i").disabled = true;
			}
		});
	}

	// Radio Button Value Checker 8
	var cont_8_ac_i = document.getElementsByName("cont_8_ac_i");
	var prev_cont_8_ac_i = null;
	for (var i = 0; i < cont_8_ac_i.length; i++) {
		cont_8_ac_i[i].addEventListener('change', function() {
			if (this !== prev_cont_8_ac_i) {
				prev_cont_8_ac_i = this;
			}
			document.getElementById("cont_8s_ac_i").value = '';
			document.getElementById("cont_8r_ac_i").value = '';
			if (this.value == 2) {
				document.getElementById("cont_8s_ac_i").disabled = false;
				document.getElementById("cont_8r_ac_i").disabled = false;
			} else if (this.value == 3) {
				document.getElementById("cont_8s_ac_i").disabled = true;
				document.getElementById("cont_8r_ac_i").disabled = false;
			} else {
				document.getElementById("cont_8s_ac_i").disabled = true;
				document.getElementById("cont_8r_ac_i").disabled = true;
			}
		});
	}

	// Radio Button Value Checker 9
	var cont_9_ac_i = document.getElementsByName("cont_9_ac_i");
	var prev_cont_9_ac_i = null;
	for (var i = 0; i < cont_9_ac_i.length; i++) {
		cont_9_ac_i[i].addEventListener('change', function() {
			if (this !== prev_cont_9_ac_i) {
				prev_cont_9_ac_i = this;
			}
			document.getElementById("cont_9s_ac_i").value = '';
			document.getElementById("cont_9r_ac_i").value = '';
			if (this.value == 2) {
				document.getElementById("cont_9s_ac_i").disabled = false;
				document.getElementById("cont_9r_ac_i").disabled = false;
			} else if (this.value == 3) {
				document.getElementById("cont_9s_ac_i").disabled = true;
				document.getElementById("cont_9r_ac_i").disabled = false;
			} else {
				document.getElementById("cont_9s_ac_i").disabled = true;
				document.getElementById("cont_9r_ac_i").disabled = true;
			}
		});
	}

	// Radio Button Value Checker 10
	var cont_10_ac_i = document.getElementsByName("cont_10_ac_i");
	var prev_cont_10_ac_i = null;
	for (var i = 0; i < cont_10_ac_i.length; i++) {
		cont_10_ac_i[i].addEventListener('change', function() {
			if (this !== prev_cont_10_ac_i) {
				prev_cont_10_ac_i = this;
			}
			document.getElementById("cont_10s_ac_i").value = '';
			document.getElementById("cont_10r_ac_i").value = '';
			if (this.value == 2) {
				document.getElementById("cont_10s_ac_i").disabled = false;
				document.getElementById("cont_10r_ac_i").disabled = false;
			} else if (this.value == 3) {
				document.getElementById("cont_10s_ac_i").disabled = true;
				document.getElementById("cont_10r_ac_i").disabled = false;
			} else {
				document.getElementById("cont_10s_ac_i").disabled = true;
				document.getElementById("cont_10r_ac_i").disabled = true;
			}
		});
	}

	$("#applicator_checksheet").on('hidden.bs.modal', e => {
		document.getElementById('ai_location').value = '';

		var radio_button_arr = ["cont_1_ac_i", "cont_2_ac_i", "cont_3_ac_i", "cont_4_ac_i", "cont_5_ac_i", "cont_6_ac_i", "cont_7_ac_i", "cont_8_ac_i", "cont_9_ac_i", "cont_10_ac_i"];
		for (var i = 0; i < radio_button_arr.length; i++) {
			clear_checked_radio_button(radio_button_arr[i]);
		}

		var radio_button_arr = ["cont_1s_ac_i", "cont_2s_ac_i", "cont_3s_ac_i", "cont_4s_ac_i", "cont_5s_ac_i", "cont_6s_ac_i", "cont_7s_ac_i", "cont_8s_ac_i", "cont_9s_ac_i", "cont_10s_ac_i"];
		for (var i = 0; i < radio_button_arr.length; i++) {
			document.getElementById(radio_button_arr[i]).value = '';
			document.getElementById(radio_button_arr[i]).disabled = true;
		}

		var radio_button_arr = ["cont_1r_ac_i", "cont_2r_ac_i", "cont_3r_ac_i", "cont_4r_ac_i", "cont_5r_ac_i", "cont_6r_ac_i", "cont_7r_ac_i", "cont_8r_ac_i", "cont_9r_ac_i", "cont_10r_ac_i"];
		for (var i = 0; i < radio_button_arr.length; i++) {
			document.getElementById(radio_button_arr[i]).value = '';
			document.getElementById(radio_button_arr[i]).disabled = true;
		}

        document.getElementById('adjustment_content_ac_i').value = '';
		clear_checked_radio_button("cross_section_result_ac_i");
    });

	document.getElementById('applicator_checksheet_form').addEventListener('submit', e => {
        e.preventDefault();
        make_checksheet();
    });

	const get_checked_radio_button = name => {
		var element = document.getElementsByName(name);
		var value = '';
		for (var i = 0; i < element.length; i++) {
			if (element[i].checked)
				value = element[i].value;
		}
		return value;
	}

	const make_checksheet = () => {
		let location = document.getElementById("ai_location").value;
		let applicator_no = document.getElementById("machine_no_ac_i").value;
		let terminal_name = document.getElementById("terminal_name_ac_i").innerHTML;

		let serial_no = document.getElementById("serial_no_ac_i").innerHTML;
		let equipment_no = document.getElementById("equipment_no_ac_i").innerHTML;
		let inspection_date_time = document.getElementById("inspection_date_time_ac_i").value;
		let inspection_shift = document.getElementById("inspection_shift_ac_i").innerHTML;

		let ac1 = parseInt(get_checked_radio_button("cont_1_ac_i"));
		let ac2 = parseInt(get_checked_radio_button("cont_2_ac_i"));
		let ac3 = parseInt(get_checked_radio_button("cont_3_ac_i"));
		let ac4 = parseInt(get_checked_radio_button("cont_4_ac_i"));
		let ac5 = parseInt(get_checked_radio_button("cont_5_ac_i"));
		let ac6 = parseInt(get_checked_radio_button("cont_6_ac_i"));
		let ac7 = parseInt(get_checked_radio_button("cont_7_ac_i"));
		let ac8 = parseInt(get_checked_radio_button("cont_8_ac_i"));
		let ac9 = parseInt(get_checked_radio_button("cont_9_ac_i"));
		let ac10 = parseInt(get_checked_radio_button("cont_10_ac_i"));

		let ac1_s = document.getElementById("cont_1s_ac_i").value;
		let ac2_s = document.getElementById("cont_2s_ac_i").value;
		let ac3_s = document.getElementById("cont_3s_ac_i").value;
		let ac4_s = document.getElementById("cont_4s_ac_i").value;
		let ac5_s = document.getElementById("cont_5s_ac_i").value;
		let ac6_s = document.getElementById("cont_6s_ac_i").value;
		let ac7_s = document.getElementById("cont_7s_ac_i").value;
		let ac8_s = document.getElementById("cont_8s_ac_i").value;
		let ac9_s = document.getElementById("cont_9s_ac_i").value;
		let ac10_s = document.getElementById("cont_10s_ac_i").value;

		let ac1_r = document.getElementById("cont_1r_ac_i").value;
		let ac2_r = document.getElementById("cont_2r_ac_i").value;
		let ac3_r = document.getElementById("cont_3r_ac_i").value;
		let ac4_r = document.getElementById("cont_4r_ac_i").value;
		let ac5_r = document.getElementById("cont_5r_ac_i").value;
		let ac6_r = document.getElementById("cont_6r_ac_i").value;
		let ac7_r = document.getElementById("cont_7r_ac_i").value;
		let ac8_r = document.getElementById("cont_8r_ac_i").value;
		let ac9_r = document.getElementById("cont_9r_ac_i").value;
		let ac10_r = document.getElementById("cont_10r_ac_i").value;

		let adjustment_content = document.getElementById("adjustment_content_ac_i").value;
		let cross_section_result = parseInt(get_checked_radio_button("cross_section_result_ac_i"));
		let inspected_by = document.getElementById("inspected_by_ac_i").innerHTML;
		let inspected_by_no = document.getElementById("inspected_by_no_ac_i").value;

		$.ajax({
			type: "POST",
			url: "../process/inspector/applicator_checksheet/ac_p.php",
			cache: false,
			data: {
				method: "make_checksheet",
				location: location,
				applicator_no: applicator_no,
				terminal_name: terminal_name,
				serial_no: serial_no,
				equipment_no: equipment_no,
				inspection_date_time: inspection_date_time,
				inspection_shift: inspection_shift,
				adjustment_content: adjustment_content,
				cross_section_result: cross_section_result,
				inspected_by: inspected_by,
				inspected_by_no: inspected_by_no,
				ac1: ac1,
				ac2: ac2,
				ac3: ac3,
				ac4: ac4,
				ac5: ac5,
				ac6: ac6,
				ac7: ac7,
				ac8: ac8,
				ac9: ac9,
				ac10: ac10,
				ac1_s: ac1_s,
				ac2_s: ac2_s,
				ac3_s: ac3_s,
				ac4_s: ac4_s,
				ac5_s: ac5_s,
				ac6_s: ac6_s,
				ac7_s: ac7_s,
				ac8_s: ac8_s,
				ac9_s: ac9_s,
				ac10_s: ac10_s,
				ac1_r: ac1_r,
				ac2_r: ac2_r,
				ac3_r: ac3_r,
				ac4_r: ac4_r,
				ac5_r: ac5_r,
				ac6_r: ac6_r,
				ac7_r: ac7_r,
				ac8_r: ac8_r,
				ac9_r: ac9_r,
				ac10_r: ac10_r
			},
			success: (response) => {
				if (response == 'success') {
					$('#applicator_checksheet').modal("hide");
					get_recent_applicator_in_pending();
					Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: 'Make Checksheet Done Succesfully!!!',
                        showConfirmButton: false,
                        timer: 2000
                    });
				} else {
					Swal.fire({
                        icon: 'error',
                        title: 'Error !!!',
                        text: 'Error: ' + response,
                        showConfirmButton: false,
                        timer: 2000
                    });
				}
			}
		});
	}
</script>