<?php
session_set_cookie_params(0, "/zaihai");
session_name("zaihai");
session_start();

session_unset();
session_destroy();

header('location:/zaihai/login');