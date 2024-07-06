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
			type: "POST",
			url: "../process/shop/applicator_in_out/aio_p.php",
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
					document.getElementById("out_applicator_result").innerHTML = 'Applicator Out Succesfully!!!';
					setTimeout(() => {
						document.getElementById("out_applicator_result").innerHTML = '';
					}, 1000);
					get_recent_applicator_out();
				} else {
					document.getElementById("out_applicator_result").innerHTML = 'Error: ' + response;
					document.getElementById("out_applicator_result").classList.add('text-red');
					setTimeout(() => {
						document.getElementById("out_applicator_result").innerHTML = '';
						document.getElementById("out_applicator_result").classList.remove('text-red');
					}, 2000);
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