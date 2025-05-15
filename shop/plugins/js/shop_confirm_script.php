<script type="text/javascript">
    // Global Variables for Realtime
	var realtime_get_recent_applicator_in_shop_confirm;

    // DOMContentLoaded function
    document.addEventListener("DOMContentLoaded", () => {
		get_applicator_no_datalist_in_search();
		get_terminal_name_datalist_in_search();
		get_location_datalist_in_search();
        get_recent_applicator_in_shop_confirm();
        realtime_get_recent_applicator_in_shop_confirm = setInterval(get_recent_applicator_in_shop_confirm, 30000);
    });

	const get_applicator_no_datalist_in_search = () => {
		$.ajax({
			url: '../process/inspector/applicator_checksheet/ac_g_p.php',
			type: 'GET',
			cache: false,
			data: {
				method: 'get_applicator_no_datalist_in_search',
				page: 'checksheet'
			},  
			success: response => {
				document.getElementById("ai_applicator_no_search_list").innerHTML = response;
			}
		});
	}

	const get_terminal_name_datalist_in_search = () => {
		$.ajax({
			url: '../process/inspector/applicator_checksheet/ac_g_p.php',
			type: 'GET',
			cache: false,
			data: {
				method: 'get_terminal_name_datalist_in_search',
				page: 'checksheet'
			},  
			success: response => {
				document.getElementById("ai_terminal_name_search_list").innerHTML = response;
			}
		});
	}

	const get_location_datalist_in_search = () => {
		$.ajax({
			url: '../process/inspector/applicator_checksheet/ac_g_p.php',
			type: 'GET',
			cache: false,
			data: {
				method: 'get_location_datalist_in_search',
				page: 'checksheet'
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
        typingTimerAiApplicatorNoSearch = setTimeout(doneTypingGetrecentApplicatorInShopConfirm, doneTypingInterval);
    });

    // On keydown, clear the countdown
    document.getElementById("ai_applicator_no_search").addEventListener('keydown', e => {
        clearTimeout(typingTimerAiApplicatorNoSearch);
    });

	// On keyup, start the countdown
    document.getElementById("ai_terminal_name_search").addEventListener('keyup', e => {
        clearTimeout(typingTimerAiTerminalNameSearch);
        typingTimerAiTerminalNameSearch = setTimeout(doneTypingGetrecentApplicatorInShopConfirm, doneTypingInterval);
    });

    // On keydown, clear the countdown
    document.getElementById("ai_terminal_name_search").addEventListener('keydown', e => {
        clearTimeout(typingTimerAiTerminalNameSearch);
    });

    // On keyup, start the countdown
    document.getElementById("ai_location_search").addEventListener('keyup', e => {
        clearTimeout(typingTimerAiLocationSearch);
        typingTimerAiLocationSearch = setTimeout(doneTypingGetrecentApplicatorInShopConfirm, doneTypingInterval);
    });

    // On keydown, clear the countdown
    document.getElementById("ai_location_search").addEventListener('keydown', e => {
        clearTimeout(typingTimerAiLocationSearch);
    });

    // User is "finished typing," do something
    const doneTypingGetrecentApplicatorInShopConfirm = () => {
        get_recent_applicator_in_shop_confirm();
    }

    const get_recent_applicator_in_shop_confirm = () => {
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
				method: "get_recent_applicator_in_shop_confirm",
				car_maker: car_maker,
				car_model: car_model,
				applicator_no: applicator_no,
				terminal_name: terminal_name,
				location: location,
				page: 'shop'
			},
			success: (response) => {
                $('#recentApplicatorInShopConfirmData').html(response);
				let table_rows = parseInt(document.getElementById("recentApplicatorInShopConfirmData").childNodes.length);
				$('#count_view').html("Total: " + table_rows);
			}
		});
	}

	const export_recent_applicator_in_shop_confirm = (table_id, separator = ',') => {
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
        var filename = 'ZaihaiSystem_ApplicatorInNeedShopConfirm';
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

	const get_applicator_in_shop_confirm_details = serial_no => {
        $.ajax({
			url: '../process/inspector/applicator_checksheet/ac_g_p.php',
			type: 'GET',
			cache: false,
			dataType: 'json',
			data: {
				method: 'get_applicator_in_shop_confirm_details',
				serial_no: serial_no
			},  
			success: response => {
				if (response.message == 'success') {
					var serial_no = response.serial_no;
					var equipment_no = response.equipment_no;
					var applicator_no = response.applicator_no;
					var terminal_name = response.terminal_name;
					var inspection_date = response.inspection_date;
					var inspection_time = response.inspection_time;
					var inspection_shift = response.inspection_shift;

					var adjustment_content = response.adjustment_content;
					var adjustment_content_remarks = response.adjustment_content_remarks;
					var cross_section_result = parseInt(response.cross_section_result);
					var inspected_by = response.inspected_by;
					var checked_by = response.checked_by;
					var confirmed_by = response.confirmed_by;
					var judgement = parseInt(response.judgement);

					var ac1 = parseInt(response.ac1);
					var ac2 = parseInt(response.ac2);
					var ac3 = parseInt(response.ac3);
					var ac4 = parseInt(response.ac4);
					var ac5 = parseInt(response.ac5);
					var ac6 = parseInt(response.ac6);
					var ac7 = parseInt(response.ac7);
					var ac8 = parseInt(response.ac8);
					var ac9 = parseInt(response.ac9);
					var ac10 = parseInt(response.ac10);

					var ac1_s = response.ac1_s;
					var ac2_s = response.ac2_s;
					var ac3_s = response.ac3_s;
					var ac4_s = response.ac4_s;
					var ac5_s = response.ac5_s;
					var ac6_s = response.ac6_s;
					var ac7_s = response.ac7_s;
					var ac8_s = response.ac8_s;
					var ac9_s = response.ac9_s;
					var ac10_s = response.ac10_s;

					var ac1_r = response.ac1_r;
					var ac2_r = response.ac2_r;
					var ac3_r = response.ac3_r;
					var ac4_r = response.ac4_r;
					var ac5_r = response.ac5_r;
					var ac6_r = response.ac6_r;
					var ac7_r = response.ac7_r;
					var ac8_r = response.ac8_r;
					var ac9_r = response.ac9_r;
					var ac10_r = response.ac10_r;

					document.getElementById('serial_no_sc').innerHTML = serial_no;
					document.getElementById('equipment_no_sc').innerHTML = equipment_no;
					document.getElementById('machine_no_sc').innerHTML = applicator_no;
					document.getElementById('terminal_name_sc').innerHTML = terminal_name;
					document.getElementById('inspection_date_sc').innerHTML = inspection_date;
					document.getElementById('inspection_time_sc').innerHTML = inspection_time;
					document.getElementById('inspection_shift_sc').innerHTML = inspection_shift;

					document.getElementById('adjustment_content_sc').innerHTML = adjustment_content;
					document.getElementById('adjustment_content_remarks_sc').innerHTML = adjustment_content_remarks;
					document.getElementById('inspected_by_sc').innerHTML = inspected_by;
					document.getElementById('checked_by_sc').innerHTML = checked_by;
					document.getElementById('confirmed_by_no_sc').innerHTML = confirmed_by;

					document.getElementById('cross_section_result_sc').innerHTML = convert_num_to_desc_symbol(cross_section_result);
					document.getElementById('judgement_sc').innerHTML = convert_num_to_desc_symbol(judgement);

					document.getElementById('ac1_sc').innerHTML = convert_num_to_desc_symbol(ac1);
					document.getElementById('ac2_sc').innerHTML = convert_num_to_desc_symbol(ac2);
					document.getElementById('ac3_sc').innerHTML = convert_num_to_desc_symbol(ac3);
					document.getElementById('ac4_sc').innerHTML = convert_num_to_desc_symbol(ac4);
					document.getElementById('ac5_sc').innerHTML = convert_num_to_desc_symbol(ac5);
					document.getElementById('ac6_sc').innerHTML = convert_num_to_desc_symbol(ac6);
					document.getElementById('ac7_sc').innerHTML = convert_num_to_desc_symbol(ac7);
					document.getElementById('ac8_sc').innerHTML = convert_num_to_desc_symbol(ac8);
					document.getElementById('ac9_sc').innerHTML = convert_num_to_desc_symbol(ac9);
					document.getElementById('ac10_sc').innerHTML = convert_num_to_desc_symbol(ac10);

					document.getElementById('cont_1s_sc').innerHTML = ac1_s;
					document.getElementById('cont_2s_sc').innerHTML = ac2_s;
					document.getElementById('cont_3s_sc').innerHTML = ac3_s;
					document.getElementById('cont_4s_sc').innerHTML = ac4_s;
					document.getElementById('cont_5s_sc').innerHTML = ac5_s;
					document.getElementById('cont_6s_sc').innerHTML = ac6_s;
					document.getElementById('cont_7s_sc').innerHTML = ac7_s;
					document.getElementById('cont_8s_sc').innerHTML = ac8_s;
					document.getElementById('cont_9s_sc').innerHTML = ac9_s;
					document.getElementById('cont_10s_sc').innerHTML = ac10_s;

					document.getElementById('cont_1r_sc').innerHTML = 'Replace Details: ' +  ac1_r;
					document.getElementById('cont_2r_sc').innerHTML = 'Replace Details: ' +  ac2_r;
					document.getElementById('cont_3r_sc').innerHTML = 'Replace Details: ' +  ac3_r;
					document.getElementById('cont_4r_sc').innerHTML = 'Replace Details: ' +  ac4_r;
					document.getElementById('cont_5r_sc').innerHTML = 'Replace Details: ' +  ac5_r;
					document.getElementById('cont_6r_sc').innerHTML = 'Replace Details: ' +  ac6_r;
					document.getElementById('cont_7r_sc').innerHTML = 'Replace Details: ' +  ac7_r;
					document.getElementById('cont_8r_sc').innerHTML = 'Replace Details: ' +  ac8_r;
					document.getElementById('cont_9r_sc').innerHTML = 'Replace Details: ' +  ac9_r;
					document.getElementById('cont_10r_sc').innerHTML = 'Replace Details: ' +  ac10_r;

					$("#applicator_checksheet_shop_confirm").modal("show");
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
			}
		});
    }

	document.getElementById('applicator_checksheet_shop_confirm_form').addEventListener('submit', e => {
        e.preventDefault();
        shop_confirm_checksheet();
    });

	const shop_confirm_checksheet = () => {
		let serial_no = document.getElementById("serial_no_sc").innerHTML;

		document.getElementById("btnShopConfirmAc").disabled = true;

		$.ajax({
			type: "POST",
			url: "../process/inspector/applicator_checksheet/ac_p.php",
			cache: false,
			data: {
				method: "shop_confirm_checksheet",
				serial_no: serial_no
			},
			success: (response) => {
				if (response == 'success') {
					$('#applicator_checksheet_shop_confirm').modal("hide");
					get_recent_applicator_in_shop_confirm();
					Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: 'BM Checksheet Confirmed Succesfully!!!',
                        showConfirmButton: false,
                        timer: 2000
                    });
				} else {
					Swal.fire({
                        icon: 'error',
                        title: 'Error !!!',
                        text: 'Error: ' + response,
                        showConfirmButton: false,
                        timer: 5000
                    });
				}
				document.getElementById("btnShopConfirmAc").disabled = false;
			}
		});
	}
</script>