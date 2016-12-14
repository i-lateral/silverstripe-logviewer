<?php

use SilverStripe\Dev\Debug;
use SilverStripe\ORM\ArrayList;
use SilverStripe\ORM\FieldType\DBText;
use SilverStripe\View\Requirements;
use SilverStripe\View\ArrayData;
use SilverStripe\Control\Director;
use SilverStripe\Admin\LeftAndMain;

/**
 * Log Admin class adds a new tab to the admin that will load pre-defined log files
 * into the right hand pain.
 */
class LogAdmin extends LeftAndMain
{
    private static $url_segment = 'logs';
    private static $url_rule = '/$Action/$ID/$OtherID';
    private static $menu_title = 'Logs';

    private static $logs = array();

    /**
     * Load in some custom styling and JS on initial load.
     */
    public function init()
    {
        parent::init();

        Requirements::css('logviewer/css/LogAdmin.css');
        Requirements::javascript('logviewer/javascript/LogAdmin.js');
    }

    /**
     * Use addLog to add log files that will be rendered in the CMS. You can add
     * new logs by calling LogAdmin::addLog($logFile,$linkType) in your _config.
     *
     * @param type $logLoc   File path to log
     * @param type $linkType Say if the path is relative 'r' or absolute 'a'
     */
    public static function addLog($logLoc = null, $linkType = 'a')
    {
        if ($logLoc) {
            array_push(
                self::$logs,
                array(
                    'Location' => self::get_log_path($logLoc, $linkType),
                    'Filename' => basename($logLoc),
                    'Type' => $linkType,
                    'Slug' => str_replace('.', '-', basename($logLoc)),
                )
            );
        }
    }

    /**
     * Return a list of all logs that will be used for navigation.
     *
     * @return ArrayList
     */
    public function getLogList()
    {
        $output = new ArrayList();

        if (count(self::$logs) > 0) {
            foreach (self::$logs as $log) {
                $output->push(new ArrayData($log));
            }

            return $output;
        }
    }

    /**
     * Get detail of a specific log, open and process it, then return
     * to template.
     *
     * @return ArrayData
     */
    public function getLog()
    {
        if (is_array(self::$logs) && count(self::$logs) > 0) {
            $output = new ArrayList();

            if ($this->urlParams['Action'] == 'show' && isset($this->urlParams['ID'])) {
                foreach (self::$logs as $item) {
                    if ($item['Slug'] == $this->urlParams['ID']) {
                        $log = $item;
                    }
                }
            } else {
                $log = self::$logs[0];
            }

            $file = fopen($log['Location'], 'r');
            $fData = fread($file, filesize($log['Location']));

            // Cast the log
            $castLog = new DBText('Log');
            $castLog->setValue(nl2br(strip_tags($fData)));

            //Debug::dump($fData);
            //die;
            $output->push(new ArrayData(array(
                'Filename' => $log['Filename'],
                'Path' => $log['Location'],
                'Data' => $castLog,
            )));

            return $output;
        } else {
            return false;
        }
    }

    /**
     * Method that deals with extracting the correct path, either based on the
     * Silverstripe install base path or use an absolute URL.
     *
     * @param type $path
     * @param type $type
     *
     * @return type
     */
    private static function get_log_path($path = null, $type = 'a')
    {
        if (isset($path) && isset($type)) {
            if ($type == 'r') {
                $fullLog = Director::baseFolder()."/{$path}";
            } elseif ($type == 'a') {
                $fullLog = $path;
            }

            return $fullLog;
        } else {
            return false;
        }
    }
}
