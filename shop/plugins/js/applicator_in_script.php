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

	document.getElementById("ai_location").addEventListener("change", e => {
		e.preventDefault();
		document.getElementById("ai_location").disabled = true;
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
		get_single_recent_applicator_out();
	});

	const get_single_recent_applicator_out = () => {
		let applicator_no = document.getElementById("ai_applicator_no").value;
		let terminal_name = document.getElementById("ai_terminal_name").value;
		$.ajax({
			type: "GET",
			url: "../process/shop/applicator_in_out/aio_g_p.php",
			cache: false,
			data: {
				method: "get_single_recent_applicator_out",
				applicator_no: applicator_no,
				terminal_name: terminal_name
			},
			success: (response) => {
				try {
                    let response_array = JSON.parse(response);
                    if (response_array.message == 'success') {
                        document.getElementById('serial_no_ac_i').innerHTML = response_array.serial_no;
                        document.getElementById('machine_no_ac_i').innerHTML = response_array.applicator_no;
						document.getElementById('terminal_name_ac_i').innerHTML = response_array.terminal_name;
						document.getElementById('inspection_date_time_ac_i').value = response_array.inspection_date_time;
						document.getElementById('inspection_date_ac_i').innerHTML = response_array.inspection_date;
						document.getElementById('inspection_time_ac_i').innerHTML = response_array.inspection_time;
						document.getElementById('inspection_shift_ac_i').innerHTML = response_array.inspection_shift;
						document.getElementById('inspected_by_ac_i').innerHTML = response_array.inspected_by;
						document.getElementById('inspected_by_no_ac_i').value = response_array.inspected_by_no;
						$('#applicator_checksheet').modal("show");
                    } else {
						document.getElementById("in_applicator_result").innerHTML = 'Error: ' + response_array.message;
						document.getElementById("in_applicator_result").classList.add('text-red');
						setTimeout(() => {
							document.getElementById("in_applicator_result").innerHTML = '';
							document.getElementById("in_applicator_result").classList.remove('text-red');
						}, 2000);

						document.getElementById("ai_location").value = '';
						document.getElementById("ai_applicator_no").value = '';
						document.getElementById("ai_terminal_name").value = '';
						document.getElementById("ai_location").disabled = false;
						document.getElementById("ai_location").focus();

                        console.log(response);
                    }
                } catch (e) {
					document.getElementById("ai_location").value = '';
					document.getElementById("ai_applicator_no").value = '';
					document.getElementById("ai_terminal_name").value = '';
					document.getElementById("ai_location").disabled = false;
					document.getElementById("ai_location").focus();

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

	$("#applicator_checksheet").on('hidden.bs.modal', e => {
        document.getElementById('equipment_no_ac_i').value = '';

		var radio_button_arr = ["cont_1_ac_i", "cont_2_ac_i", "cont_3_ac_i", "cont_4_ac_i", "cont_5_ac_i", "cont_6_ac_i", "cont_7_ac_i", "cont_8_ac_i", "cont_9_ac_i", "cont_10_ac_i"];
		for (var i = 0; i < radio_button_arr.length; i++) {
			clear_checked_radio_button(radio_button_arr[i]);
		}

        document.getElementById('adjustment_content_ac_i').value = '';
		clear_checked_radio_button("cross_section_result_ac_i");
        document.getElementById('checked_by_ac_i').value = '';

		document.getElementById("ai_location").value = '';
		document.getElementById("ai_applicator_no").value = '';
		document.getElementById("ai_terminal_name").value = '';
		document.getElementById("ai_location").disabled = false;
		document.getElementById("ai_location").focus();
    });

    document.getElementById('applicator_checksheet_form').addEventListener('submit', e => {
        e.preventDefault();
        in_applicator();
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

	const in_applicator = () => {
		let location = document.getElementById("ai_location").value;
		let applicator_no = document.getElementById("ai_applicator_no").value;
		let terminal_name = document.getElementById("ai_terminal_name").value;

		let serial_no = document.getElementById("serial_no_ac_i").innerHTML;
		let equipment_no = document.getElementById("equipment_no_ac_i").value;
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

		let adjustment_content = document.getElementById("adjustment_content_ac_i").value;
		let cross_section_result = parseInt(get_checked_radio_button("cross_section_result_ac_i"));
		let inspected_by = document.getElementById("inspected_by_ac_i").innerHTML;
		let inspected_by_no = document.getElementById("inspected_by_no_ac_i").value;
		let checked_by = document.getElementById("checked_by_ac_i").value;

		$.ajax({
			type: "POST",
			url: "../process/shop/applicator_in_out/aio_p.php",
			cache: false,
			data: {
				method: "in_applicator",
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
				checked_by: checked_by,
				ac1: ac1,
				ac2: ac2,
				ac3: ac3,
				ac4: ac4,
				ac5: ac5,
				ac6: ac6,
				ac7: ac7,
				ac8: ac8,
				ac9: ac9,
				ac10: ac10
			},
			success: (response) => {
				if (response == 'success') {
					$('#applicator_checksheet').modal("hide");
					get_recent_applicator_in();

					document.getElementById("in_applicator_result").innerHTML = 'Applicator In Succesfully!!!';
					setTimeout(() => {
						document.getElementById("in_applicator_result").innerHTML = '';
					}, 3000);

					document.getElementById("ai_location").value = '';
					document.getElementById("ai_applicator_no").value = '';
					document.getElementById("ai_terminal_name").value = '';
					document.getElementById("ai_location").disabled = false;
					document.getElementById("ai_location").focus();
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