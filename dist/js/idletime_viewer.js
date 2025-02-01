// IDLE TIME DETECT INACTIVITY
var idleTime = 0;
document.addEventListener("DOMContentLoaded", () => {
  var idleInterval = setInterval(timerIncrement, 60000); //PER 1 MINUTE
  document.addEventListener("mousemove", e => { idleTime = 0 });
  document.addEventListener("keypress", e => { idleTime = 0 });
  document.addEventListener("mousedown", e => { idleTime = 0 });
  document.addEventListener("click", e => { idleTime = 0 });
  document.addEventListener("keydown", e => { idleTime = 0 });
  document.addEventListener("scroll", e => { idleTime = 0 });
});

const timerIncrement = () => {
  idleTime = idleTime + 1;
  if (idleTime > 2) {
    let url_path = window.location.pathname;

    // switch (url_path) {
    //     case "/zaihai/shop/applicator_list.php":
    //         // Notif Interval
    //         clearInterval(realtime_load_notif);
    //         clearInterval(realtime_load_notif_req);
    //         break;
    //     default:
    // }

    switch (url_path) {
      case "/zaihai/viewer/applicator_list.php":
        // Applicator List Interval
        clearInterval(realtime_get_recent_applicator_list);
        break;
      case "/zaihai/viewer/applicator_out.php":
        // Applicator Out Interval
        clearInterval(realtime_get_recent_applicator_out);
        break;
      case "/zaihai/viewer/applicator_in.php":
        // Applicator In Interval
        clearInterval(realtime_get_recent_applicator_in);
        break;
      case "/zaihai/viewer/applicator_err_mon.php":
        // Applicator Out Interval
        clearInterval(realtime_get_recent_applicator_err_mon);
        break;
      default:
    }

    if (url_path != "/zaihai/viewer/dashboard.php" && url_path != "/zaihai/viewer/applicator_history.php") {
      window.location.href = '../index.php';
    }
  }
}