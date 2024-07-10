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
</script>