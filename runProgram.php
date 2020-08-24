<?php
/*
 * Using SendGrid and Process class launch a new program redirect output and send email when is done!
 *
 * usage: php runProgram.php -p 'PROGRAM NAME' -f '/path/to/file.ext'
 * example: php runProgram.php -p 'echo testOutPutMessage' -f 'test.txt'
 *
 */

include 'config.php';
include 'processClass.php';
include 'sendGridMailerClass.php';

// remove max execution time for this php script
set_time_limit(MAX_EXECUTION_TIME_PHP);
ignore_user_abort(true);

$shortOpts = "p:";  // required -p param (program name to run)
$shortOpts .= "f:";  // required -f param (output file)
$opts = getopt($shortOpts);
$output_file = $opts['f'] ?? false;
$program = $opts['p'];

$process = new Process($program, $output_file);
while ($process->status()) {
    // program running
    sleep(SLEEP_TIME); // avoid CPU exhaustion
}

$mailer = new SendGridMailer($program, $output_file, $process->getOutPutFileContent());
$mailer_res = $mailer->send();

if($mailer_res->message == 'success'){
    echo ' - All good!, email sent - ';
} else {
    // something went wrong
    echo $mailer_res->message;
}
