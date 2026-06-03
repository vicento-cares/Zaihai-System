<script type="text/javascript">
    // DOMContentLoaded function
    document.addEventListener("DOMContentLoaded", () => {
        get_recent_backup_logs();
    });

    document.getElementById('zaihai_backup_form').addEventListener('submit', e => {
        e.preventDefault();
        backup_zaihai_data();
    });

    const backup_zaihai_data = () => {
        let bak_date_from = document.getElementById('bak_date_from').value;
        let bak_date_to = document.getElementById('bak_date_to').value;

        $.ajax({
            url: '../process/backup/zb_p.php',
            type: 'POST',
            cache: false,
            data: {
                method: 'backup_zaihai_data',
                bak_date_from: bak_date_from,
                bak_date_to: bak_date_to
            }, success: function (response) {
                if (response == 'success') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Transfer Zaihai Data to Backup Database Executed Successfully!!!',
                        text: 'Success',
                        showConfirmButton: false,
                        timer: 2000
                    });
                    get_recent_backup_logs();
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error !!!',
                        text: `${response}`,
                        showConfirmButton: false,
                        timer: 2000
                    });
                }
            }
        });
    }

    const get_recent_backup_logs = () => {
		$.ajax({
			type: "GET",
			url: "../process/backup/zb_g_p.php",
			cache: false,
			data: {
				method: "get_recent_backup_logs"
            }, 
			success: (response) => {
                $('#backupLogsData').html(response);
				let table_rows = parseInt(document.getElementById("backupLogsData").childNodes.length);
				$('#count_view').html("Total: " + table_rows);
			}
		});
	}
</script>