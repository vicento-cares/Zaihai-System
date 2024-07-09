<script type="text/javascript">
    // Global Variables for Realtime
	var realtime_get_recent_applicator_out;

	// DOMContentLoaded function
	document.addEventListener("DOMContentLoaded", () => {
		get_recent_applicator_out();
		realtime_get_recent_applicator_out = setInterval(get_recent_applicator_out, 10000);
	});

    const get_recent_applicator_out = () => {
		$.ajax({
			type: "GET",
			url: "../process/shop/applicator_in_out/aio_g_p.php",
			cache: false,
			data: {
				method: "get_recent_applicator_out"
			},
			success: (response) => {
                $('#recentApplicatorOutData').html(response);
				let table_rows = parseInt(document.getElementById("recentApplicatorOutData").childNodes.length);
				$('#count_view').html("Total: " + table_rows);
			}
		});
	}

	document.getElementById("ao_location").addEventListener("change", e => {
		e.preventDefault();
		document.getElementById("ao_location").disabled = true;
		document.getElementById("ao_applicator_no").disabled = false;
		document.getElementById("ao_applicator_no").focus();
	});

	document.getElementById("ao_applicator_no").addEventListener("change", e => {
		e.preventDefault();
		document.getElementById("ao_applicator_no").disabled = true;
		document.getElementById("ao_terminal_name").disabled = false;
		document.getElementById("ao_terminal_name").focus();
	});

	document.getElementById("ao_terminal_name").addEventListener("change", e => {
		e.preventDefault();
		document.getElementById("ao_terminal_name").disabled = true;
		out_applicator();
	});

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

	const out_applicator = () => {
		let location = document.getElementById("ao_location").value;
		let applicator_no = document.getElementById("ao_applicator_no").value;
		let terminal_name = document.getElementById("ao_terminal_name").value;
		$.ajax({
			type: "POST",
			url: "../process/shop/applicator_in_out/aio_p.php",
			cache: false,
			data: {
				method: "out_applicator",
				location: location,
				applicator_no: applicator_no,
				terminal_name: terminal_name
			},
			success: (response) => {
				if (response == 'success') {
					display_applicator_in_out_result('out_applicator_result', '', 'Applicator Out Succesfully!!!');
					get_recent_applicator_out();
				} else {
					display_applicator_in_out_result('out_applicator_result', 'error', response);
				}
				document.getElementById("ao_location").value = '';
				document.getElementById("ao_applicator_no").value = '';
				document.getElementById("ao_terminal_name").value = '';
				document.getElementById("ao_location").disabled = false;
				document.getElementById("ao_location").focus();
			}
		});
	}
</script>