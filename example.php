<?php
/**
 *
 * In this version of the demo, we're taking information submitted from a form and returning it as pure JSON.
 * This is especially useful for an asynchronous response of some kind.
 *
 */

define('TENON_API_KEY', 'put your API key here');
define('TENON_API_URL', 'https://www.tenon.io/api/');
define('DEBUG', false);

require('tenonTest.class.php');

// this section basically creates the $opts array from the $_POST data
// it only sets the items that are non-blank. This allows Tenon to revert to defaults
$expectedPost = array('src', 'url', 'level', 'certainty', 'priority',
    'docID', 'systemID', 'reportID', 'viewPortHeight', 'viewPortWidth',
    'uaString', 'importance', 'ref', 'importance', 'fragment', 'store');

foreach ($_POST AS $k => $v) {
    if (in_array($k, $expectedPost)) {
        if (strlen(trim($v)) > 0) {
            $opts[$k] = $v;
        }
    }
}

$opts['key'] = TENON_API_KEY;

$tenon = new tenonTest(TENON_API_URL, $opts);

$tenon->submit(DEBUG);

// this is the JSON response.
// if calling this file via AJAX, you can then take this JSON and do something more interesting with it
echo $tenon->tenonResponse;