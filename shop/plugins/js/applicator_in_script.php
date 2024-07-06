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
			type: "POST",
			url: "../process/shop/applicator_in_out/aio_p.php",
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
		in_applicator();
	});

	const in_applicator = () => {
		let location = document.getElementById("ai_location").value;
		let applicator_no = document.getElementById("ai_applicator_no").value;
		let terminal_name = document.getElementById("ai_terminal_name").value;
		$.ajax({
			type: "POST",
			url: "../process/shop/applicator_in_out/aio_p.php",
			cache: false,
			data: {
				method: "in_applicator",
				location: location,
				applicator_no: applicator_no,
				terminal_name: terminal_name
			},
			success: (response) => {
				if (response == 'success') {
					document.getElementById("in_applicator_result").innerHTML = 'Applicator In Succesfully!!!';
					setTimeout(() => {
						document.getElementById("in_applicator_result").innerHTML = '';
					}, 1000);
					get_recent_applicator_in();
				} else {
					document.getElementById("in_applicator_result").innerHTML = 'Error: ' + response;
					document.getElementById("in_applicator_result").classList.add('text-red');
					setTimeout(() => {
						document.getElementById("in_applicator_result").innerHTML = '';
						document.getElementById("in_applicator_result").classList.remove('text-red');
					}, 2000);
				}
				document.getElementById("ai_location").value = '';
				document.getElementById("ai_applicator_no").value = '';
				document.getElementById("ai_terminal_name").value = '';
				document.getElementById("ai_location").disabled = false;
				document.getElementById("ai_location").focus();
			}
		});
	}
</script>