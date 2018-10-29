<?php

    //Database Constants
    const DB_SERVER = "localhost";
    //defined(DB_USER = DB_USER", "gallery";
    const DB_USER ="slyvia";
    //const DB_PASS = DB_PASS", "phpOTL123";
    const DB_PASS = "slyvia";
    const DB_NAME = "slyvia";

    const DS = DIRECTORY_SEPARATOR;

    const SITE_ROOT = DS.'wamp'.DS.'www'.DS.'slyvia';
    const SITE_LINK = "/slyvia/public/";

    const LIB_PATH = SITE_ROOT.DS.'includes';
    const LAYOUT_PATH = SITE_ROOT.DS.'layouts';

    $CURRENT_TIME = strftime("%Y-%m-%d %H:%M:%S", time());
?>