<script type="text/javascript">
	// DOMContentLoaded function
	document.addEventListener("DOMContentLoaded", () => {
		document.getElementById("vc_applicator_no_search").focus();
	});

	var delay = (function () {
        var timer = 0;
        return function (callback, ms) {
            clearTimeout(timer);
            timer = setTimeout(callback, ms);
        };
    })();

	sessionStorage.setItem('zs_vc_applicator_no_search', '');

	document.getElementById("vc_applicator_no_search").addEventListener("input", e => {
		delay(function () {
            if (document.getElementById("vc_applicator_no_search").value.length < 256) {
                document.getElementById("vc_applicator_no_search").value = "";
            }
			let vc_applicator_no_search = sessionStorage.getItem('zs_vc_applicator_no_search');
			if (vc_applicator_no_search != '') {
				document.getElementById("vc_applicator_no_search").value = vc_applicator_no_search;
				sessionStorage.setItem('zs_vc_applicator_no_search', '');
			}
        }, 100);
	});

	document.getElementById("vc_applicator_no_search").addEventListener("change", e => {
		e.preventDefault();
		sessionStorage.setItem('zs_vc_applicator_no_search', e.target.value);
		document.getElementById("vc_applicator_no_search").disabled = true;
		get_ac_details();
	});

	const display_applicator_in_out_result = (id, type, message) => {
		var duration = 0;
		var error_message = 'Error: ';
		if (type == 'error') {
			duration = 5000;
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

	const reset_vc_applicator_no_search_field = opt => {
		document.getElementById("vc_applicator_no_search").value = '';
		document.getElementById("vc_applicator_no_search").disabled = false;
		document.getElementById("vc_applicator_no_search").focus();
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

	const get_ac_details = () => {
		let applicator_no = document.getElementById('vc_applicator_no_search').value;

        $.ajax({
			url: '../process/pd/applicator_checksheet/ac_g_p.php',
			type: 'GET',
			cache: false,
			dataType: 'json',
			data: {
				method: 'get_ac_details',
				applicator_no: applicator_no
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

					document.getElementById('serial_no_acver').innerHTML = serial_no;
					document.getElementById('equipment_no_acver').innerHTML = equipment_no;
					document.getElementById('machine_no_acver').innerHTML = applicator_no;
					document.getElementById('terminal_name_acver').innerHTML = terminal_name;
					document.getElementById('inspection_date_acver').innerHTML = inspection_date;
					document.getElementById('inspection_time_acver').innerHTML = inspection_time;
					document.getElementById('inspection_shift_acver').innerHTML = inspection_shift;

					document.getElementById('adjustment_content_acver').innerHTML = adjustment_content;
					document.getElementById('adjustment_content_remarks_acver').innerHTML = adjustment_content_remarks;
					document.getElementById('inspected_by_acver').innerHTML = inspected_by;
					document.getElementById('checked_by_acver').innerHTML = checked_by;
					document.getElementById('confirmed_by_no_acver').innerHTML = confirmed_by;

					document.getElementById('cross_section_result_acver').innerHTML = convert_num_to_desc_symbol(cross_section_result);
					document.getElementById('judgement_acver').innerHTML = convert_num_to_desc_symbol(judgement);

					document.getElementById('ac1_acver').innerHTML = convert_num_to_desc_symbol(ac1);
					document.getElementById('ac2_acver').innerHTML = convert_num_to_desc_symbol(ac2);
					document.getElementById('ac3_acver').innerHTML = convert_num_to_desc_symbol(ac3);
					document.getElementById('ac4_acver').innerHTML = convert_num_to_desc_symbol(ac4);
					document.getElementById('ac5_acver').innerHTML = convert_num_to_desc_symbol(ac5);
					document.getElementById('ac6_acver').innerHTML = convert_num_to_desc_symbol(ac6);
					document.getElementById('ac7_acver').innerHTML = convert_num_to_desc_symbol(ac7);
					document.getElementById('ac8_acver').innerHTML = convert_num_to_desc_symbol(ac8);
					document.getElementById('ac9_acver').innerHTML = convert_num_to_desc_symbol(ac9);
					document.getElementById('ac10_acver').innerHTML = convert_num_to_desc_symbol(ac10);

					document.getElementById('cont_1s_acver').innerHTML = ac1_s;
					document.getElementById('cont_2s_acver').innerHTML = ac2_s;
					document.getElementById('cont_3s_acver').innerHTML = ac3_s;
					document.getElementById('cont_4s_acver').innerHTML = ac4_s;
					document.getElementById('cont_5s_acver').innerHTML = ac5_s;
					document.getElementById('cont_6s_acver').innerHTML = ac6_s;
					document.getElementById('cont_7s_acver').innerHTML = ac7_s;
					document.getElementById('cont_8s_acver').innerHTML = ac8_s;
					document.getElementById('cont_9s_acver').innerHTML = ac9_s;
					document.getElementById('cont_10s_acver').innerHTML = ac10_s;

					document.getElementById('cont_1r_acver').innerHTML += ac1_r;
					document.getElementById('cont_2r_acver').innerHTML += ac2_r;
					document.getElementById('cont_3r_acver').innerHTML += ac3_r;
					document.getElementById('cont_4r_acver').innerHTML += ac4_r;
					document.getElementById('cont_5r_acver').innerHTML += ac5_r;
					document.getElementById('cont_6r_acver').innerHTML += ac6_r;
					document.getElementById('cont_7r_acver').innerHTML += ac7_r;
					document.getElementById('cont_8r_acver').innerHTML += ac8_r;
					document.getElementById('cont_9r_acver').innerHTML += ac9_r;
					document.getElementById('cont_10r_acver').innerHTML += ac10_r;

					$("#applicator_checksheet_verify").modal("show");
				} else {
					display_applicator_in_out_result('vc_search_result', 'error', response.message);
					reset_vc_applicator_no_search_field();
				}
			}
		});
    }

	document.getElementById('applicator_checksheet_verify_form').addEventListener('submit', e => {
        e.preventDefault();
        verify_checksheet();
    });

	const verify_checksheet = () => {
		let serial_no = document.getElementById("serial_no_acver").innerHTML;

		document.getElementById("btnVerifyAc").disabled = true;

		$.ajax({
			type: "POST",
			url: "../process/pd/applicator_checksheet/ac_p.php",
			cache: false,
			data: {
				method: "verify_checksheet",
				serial_no: serial_no
			},
			success: (response) => {
				if (response == 'success') {
					$('#applicator_checksheet_verify').modal("hide");
					Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: 'Verify Checksheet Done Succesfully!!!',
                        showConfirmButton: false,
                        timer: 2000
                    });
					// Auto Log Out after verification
					window.location.href = '../process/logout.php';
				} else {
					Swal.fire({
                        icon: 'error',
                        title: 'Error !!!',
                        text: 'Error: ' + response,
                        showConfirmButton: false,
                        timer: 5000
                    });
				}
				document.getElementById("btnVerifyAc").disabled = false;
			}
		});
	}

	$('#applicator_checksheet_verify').on('hidden.bs.modal', function (e) {
		reset_vc_applicator_no_search_field();
	});
</script>