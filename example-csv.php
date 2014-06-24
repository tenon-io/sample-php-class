<?php
require('config.php');
require('tenonTest.class.php');

$expectedPost = array('src', 'url', 'level', 'certainty', 'priority',
    'docID', 'systemID', 'reportID', 'viewport',
    'uaString', 'importance', 'ref', 'importance',
    'fragment', 'store', 'csv');

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

if (false === $tenon->decodeResponse()) {
    $content = '<h1>Error</h1><p>No Response From Tenon API, or JSON malformed.</p>';
    $content .= '<pre>' . var_export($tenon->tenonResponse, true) . '</pre>';
    echo $content;
} else {
    if (false !== $tenon->writeResultsToCSV(CSV_FILE_PATH)) {
        echo 'CSV file written!';
    }
}