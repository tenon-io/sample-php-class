<?php

/**
 *    This class submits a request against the Tenon API for automatic
 *    accessibility testing.
 *
 *    Essentially all this does is populate a variable, $tenonResponse, with the JSON response from Tenon
 *
 */
class tenonTest
{
    protected $url, $opts;
    public $tenonResponse, $tCode;

    /**
     * Class constructor
     *
     * @param   string $url  the API url to post your request to
     * @param    array $opts options for the request
     */
    public function __construct($url, $opts)
    {
        $this->url = $url;
        $this->opts = $opts;
        $this->tenonResponse = '';
    }

    /**
     * Submits the HTML source for testing
     *
     * @param   bool $printInfo whether or not to print the output from curl_getinfo (usually for debugging only)
     *
     * @return    string    the results, formatted as JSON
     */
    public function submit($printInfo = false)
    {

        if (true == $printInfo) {
            echo '<h2>Options Passed To TenonTest</h2><pre><br>';
            var_dump($this->opts);
            echo '</pre>';
        }

        //open connection
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $this->url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_FAILONERROR, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $this->opts);

        //execute post and get results
        $result = curl_exec($ch);

        if (true == $printInfo) {
            echo 'ERROR INFO (if any): ' . curl_error($ch) . '<br>';
            echo '<h2>Curl Info </h2><pre><br>';
            print_r(curl_getinfo($ch));
            echo '</pre>';
        }

        $this->tCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        //close connection
        curl_close($ch);

        //the test results
        $this->tenonResponse = $result;

    }
}