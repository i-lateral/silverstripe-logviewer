<?php
/**
 * Log Admin class adds a new tab to the admin that will load pre-defined log files
 * into the right hand pain.
 * 
 * @package LogViewer
 */
class LogAdmin extends LeftAndMain {
    public static $url_segment = 'logs';
    public static $url_rule = '/$Action/$ID/$OtherID';
    public static $menu_title = 'Logs';
    public static $menu_priority = -1;
    public static $url_priority = 99;

    private static $logs = array();

    public function init() {
        parent::init();

        Requirements::css('logviewer/css/LogAdmin.css');
        Requirements::javascript('logviewer/javascript/LogAdmin.js');
    }

    /**
     * Use addLog to add log files that will be rendered in the CMS. You can add
     * new logs by calling LogAdmin::addLog($logFile,$linkType) in your _config.
     * 
     * @param type $logLoc File path to log
     * @param type $linkType Say if the path is relative 'r' or absolute 'a'
     */
    public function addLog($logLoc = null,$linkType = 'r') {
        if($logLoc)
            array_push(
                self::$logs,
                array(
                    'Location'  => self::get_log_path($logLoc,$linkType),
                    'Filename'  => basename($logLoc),
                    'Type'      => $linkType
                )
            );
    }

    /**
     * Return a list of all logs that will be used for navigation
     * 
     * @return DataObjectSet 
     */    
    public function getLogList() {
        $output = new DataObjectSet();

        if(count(self::$logs) > 0) {
            foreach(self::$logs as $log) {
                $output->push(new ArrayData(array(
                    'File'  => $log['Filename'],
                    'Slug'  => str_replace('.', '-', $log['Filename'])
                )));
            }

            return $output;
        }
    }

    /**
     * Get detail of a specific log, open and process it, then return
     * to template
     * 
     * @return ArrayData
     */
    public function getLog() {
        if(is_array(self::$logs) && count(self::$logs) > 0) {
            if($this->urlParams['Action'] == 'show' && isset($this->urlParams['ID'])) {
                
            } else {
                $log = self::$logs[0];
            }
            
            $file       = fopen($log['Location'], 'r');
            $fData      = fread($file, filesize($log['Location']));

            // Cast the log
            $castLog = new Text('Log');
            $castLog->setValue(nl2br(strip_tags($fData)));

            return array(
                'Filename'  => $log['Filename'],
                'Path'      => $log['Location'],
                'Data'      => $castLog
            );
        } else
            return false;
    }
    
    /**
     * Method responsible for opening and processing a log file sent to it
     * 
     * @param type $log 
     */    
    private function get_log_contents($log = null) {
        if(isset($log)) {
            
        }
    }
    
    /**
     * Method that deals with extracting the correct path, either based on the
     * Silverstripe install base path or use an absolute URL.
     * 
     * @param type $path
     * @param type $type
     * @return type 
     */
    private function get_log_path($path = null, $type = null) {
        if(isset($path) && isset($type)) {
            if($type == 'r')
                $fullLog = Director::baseFolder() . "/{$path}";
            elseif($type == 'a')
                $fullLog = $path;
        
            return $fullLog;
        } else
            return false;
    }
}
?>