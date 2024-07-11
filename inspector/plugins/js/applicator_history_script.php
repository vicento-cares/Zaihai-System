<script type="text/javascript">
	// DOMContentLoaded function
	document.addEventListener("DOMContentLoaded", () => {
		// get_applicator_history();
		get_car_maker_dropdown_search();
		get_car_model_dropdown_search();
		get_applicator_no_datalist_search();
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
				document.getElementById("aioh_car_maker_search").innerHTML = response;
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
				document.getElementById("aioh_car_model_search").innerHTML = response;
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
				document.getElementById("aioh_applicator_no_search_list").innerHTML = response;
			}
		});
	}

	document.getElementById('applicator_history_form').addEventListener('submit', e => {
        e.preventDefault();
        get_applicator_history();
    });
	
    const get_applicator_history = () => {
		let date_time_in_from = document.getElementById('aioh_date_time_in_from_search').value;
		let date_time_in_to = document.getElementById('aioh_date_time_in_to_search').value;
		let car_maker = document.getElementById('aioh_car_maker_search').value;
		let car_model = document.getElementById('aioh_car_model_search').value;
		let applicator_no = document.getElementById('aioh_applicator_no_search').value;
		let terminal_name = document.getElementById('aioh_terminal_name_search').value;
		let trd_no = document.getElementById('aioh_trd_no_search').value;
		let zaihai_stock_address = document.getElementById('aioh_zaihai_stock_address_search').value;

		sessionStorage.setItem('zs_aioh_date_time_in_from_search', date_time_in_from);
		sessionStorage.setItem('zs_aioh_date_time_in_to_search', date_time_in_to);
		sessionStorage.setItem('zs_aioh_car_maker_search', car_maker);
		sessionStorage.setItem('zs_aioh_car_model_search', car_model);
		sessionStorage.setItem('zs_aioh_applicator_no_search', applicator_no);
		sessionStorage.setItem('zs_aioh_terminal_name_search', terminal_name);
		sessionStorage.setItem('zs_aioh_trd_no_search', trd_no);
		sessionStorage.setItem('zs_aioh_zaihai_stock_address_search', zaihai_stock_address);

		$.ajax({
			type: "GET",
			url: "../process/shop/applicator_in_out/aioh_g_p.php",
			cache: false,
			data: {
				method: "get_applicator_history",
				date_time_in_from: date_time_in_from,
				date_time_in_to: date_time_in_to,
				car_maker: car_maker,
				car_model: car_model,
				applicator_no: applicator_no,
				terminal_name: terminal_name,
				trd_no: trd_no,
				zaihai_stock_address: zaihai_stock_address
			},
			success: (response) => {
                $('#applicatorHistoryData').html(response);
				let table_rows = parseInt(document.getElementById("applicatorHistoryData").childNodes.length);
				$('#count_view').html("Total: " + table_rows);
			}
		});
	}

	const export_applicator_history = (table_id, separator = ',') => {
		let date_time_in_from = sessionStorage.getItem('zs_aioh_date_time_in_from_search');
		let date_time_in_to = sessionStorage.getItem('zs_aioh_date_time_in_to_search');
		let car_maker = sessionStorage.getItem('zs_aioh_car_maker_search');
		let car_model = sessionStorage.getItem('zs_aioh_car_model_search');
		let applicator_no = sessionStorage.getItem('zs_aioh_applicator_no_search');
		let terminal_name = sessionStorage.getItem('zs_aioh_terminal_name_search');
		let trd_no = sessionStorage.getItem('zs_aioh_trd_no_search');
		let zaihai_stock_address = sessionStorage.getItem('zs_aioh_zaihai_stock_address_search');

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
        var filename = 'ZaihaiSystem_ApplicatorHistory';
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
		if (trd_no) {
			filename += '_' + trd_no;
		}
		if (zaihai_stock_address) {
			filename += '_' + zaihai_stock_address;
		}

		date_time_in_from = new Date(date_time_in_from);
		var date = date_time_in_from.toISOString().split('T')[0];
		var time = date_time_in_from.toTimeString().split(' ')[0];
		date_time_in_from = `${date}_${time}`;

		date_time_in_to = new Date(date_time_in_to);
		var date = date_time_in_to.toISOString().split('T')[0];
		var time = date_time_in_to.toTimeString().split(' ')[0];
		date_time_in_to = `${date}_${time}`;

		filename += '_' + date_time_in_from + '_to_' + date_time_in_to + '.csv';
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
</script>