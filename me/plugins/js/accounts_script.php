<script type="text/javascript">
    // Global Variables for Realtime
	var realtime_get_accounts;

    // DOMContentLoaded function
    document.addEventListener("DOMContentLoaded", () => {
		// get_car_maker_dropdown_in_search();
        get_accounts();
        realtime_get_accounts = setInterval(get_accounts, 15000);
    });

	// const get_car_maker_dropdown_in_search = () => {
	// 	$.ajax({
	// 		url: '../process/shop/applicator_in_out/aio_g_p.php',
	// 		type: 'GET',
	// 		cache: false,
	// 		data: {
	// 			method: 'get_car_maker_dropdown_in_search'
	// 		},  
	// 		success: response => {
	// 			document.getElementById("ai_car_maker_search").innerHTML = response;
	// 		}
	// 	});
	// }

	var typingTimerAcctEmpNoSearch;
	var typingTimerAcctFullNameSearch;
    var doneTypingInterval = 250; // Time in ms

    // On keyup, start the countdown
    document.getElementById("acct_emp_no_search").addEventListener('keyup', e => {
        clearTimeout(typingTimerAcctEmpNoSearch);
        typingTimerAcctEmpNoSearch = setTimeout(doneTypingGetAccounts, doneTypingInterval);
    });

    // On keydown, clear the countdown
    document.getElementById("acct_emp_no_search").addEventListener('keydown', e => {
        clearTimeout(typingTimerAcctEmpNoSearch);
    });

	// On keyup, start the countdown
    document.getElementById("acct_full_name_search").addEventListener('keyup', e => {
        clearTimeout(typingTimerAcctFullNameSearch);
        typingTimerAcctFullNameSearch = setTimeout(doneTypingGetAccounts, doneTypingInterval);
    });

    // On keydown, clear the countdown
    document.getElementById("acct_full_name_search").addEventListener('keydown', e => {
        clearTimeout(typingTimerAcctFullNameSearch);
    });

    // User is "finished typing," do something
    const doneTypingGetAccounts = () => {
        get_accounts();
    }

    const get_accounts = () => {
		let emp_no = document.getElementById('acct_emp_no_search').value;
		let full_name = document.getElementById('acct_full_name_search').value;
		let role = document.getElementById('ai_role_search').value;

		sessionStorage.setItem('zs_acct_emp_no_search', emp_no);
		sessionStorage.setItem('zs_acct_full_name_search', full_name);
		sessionStorage.setItem('zs_ai_role_search', role);

		$.ajax({
			type: "GET",
			url: "../process/me/accounts/acct_g_p.php",
			cache: false,
			data: {
				method: "get_accounts",
				emp_no: emp_no,
				full_name: full_name,
				role: role
			},
			success: (response) => {
                $('#accountsData').html(response);
				let table_rows = parseInt(document.getElementById("accountsData").childNodes.length);
				$('#count_view').html("Total: " + table_rows);
			}
		});
	}

	const export_accounts = (table_id, separator = ',') => {
		let emp_no = sessionStorage.getItem('zs_acct_emp_no_search');
		let full_name = sessionStorage.getItem('zs_acct_full_name_search');
		let role = sessionStorage.getItem('zs_ai_role_search');

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
        var filename = 'ZaihaiSystem_ApplicatorInPending';
		if (emp_no) {
			filename += '_' + emp_no;
		}
		if (full_name) {
			filename += '_' + full_name;
		}
		if (role) {
			filename += '_' + role;
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

	$("#new_account").on('hidden.bs.modal', e => {
        document.getElementById('emp_no_master').value = '';
        document.getElementById('full_name_master').value = '';
        document.getElementById('role_master').value = '';
    });

    document.getElementById('new_account_form').addEventListener('submit', e => {
        e.preventDefault();
        add_account();
    });

    const add_account = () => {
        var emp_no = document.getElementById('emp_no_master').value;
        var full_name = document.getElementById('full_name_master').value;
        var role = document.getElementById('role_master').value;

        $.ajax({
            url: '../process/me/accounts/acct_p.php',
            type: 'POST',
            cache: false,
            data: {
                method: 'add_account',
                emp_no: emp_no,
                full_name: full_name,
                role: role
            }, success: function (response) {
                if (response == 'success') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Succesfully Recorded!!!',
                        text: 'Success',
                        showConfirmButton: false,
                        timer: 1000
                    });
                    document.getElementById('emp_no_master').value = '';
					document.getElementById('full_name_master').value = '';
					document.getElementById('role_master').value = '';
                    get_accounts();
                    $('#new_account').modal('hide');
                } else if (response == 'Already Exist') {
                    Swal.fire({
                        icon: 'info',
                        title: 'Duplicate Data !!!',
                        text: 'Information',
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

	const get_account_details = param => {
		var string = param.split('~!~');
        var id = string[0];
        var emp_no = string[1];
        var full_name = string[2];
        var role = string[3];

        document.getElementById('id_account_master_update').value = id;
        document.getElementById('emp_no_master_update').value = emp_no;
        document.getElementById('full_name_master_update').value = full_name;
        document.getElementById('role_master_update').value = role;
	}

	// Get the form element
    var update_account_form = document.getElementById('update_account_form');

    // Add a submit event listener to the form
    update_account_form.addEventListener('submit', e => {
        e.preventDefault();

        // Get the button that triggered the submit event
        var button = document.activeElement;

        // Check the id or name of the button
        if (button.id === 'btnUpdateAccount') {
            // Call the function for the first submit button
            update_account();
        } else if (button.id === 'btnDeleteAccount') {
            // Call the function for the first submit button
            delete_account();
        }
    });

    const update_account = () => {
        var id = document.getElementById('id_account_master_update').value;
        var emp_no = document.getElementById('emp_no_master_update').value;
        var full_name = document.getElementById('full_name_master_update').value;
        var role = document.getElementById('role_master_update').value;

        $.ajax({
            url: '../process/me/accounts/acct_p.php',
            type: 'POST',
            cache: false,
            data: {
                method: 'update_account',
                id: id,
                emp_no: emp_no,
                full_name: full_name,
                role: role
            }, success: function (response) {
                if (response == 'success') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Succesfully Recorded!!!',
                        text: 'Success',
                        showConfirmButton: false,
                        timer: 1000
                    });
                    document.getElementById('id_account_master_update').value = '';
                    document.getElementById('emp_no_master_update').value = '';
                    document.getElementById('full_name_master_update').value = '';
                    document.getElementById('role_master_update').value = '';
                    get_accounts();
                    $('#update_account').modal('hide');
                } else if (response == 'Already Exist') {
                    Swal.fire({
                        icon: 'info',
                        title: 'Duplicate Data !!!',
                        text: 'Information',
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

    const delete_account = () => {
        var id = document.getElementById('id_account_master_update').value;
        $.ajax({
            url: '../process/me/accounts/acct_p.php',
            type: 'POST',
            cache: false,
            data: {
                method: 'delete_account',
                id: id
            }, success: function (response) {
                if (response == 'success') {
                    Swal.fire({
                        icon: 'info',
                        title: 'Succesfully Deleted !!!',
                        text: 'Information',
                        showConfirmButton: false,
                        timer: 1000
                    });
                    document.getElementById('id_account_master_update').value = '';
                    document.getElementById('emp_no_master_update').value = '';
                    document.getElementById('full_name_master_update').value = '';
                    document.getElementById('role_master_update').value = '';
                    get_accounts();
                    $('#update_account').modal('hide');
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