<?php


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

$tenon = new tenon(TENON_API_URL, $opts);

$tenon->submit(DEBUG);

if (false === $tenon->decodeResponse()) {
    $content = '<h1>Error</h1><p>No Response From Tenon API, or JSON malformed.</p>';
    $content .= '<pre>' . var_export($tenon->tenonResponse, true) . '</pre>';
    echo $content;
    exit;
} else {
    $summary = $tenon->processResponseSummary();
    $content .= '<h2>Issues</h2>';
    $content .= $tenon->processIssues();
    $content .= $tenon->rawResponse();
}


if(false !== $tenon->writeResultsToCSV(CSV_FILE_PATH)){
    echo 'CSV file written!';
}