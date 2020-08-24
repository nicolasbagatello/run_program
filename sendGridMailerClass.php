<?php
/*
 * Simple class to send emails using sendGrid API and curl
 *
 */
include 'config.php';

class SendGridMailer {
    const API_KEY = API_KEY;
    const API_URL = API_URL;
    const EMAIL_FROM = EMAIL_FROM;
    const EMAIL_TO = EMAIL_TO;

    private $session;

    public function __construct(string $program, string $output_file, string $tail) {
        $this->configure($program, $output_file, $tail);
    }

    private function configure($program, $output_file, $tail) {
        $js = array(
            'sub' => array(':name' => array('test')),
        );

        $params = [
            'x-smtpapi' => json_encode($js),
            'to'        => self::EMAIL_TO,
            'subject'   => 'Program "' . $program . '" Finished!',
            'html'      => 'the program running -> <strong>' . $program
                . '</strong> is done. <br> here you have the logs located in: ' . $output_file
                .'<br><hr><br><br>' . $tail,
            'text'      => 'the program running ' . $program . ' is done here you have the logs located in: ' . $output_file,
            'from'      => self::EMAIL_FROM,
       ];

        $request =  SELF::API_URL . 'api/mail.send.json';

        // Generate curl request
        $this->session = curl_init($request);
        // Tell PHP not to use SSLv3 (instead opting for TLS)
        curl_setopt($this->session, CURLOPT_SSLVERSION, CURL_SSLVERSION_TLSv1_2);
        curl_setopt($this->session, CURLOPT_HTTPHEADER, array('Authorization: Bearer ' . self::API_KEY));
        // Tell curl to use HTTP POST
        curl_setopt ($this->session, CURLOPT_POST, true);
        // Tell curl that this is the body of the POST
        curl_setopt ($this->session, CURLOPT_POSTFIELDS, $params);
        // Tell curl not to return headers, but do return the response
        curl_setopt($this->session, CURLOPT_HEADER, false);
        curl_setopt($this->session, CURLOPT_RETURNTRANSFER, true);
    }

    public function send() {
        $response = curl_exec($this->session);
        curl_close($this->session);

        return json_decode($response);
    }
}
