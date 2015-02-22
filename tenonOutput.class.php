<?php

/**
 * Project: sample-php-class
 * User: karlgroves
 * Date: 6/23/14
 * Time: 3:58 PM
 */
class tenonOutput extends tenonTest
{

    protected $url, $opts;
    public $tenonResponse;

    /**
     * Class constructor
     *
     * @param   string $url  the API url to post your request to
     * @param    array $opts options for the request
     */
    public function __construct($url, $opts)
    {
        parent::__construct($url, $opts);
    }


    /**
     * @return mixed
     */
    public function decodeResponse()
    {
        if ((false !== $this->tenonResponse) && (!is_null($this->tenonResponse))) {
            $result = json_decode($this->tenonResponse, true);
            if (!is_null($result)) {
                $this->rspArray = $result;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }


    /**
     * @param $val
     *
     * @return string
     */
    public static function boolToString($val)
    {
        if ($val == '1') {
            return 'Yes';
        } else {
            return 'No';
        }
    }

    /**
     *
     * @return mixed
     */
    public function processResponseSummary()
    {
        if ((false === $this->rspArray) || (is_null($this->rspArray))) {
            return false;
        }

        $output = '';
        $output .= '<h2>Your Request</h2>';
        $output .= '<ul>';
        $output .= '<li>DocID: ' . $this->rspArray['request']['docID'] . '</li>';
        $output .= '<li>Certainty: ' . $this->rspArray['request']['certainty'] . '</li>';
        $output .= '<li>Level: ' . $this->rspArray['request']['level'] . '</li>';
        $output .= '<li>Priority: ' . $this->rspArray['request']['priority'] . '</li>';
        $output .= '<li>Importance: ' . $this->rspArray['request']['importance'] . '</li>';
        $output .= '<li>Report ID: ' . $this->rspArray['request']['reportID'] . '</li>';
        $output .= '<li>System ID: ' . $this->rspArray['request']['projectID'] . '</li>';
        $output .= '<li>User-Agent String: ' . $this->rspArray['request']['uaString'] . '</li>';
        $output .= '<li>URL: ' . $this->rspArray['request']['url'] . '</li>';
        $output .= '<li>Viewport: ' . $this->rspArray['request']['viewport']['width'] . ' x ' . $this->rspArray['request']['viewport']['height'] . '</li>';
        $output .= '<li>Fragment? ' . self::boolToString($this->rspArray['request']['fragment']) . '</li>';
        $output .= '<li>Store Results? ' . self::boolToString($this->rspArray['request']['store']) . '</li>';
        $output .= '</ul>';

        $output .= '<h2>Response</h2>';
        $output .= '<ul>';
        $output .= '<li>Document Size: ' . $this->rspArray['documentSize'] . ' bytes </li>';
        $output .= '<li>Response Code: ' . $this->rspArray['status'] . '</li>';
        $output .= '<li>Response Type: ' . $this->rspArray['message'] . '</li>';
        $output .= '<li>Response Time: ' . date("F j, Y, g:i a", strtotime($this->rspArray['responseTime'])) . '</li>';
        $output .= '<li>Response Execution Time: ' . $this->rspArray['responseExecTime'] . ' seconds</li>';
        $output .= '</ul>';

        $output .= '<h2>Global Stats</h2>';
        $output .= '<ul>';
        $output .= '<li>Global Density, overall: ' . $this->rspArray['globalStats']['allDensity'] . '</li>';
        $output .= '<li>Global Error Density: ' . $this->rspArray['globalStats']['errorDensity'] . '</li>';
        $output .= '<li>Global Warning Density: ' . $this->rspArray['globalStats']['warningDensity'] . '</li>';
        $output .= '</ul>';

        $output .= '<h3>Density</h3>';
        $output .= '<ul>';
        $output .= '<li>Overall Density: ' . $this->rspArray['resultSummary']['density']['allDensity'] . '%</li>';
        $output .= '<li>Error Density: ' . $this->rspArray['resultSummary']['density']['errorDensity'] . '%</li>';
        $output .= '<li>Warning Density: ' . $this->rspArray['resultSummary']['density']['warningDensity'] . '%</li>';
        $output .= '</ul>';

        $output .= '<h3>Issue Counts</h3>';
        $output .= '<ul>';
        $output .= '<li>Total Issues: ' . $this->rspArray['resultSummary']['issues']['totalIssues'] . '</li>';
        $output .= '<li>Total Errors: ' . $this->rspArray['resultSummary']['issues']['totalErrors'] . '</li>';
        $output .= '<li>Total Warnings: ' . $this->rspArray['resultSummary']['issues']['totalWarnings'] . '</li>';
        $output .= '</ul>';

        $output .= '<h3>Issues By WCAG Level</h3>';
        $output .= '<ul>';
        $output .= '<li>Level A: ' . $this->rspArray['resultSummary']['issuesByLevel']['A']['count'];
        $output .= ' (' . $this->rspArray['resultSummary']['issuesByLevel']['A']['pct'] . '%)</li>';
        $output .= '<li>Level AA: ' . $this->rspArray['resultSummary']['issuesByLevel']['AA']['count'];
        $output .= ' (' . $this->rspArray['resultSummary']['issuesByLevel']['AA']['pct'] . '%)</li>';
        $output .= '<li>Level AAA: ' . $this->rspArray['resultSummary']['issuesByLevel']['AAA']['count'];
        $output .= ' (' . $this->rspArray['resultSummary']['issueSummary']['AAA']['pct'] . '%)</li>';
        $output .= '</ul>';

        $output .= '<h3>Client Script Errors, if any</h3>';
        $output .= '<p>(Note: "NULL" or empty array here means there were no errors.)</p>';
        $output .= '<pre>' . var_export($this->rspArray['clientScriptErrors'], true) . '</pre>';

        return $output;
    }

    /**
     *
     * @return   string
     */
    function processIssues()
    {
        $issues = $this->rspArray['resultSet'];

        $count = count($issues);

        if ($count > 0) {
            $i = 0;
            for ($x = 0; $x < $count; $x++) {
                $i++;
                $output .= '<div class="issue">';
                $output .= '<div>' . $i . ': ' . $issues[$x]['errorTitle'] . '</div>';
                $output .= '<div>' . $issues[$x]['errorDescription'] . '</div>';
                $output .= '<div><pre><code>' . trim($issues[$x]['errorSnippet']) . '</code></pre></div>';
                $output .= '<div>Line: ' . $issues[$x]['position']['line'] . '</div>';
                $output .= '<div>Column: ' . $issues[$x]['position']['column'] . '</div>';
                $output .= '<div>xPath: <pre><code>' . $issues[$x]['xpath'] . '</code></pre></div>';
                $output .= '<div>Certainty: ' . $issues[$x]['certainty'] . '</div>';
                $output .= '<div>Priority: ' . $issues[$x]['priority'] . '</div>';
                $output .= '<div>Best Practice: ' . $issues[$x]['resultTitle'] . '</div>';
                $output .= '<div>Reference: ' . $issues[$x]['ref'] . '</div>';
                $output .= '<div>Standards: ' . implode(', ', $issues[$x]['standards']) . '</div>';
                $output .= '<div>Issue Signature: ' . $issues[$x]['signature'] . '</div>';
                $output .= '<div>Test ID: ' . $issues[$x]['tID'] . '</div>';
                $output .= '<div>Best Practice ID: ' . $issues[$x]['bpID'] . '</div>';
                $output .= '</div>';
            }
        }

        return $output;
    }


    /**
     * @param $pathToFolder
     *
     * @return bool
     */
    public function writeResultsToCSV($pathToFolder)
    {
        $url = $this->rspArray['request']['url'];
        $issues = $this->rspArray['resultSet'];
        $name = htmlspecialchars($this->rspArray['request']['docID']);
        $count = count($issues);

        if ($count < 1) {
            return false;
        }

        for ($x = 0; $x < $count; $x++) {
            $rows[$x] = array(
                $url,
                $issues[$x]['tID'],
                $issues[$x]['resultTitle'],
                $issues[$x]['errorTitle'],
                $issues[$x]['errorDescription'],
                implode(', ', $issues[$x]['standards']),
                html_entity_decode($issues[$x]['errorSnippet']),
                $issues[$x]['position']['line'],
                $issues[$x]['position']['column'],
                $issues[$x]['xpath'],
                $issues[$x]['certainty'],
                $issues[$x]['priority'],
                $issues[$x]['ref'],
                $issues[$x]['signature']
            );
        }

        // Put a row of headers up on the beginning
        array_unshift($rows, array('URL', 'testID', 'Best Practice', 'Issue Title', 'Description',
            'WCAG SC', 'Issue Code', 'Line', 'Column', 'xPath', 'Certainty', 'Priority', 'Reference', 'Signature'));

        // MAKE SURE THE FILE DOES NOT ALREADY EXIST
        if (!file_exists($pathToFolder . $name . '.csv')) {
            $fp = fopen($pathToFolder . $name . '.csv', 'w');
            foreach ($rows as $fields) {
                fputcsv($fp, $fields);
            }
            fclose($fp);

            return true;
        }

        return false;
    }
} 