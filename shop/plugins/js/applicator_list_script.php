<script type="text/javascript">
    // Global Variables for Realtime
	var realtime_get_recent_applicator_list;

	// DOMContentLoaded function
	document.addEventListener("DOMContentLoaded", () => {
		get_recent_applicator_list();
		realtime_get_recent_applicator_list = setInterval(get_recent_applicator_list, 10000);
	});

    const get_recent_applicator_list = () => {
		$.ajax({
			type: "GET",
			url: "../process/shop/applicator_list/al_p.php",
			cache: false,
			data: {
				method: "get_recent_applicator_list"
			},
			success: (response) => {
                $('#recentApplicatorListData').html(response);
				let table_rows = parseInt(document.getElementById("recentApplicatorListData").childNodes.length);
				$('#count_view').html("Total: " + table_rows);
			}
		});
	}
</script>