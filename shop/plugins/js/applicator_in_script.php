<script type="text/javascript">
    // Global Variables for Realtime
	var realtime_get_recent_applicator_in;

	// DOMContentLoaded function
	document.addEventListener("DOMContentLoaded", () => {
		get_recent_applicator_in();
		realtime_get_recent_applicator_in = setInterval(get_recent_applicator_in, 10000);
	});

    const get_recent_applicator_in = () => {
		$.ajax({
			type: "GET",
			url: "../process/shop/applicator_in_out/aio_g_p.php",
			cache: false,
			data: {
				method: "get_recent_applicator_in"
			},
			success: (response) => {
                $('#recentApplicatorInData').html(response);
				let table_rows = parseInt(document.getElementById("recentApplicatorInData").childNodes.length);
				$('#count_view').html("Total: " + table_rows);
			}
		});
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

	document.getElementById("ai_location_before").addEventListener("change", e => {
		e.preventDefault();
		document.getElementById("ai_location_before").disabled = true;
		document.getElementById("ai_applicator_no").disabled = false;
		document.getElementById("ai_applicator_no").focus();
	});

	document.getElementById("ai_applicator_no").addEventListener("change", e => {
		e.preventDefault();
		document.getElementById("ai_applicator_no").disabled = true;
		document.getElementById("ai_terminal_name").disabled = false;
		document.getElementById("ai_terminal_name").focus();
	});

	document.getElementById("ai_terminal_name").addEventListener("change", e => {
		e.preventDefault();
		document.getElementById("ai_terminal_name").disabled = true;
		in_applicator();
	});

	const reset_applicator_in_fields = () => {
		document.getElementById("ai_location_before").value = '';
		document.getElementById("ai_applicator_no").value = '';
		document.getElementById("ai_terminal_name").value = '';
		document.getElementById("ai_location_before").disabled = false;
		document.getElementById("ai_location_before").focus();
	}

	const display_applicator_in_out_result = (id, type, message) => {
		var duration = 0;
		var error_message = 'Error: ';
		if (type == 'error') {
			duration = 2000;
			message = error_message + message;
			document.getElementById(id).classList.add('text-red');
		} else {
			duration = 3000;
		}
		document.getElementById(id).innerHTML = message;
		setTimeout(() => {
			document.getElementById(id).innerHTML = '';
			document.getElementById(id).classList.remove('text-red');
		}, duration);
	}

	const in_applicator = () => {
		let location_before = document.getElementById("ai_location_before").value;
		let applicator_no = document.getElementById("ai_applicator_no").value;
		let terminal_name = document.getElementById("ai_terminal_name").value;

		$.ajax({
			type: "POST",
			url: "../process/shop/applicator_in_out/aio_p.php",
			cache: false,
			data: {
				method: "in_applicator",
				location_before: location_before,
				applicator_no: applicator_no,
				terminal_name: terminal_name
			},
			success: (response) => {
				if (response == 'success') {
					get_recent_applicator_in();
					display_applicator_in_out_result('in_applicator_result', '', 'Pending Applicator In Succesfully!!!');
				} else {
					display_applicator_in_out_result('in_applicator_result', 'error', response);
				}
				reset_applicator_in_fields();
			}
		});
	}
</script>