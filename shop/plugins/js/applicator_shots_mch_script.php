<script type="text/javascript">
	// DOMContentLoaded function
	document.addEventListener("DOMContentLoaded", () => {
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
				document.getElementById("asmch_car_maker_search").innerHTML = response;
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
				document.getElementById("asmch_car_model_search").innerHTML = response;
			}
		});
	}

	const get_applicator_no_datalist_search = () => {
		$.ajax({
			url: '../process/shop/applicator_list/al_g_p.php',
			type: 'GET',
			cache: false,
			data: {
				method: 'get_applicator_no_datalist_search',
				page: 'shop'
			},  
			success: response => {
				document.getElementById("asmch_applicator_no_search_list").innerHTML = response;
			}
		});
	}

	document.getElementById('applicator_shots_mch_form').addEventListener('submit', e => {
        e.preventDefault();
        get_applicator_shots_mch();
    });

    const get_applicator_shots_mch = () => {
		let maintenance_date_from = document.getElementById('asmch_maintenance_date_from_search').value;
		let maintenance_date_to = document.getElementById('asmch_maintenance_date_to_search').value;
		let car_maker = document.getElementById('asmch_car_maker_search').value;
		let car_model = document.getElementById('asmch_car_model_search').value;
		let applicator_no = document.getElementById('asmch_applicator_no_search').value;

		sessionStorage.setItem('zs_asmch_maintenance_date_from_search', maintenance_date_from);
		sessionStorage.setItem('zs_asmch_maintenance_date_to_search', maintenance_date_to);
		sessionStorage.setItem('zs_asmch_car_maker_search', car_maker);
		sessionStorage.setItem('zs_asmch_car_model_search', car_model);
		sessionStorage.setItem('zs_asmch_applicator_no_search', applicator_no);

		$.ajax({
			type: "GET",
			url: "../process/applicator_shots/as_g_p.php",
			cache: false,
			data: {
				method: "get_applicator_shots_mch",
				maintenance_date_from: maintenance_date_from,
				maintenance_date_to: maintenance_date_to,
				car_maker: car_maker,
				car_model: car_model,
				applicator_no: applicator_no
			},
			success: (response) => {
                $('#recentApplicatorShotsMchData').html(response);
				let table_rows = parseInt(document.getElementById("recentApplicatorShotsMchData").childNodes.length);
				$('#count_view').html("Total: " + table_rows);
			}
		});
	}

	const export_applicator_shots_mch = (table_id, separator = ',') => {
		let maintenance_date_from = sessionStorage.getItem('zs_asmch_maintenance_date_from_search');
		let maintenance_date_to = sessionStorage.getItem('zs_asmch_maintenance_date_to_search');
		let car_maker = sessionStorage.getItem('zs_asmch_car_maker_search');
		let car_model = sessionStorage.getItem('zs_asmch_car_model_search');
		let applicator_no = sessionStorage.getItem('zs_asmch_applicator_no_search');

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
        var filename = 'ZaihaiSystem_ApplicatorShotsMch';
		if (car_maker) {
			filename += '_' + car_maker;
		}
		if (car_model) {
			filename += '_' + car_model;
		}
		if (applicator_no) {
			filename += '_' + applicator_no;
		}

		maintenance_date_from = new Date(maintenance_date_from);
		var date = maintenance_date_from.toISOString().split('T')[0];
		maintenance_date_from = `${date}`;

		maintenance_date_to = new Date(maintenance_date_to);
		var date = maintenance_date_to.toISOString().split('T')[0];
		maintenance_date_to = `${date}}`;

		filename += '_' + maintenance_date_from + '_to_' + maintenance_date_to + '.csv';
        var link = document.createElement('a');
        link.style.display = 'none';
        link.setAttribute('target', '_blank');
        link.setAttribute('href', 'data:text/csv;charset=utf-8,%EF%BB%BF' + encodeURIComponent(csv_string));
        link.setAttribute('download', filename);
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
    }
</script>