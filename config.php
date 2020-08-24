<?php
/*
 * program config constants
 * TODO: this should be moved to .env
 */

// script values
define('MAX_EXECUTION_TIME_PHP', 0); // setting this to 0 will allow the script to run forever, be careful!
define('SLEEP_TIME', 60); // the main loop will sleep 60 secs before re-check if chill program still running
define('OUTPUT_FILE_LINES', 50); // how many lines of the output file you want to load

// Email values
define('EMAIL_TO', 'toEmail@test.com');
define('EMAIL_FROM', 'fromEmail@test.com');

// https://sendgrid.com/ API values
define('API_KEY', 'Your Send Grid API KEY Here');
define('API_URL', 'https://api.sendgrid.com/');
