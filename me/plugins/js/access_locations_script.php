<script type="text/javascript">
    // AJAX IN PROGRESS GLOBAL VARS
    var load_access_locations_ajax_in_process = false;

    // DOMContentLoaded function
    document.addEventListener("DOMContentLoaded", () => {
        get_car_maker_dropdown_search();
		get_car_model_dropdown_search();
        get_car_maker_dropdown();
		get_car_model_dropdown();
        load_access_locations(1);
    });

    const get_car_maker_dropdown_search = () => {
		$.ajax({
			url: '../process/me/access_locations/al_g_p.php',
			type: 'GET',
			cache: false,
			data: {
				method: 'get_car_maker_dropdown_search'
			},  
			success: response => {
				document.getElementById("al_car_maker_search").innerHTML = response;
			}
		});
	}

	const get_car_model_dropdown_search = () => {
		$.ajax({
			url: '../process/me/access_locations/al_g_p.php',
			type: 'GET',
			cache: false,
			data: {
				method: 'get_car_model_dropdown_search'
			},  
			success: response => {
				document.getElementById("al_car_model_search").innerHTML = response;
			}
		});
	}

    const get_car_maker_dropdown = () => {
		$.ajax({
			url: '../process/me/car_maker/cm_g_p.php',
			type: 'GET',
			cache: false,
			data: {
				method: 'get_car_maker_dropdown'
			},  
			success: response => {
				document.getElementById("car_maker_al").innerHTML = response;
                document.getElementById("car_maker_al_update").innerHTML = response;
			}
		});
	}

	const get_car_model_dropdown = () => {
		$.ajax({
			url: '../process/me/car_maker/cm_g_p.php',
			type: 'GET',
			cache: false,
			data: {
				method: 'get_car_model_dropdown'
			},  
			success: response => {
                document.getElementById("car_model_al").innerHTML = response;
				document.getElementById("car_model_al_update").innerHTML = response;
			}
		});
	}

    var typingTimerIPSearch; // Timer identifier IP Search
    var doneTypingInterval = 250; // Time in ms

    // On keyup, start the countdown
    document.getElementById("al_ip_search").addEventListener('keyup', e => {
        clearTimeout(typingTimerIPSearch);
        typingTimerIPSearch = setTimeout(doneTypingLoadAccessLocations, doneTypingInterval);
    });

    // On keydown, clear the countdown
    document.getElementById("al_ip_search").addEventListener('keydown', e => {
        clearTimeout(typingTimerIPSearch);
    });

    // User is "finished typing," do something
    const doneTypingLoadAccessLocations = () => {
        load_access_locations(1);
    }

    // Table Responsive Scroll Event for Load More
    document.getElementById("list_of_access_locations_res").addEventListener("scroll", () => {
        var scrollTop = document.getElementById("list_of_access_locations_res").scrollTop;
        var scrollHeight = document.getElementById("list_of_access_locations_res").scrollHeight;
        var offsetHeight = document.getElementById("list_of_access_locations_res").offsetHeight;

        if (load_access_locations_ajax_in_process == false) {
            //check if the scroll reached the bottom
            if ((offsetHeight + scrollTop + 1) >= scrollHeight) {
                get_next_page();
            }
        }
    });

    const get_next_page = () => {
        var current_page = parseInt(sessionStorage.getItem('zs_al_list_of_access_locations_table_pagination'));
        let total = sessionStorage.getItem('zs_al_count_rows');
        var last_page = parseInt(sessionStorage.getItem('zs_al_last_page'));
        var next_page = current_page + 1;
        if (next_page <= last_page && total > 0) {
            load_access_locations(next_page);
        }
    }

    const count_access_location_list = () => {
        var car_maker = sessionStorage.getItem('zs_al_car_maker_search');
        var car_model = sessionStorage.getItem('zs_al_car_model_search');
        var ip = sessionStorage.getItem('zs_al_ip_search');
        $.ajax({
            url: '../process/me/access_locations/al_g_p.php',
            type: 'GET',
            cache: false,
            data: {
                method: 'count_access_location_list',
                car_maker: car_maker,
                car_model: car_model,
                ip: ip
            },
            success: function (response) {
                sessionStorage.setItem('zs_al_count_rows', response);
                var count = `Total: ${response}`;
                document.getElementById("list_of_access_locations_info").innerHTML = count;

                if (response > 0) {
                    load_access_locations_last_page();
                } else {
                    document.getElementById("btnNextPage").style.display = "none";
                    document.getElementById("btnNextPage").setAttribute('disabled', true);
                }
            }
        });
    }

    const load_access_locations_last_page = () => {
        var car_maker = sessionStorage.getItem('zs_al_car_maker_search');
        var car_model = sessionStorage.getItem('zs_al_car_model_search');
        var ip = sessionStorage.getItem('zs_al_ip_search');
        var current_page = parseInt(sessionStorage.getItem('zs_al_list_of_access_locations_table_pagination'));
        $.ajax({
            url: '../process/me/access_locations/al_g_p.php',
            type: 'GET',
            cache: false,
            data: {
                method: 'access_location_list_last_page',
                car_maker: car_maker,
                car_model: car_model,
                ip: ip
            },
            success: function (response) {
                sessionStorage.setItem('zs_al_last_page', response);
                let total = sessionStorage.getItem('zs_al_count_rows');
                var next_page = current_page + 1;
                if (next_page > response || total < 1) {
                    document.getElementById("btnNextPage").style.display = "none";
                    document.getElementById("btnNextPage").setAttribute('disabled', true);
                } else {
                    document.getElementById("btnNextPage").style.display = "block";
                    document.getElementById("btnNextPage").removeAttribute('disabled');
                }
            }
        });
    }

    const load_access_locations = current_page => {
        // If an AJAX call is already in progress, return immediately
        if (load_access_locations_ajax_in_process) {
            return;
        }

        var car_maker = document.getElementById('al_car_maker_search').value;
        var car_model = document.getElementById('al_car_model_search').value;
        var ip = document.getElementById('al_ip_search').value;

        var car_maker1 = sessionStorage.getItem('zs_al_car_maker_search');
        var car_model1 = sessionStorage.getItem('zs_al_car_model_search');
        var ip1 = sessionStorage.getItem('zs_al_ip_search');

        if (current_page > 1) {
            switch (true) {
                case car_maker !== car_maker1:
                case car_model !== car_model1:
                case ip !== ip1:
                    car_maker = car_maker1;
                    car_model = car_model1;
                    ip = ip1;
                    break;
                default:
            }
        } else {
            sessionStorage.setItem('zs_al_car_maker_search', car_maker);
            sessionStorage.setItem('zs_al_car_model_search', car_model);
            sessionStorage.setItem('zs_al_ip_search', ip);
        }

        // Set the flag to true as we're starting an AJAX call
        load_access_locations_ajax_in_process = true;

        $.ajax({
            url: '../process/me/access_locations/al_g_p.php',
            type: 'GET',
            cache: false,
            data: {
                method: 'access_location_list',
                car_maker: car_maker,
                car_model: car_model,
                ip: ip,
                current_page: current_page
            },
            beforeSend: (jqXHR, settings) => {
                document.getElementById("btnNextPage").setAttribute('disabled', true);
                var loading = `<tr id="loading"><td colspan="5" style="text-align:center;"><div class="spinner-border text-dark" role="status"><span class="sr-only">Loading...</span></div></td></tr>`;
                if (current_page == 1) {
                    document.getElementById("list_of_access_locations").innerHTML = loading;
                } else {
                    $('#list_of_access_locations_table tbody').append(loading);
                }
                jqXHR.url = settings.url;
                jqXHR.type = settings.type;
            },
            success: function (response) {
                $('#loading').remove();
                document.getElementById("btnNextPage").removeAttribute('disabled');
                if (current_page == 1) {
                    $('#list_of_access_locations_table tbody').html(response);
                } else {
                    $('#list_of_access_locations_table tbody').append(response);
                }
                sessionStorage.setItem('zs_al_list_of_access_locations_table_pagination', current_page);
                count_access_location_list();
                // Set the flag back to false as the AJAX call has completed
                load_access_locations_ajax_in_process = false;
            }
        }).fail((jqXHR, textStatus, errorThrown) => {
            console.log(`System Error : Call IT Personnel Immediately!!! They will fix it right away. Error: url: ${jqXHR.url}, method: ${jqXHR.type} ( HTTP ${jqXHR.status} - ${jqXHR.statusText} ) Press F12 to see Console Log for more info.`);
            $('#loading').remove();
            document.getElementById("btnNextPage").removeAttribute('disabled');
            // Set the flag back to false as the AJAX call has completed
            load_access_locations_ajax_in_process = false;
        });
    }

    document.getElementById('new_access_location_form').addEventListener('submit', e => {
        e.preventDefault();
        add_access_locations();
    });

    const add_access_locations = () => {
        var car_maker = document.getElementById('car_maker_al').value;
        var car_model = document.getElementById('car_model_al').value;
        var ip = document.getElementById('ip_al').value;

        $.ajax({
            url: '../process/me/access_locations/al_p.php',
            type: 'POST',
            cache: false,
            data: {
                method: 'add_access_location',
                car_maker: car_maker,
                car_model: car_model,
                ip: ip
            }, success: function (response) {
                if (response == 'success') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Succesfully Recorded!!!',
                        text: 'Success',
                        showConfirmButton: false,
                        timer: 1000
                    });
                    clear_access_location_details();
                    load_access_locations(1);
                    $('#new_access_location').modal('hide');
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

    const get_access_location_details = (param) => {
        var string = param.split('~!~');
        var id = string[0];
        var car_maker = string[1];
        var car_model = string[2];
        var ip = string[3];

        document.getElementById('id_access_location_update').value = id;
        document.getElementById('car_maker_al_update').value = car_maker;
        document.getElementById('car_model_al_update').value = car_model;
        document.getElementById('ip_al_update').value = ip;
    }

    const clear_access_location_details = () => {
        document.getElementById("car_maker_al").value = '';
        document.getElementById("car_model_al").value = '';
        document.getElementById("ip_al").value = '';

        document.getElementById('id_access_location_update').value = '';
        document.getElementById('car_maker_al_update').value = '';
        document.getElementById('car_model_al_update').value = '';
        document.getElementById('ip_al_update').value = '';
    }

    // Get the form element
    var update_access_location_form = document.getElementById('update_access_location_form');

    // Add a submit event listener to the form
    update_access_location_form.addEventListener('submit', e => {
        e.preventDefault();

        // Get the button that triggered the submit event
        var button = document.activeElement;

        // Check the id or name of the button
        if (button.id === 'btnUpdateAccessLocation') {
            // Call the function for the first submit button
            update_access_location();
        } else if (button.id === 'btnDeleteAccessLocation') {
            // Call the function for the first submit button
            delete_access_location();
        }
    });

    const update_access_location = () => {
        var id = document.getElementById('id_access_location_update').value;
        var car_maker = document.getElementById('car_maker_al_update').value;
        var car_model = document.getElementById('car_model_al_update').value;
        var ip = document.getElementById('ip_al_update').value;

        $.ajax({
            url: '../process/me/access_locations/al_p.php',
            type: 'POST',
            cache: false,
            data: {
                method: 'update_access_location',
                id: id,
                car_maker: car_maker,
                car_model: car_model,
                ip: ip
            }, success: function (response) {
                if (response == 'success') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Succesfully Recorded!!!',
                        text: 'Success',
                        showConfirmButton: false,
                        timer: 1000
                    });
                    clear_access_location_details();
                    load_access_locations(1);
                    $('#update_access_location').modal('hide');
                } else if (response == 'duplicate') {
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

    const delete_access_location = () => {
        var id = document.getElementById('id_access_location_update').value;

        $.ajax({
            url: '../process/me/access_locations/al_p.php',
            type: 'POST',
            cache: false,
            data: {
                method: 'delete_access_location',
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
                    clear_access_location_details();
                    load_access_locations(1);
                    $('#update_access_location').modal('hide');
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