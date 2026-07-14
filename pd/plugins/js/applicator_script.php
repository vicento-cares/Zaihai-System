<script type="text/javascript">
    // DOMContentLoaded function
    document.addEventListener("DOMContentLoaded", () => {
		get_applicator_no_datalist_search();
        get_applicators();
    });

	const get_applicator_no_datalist_search = () => {
		$.ajax({
			url: '../process/me/applicator/a_g_p.php',
			type: 'GET',
			cache: false,
			data: {
				method: 'get_applicator_no_datalist_search'
			},  
			success: response => {
				document.getElementById("a_applicator_no_search_list").innerHTML = response;
			}
		});
	}

    const get_applicator_no_dropdown = () => {
		$.ajax({
			url: '../process/me/applicator_terminal/at_g_p.php',
			type: 'GET',
			cache: false,
			data: {
				method: 'get_applicator_no_dropdown'
			},  
			success: response => {
				document.getElementById("a_applicator_no_master").innerHTML = response;
                document.getElementById("a_applicator_no_master_update").innerHTML = response;
			}
		});
	}

	var typingTimerTermApplicatorSearch;
	var typingTimerTermZaihaiStockAddressSearch;
    var doneTypingInterval = 250; // Time in ms

    // On keyup, start the countdown
    document.getElementById("a_applicator_no_search").addEventListener('keyup', e => {
        clearTimeout(typingTimerTermApplicatorSearch);
        typingTimerTermApplicatorSearch = setTimeout(doneTypingGetApplicators, doneTypingInterval);
    });

    // On keydown, clear the countdown
    document.getElementById("a_applicator_no_search").addEventListener('keydown', e => {
        clearTimeout(typingTimerTermApplicatorSearch);
    });

	// On keyup, start the countdown
    document.getElementById("a_zaihai_stock_address_search").addEventListener('keyup', e => {
        clearTimeout(typingTimerTermZaihaiStockAddressSearch);
        typingTimerTermZaihaiStockAddressSearch = setTimeout(doneTypingGetApplicators, doneTypingInterval);
    });

    // On keydown, clear the countdown
    document.getElementById("a_zaihai_stock_address_search").addEventListener('keydown', e => {
        clearTimeout(typingTimerTermZaihaiStockAddressSearch);
    });

    // User is "finished typing," do something
    const doneTypingGetApplicators = () => {
        get_applicators();
    }

    const get_applicators = () => {
        let car_maker = document.getElementById('a_car_maker_search').value;
        let car_model = document.getElementById('a_car_model_search').value;
		let applicator_no = document.getElementById('a_applicator_no_search').value;
		let zaihai_stock_address = document.getElementById('a_zaihai_stock_address_search').value;
        let is_prod_priority = document.getElementById('a_is_prod_priority_search').value;

        if (is_prod_priority != '') {
            is_prod_priority = parseInt(is_prod_priority);
        }

        sessionStorage.setItem('zs_a_car_maker_search', car_maker);
        sessionStorage.setItem('zs_a_car_model_search', car_model);
		sessionStorage.setItem('zs_a_applicator_no_search', applicator_no);
		sessionStorage.setItem('zs_a_zaihai_stock_address_search', zaihai_stock_address);
        sessionStorage.setItem('zs_a_is_prod_priority_search', is_prod_priority);

		$.ajax({
			type: "GET",
			url: "../process/pd/applicator/a_g_p.php",
			cache: false,
			data: {
				method: "get_applicators",
                car_maker: car_maker,
                car_model: car_model,
				applicator_no: applicator_no,
				zaihai_stock_address: zaihai_stock_address,
                is_prod_priority: is_prod_priority
			},
			success: (response) => {
                $('#applicatorsData').html(response);
				let table_rows = parseInt(document.getElementById("applicatorsData").childNodes.length);
				$('#count_view').html("Total: " + table_rows);
			}
		});
	}

	const export_applicators_shown = (table_id, separator = ',') => {
        let car_maker = sessionStorage.getItem('zs_a_car_maker_search');
        let car_model = sessionStorage.getItem('zs_a_car_model_search');
		let applicator_no = sessionStorage.getItem('zs_a_applicator_no_search');
		let zaihai_stock_address = sessionStorage.getItem('zs_a_zaihai_stock_address_search');
        let is_prod_priority = sessionStorage.getItem('zs_a_is_prod_priority_search');

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
        var filename = 'ZaihaiSystem_Applicator';
        if (car_maker) {
			filename += '_' + car_maker;
		}
        if (car_model) {
			filename += '_' + car_model;
		}
		if (applicator_no) {
			filename += '_' + applicator_no;
		}
		if (zaihai_stock_address) {
			filename += '_' + zaihai_stock_address;
		}
        if (parseInt(is_prod_priority) > 0) {
			filename += '_Priority';
		}
		filename += '_' + new Date().toJSON().slice(0, 10) + '.csv';
        var link = document.createElement('a');
        link.style.display = 'none';
        link.setAttribute('target', '_blank');
        link.setAttribute('href', 'data:text/csv;charset=utf-8,%EF%BB%BF' + encodeURIComponent(csv_string));
        link.setAttribute('download', filename);
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
    }

    const update_applicator = (row, el) => {
        const id = el.dataset.id;

        let is_prod_priority = 0;
        let priority_status = 'Non-Priority';

        if (document.getElementById(`a_chkbx_${row}`).checked) {
            is_prod_priority = 1;
            priority_status = 'Priority';
        }

        $.ajax({
            url: '../process/pd/applicator/a_p.php',
            type: 'POST',
            cache: false,
            data: {
                method: 'update_applicator',
                id: id,
                is_prod_priority: is_prod_priority
            }, success: function (response) {
                if (response == 'success') {
                    document.getElementById(`a_priority_status_row_${row}`).innerText = priority_status;
                } else if (response == 'Record Not Found') {
                    Swal.fire({
                        icon: 'info',
                        title: 'Info',
                        text: 'Record cannot be updated. Record Not Found',
                        showConfirmButton: false,
                        timer: 2000
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error !!!',
                        text: 'Error',
                        showConfirmButton: false,
                        timer: 2000
                    });
                }
            }
        });
    }
</script>