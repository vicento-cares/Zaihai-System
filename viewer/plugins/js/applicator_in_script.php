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
    }
</script>