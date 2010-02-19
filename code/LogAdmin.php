<?php
/**
 * Log Admin class adds a new tab to the admin that will load pre-defined log files
 * into the right hand pain.
 * 
 * @package LogViewer
 */
class LogAdmin extends LeftAndMain {
	static $url_segment = 'logs';
	static $url_rule = '/$Action/$ID/$OtherID';
	static $menu_title = 'Logs';
	static $menu_priority = -1;
	static $url_priority = 99;

	static $logs = array();

    public function init() {
		parent::init();

		Requirements::css('logviewer/css/LogAdmin.css');
		Requirements::javascript('logviewer/javascript/LogAdmin.js');
	}

	public function addLog($logFile = null,$linkType = 'r') {
		if($logFile)
			array_push(self::$logs, "$logFile::$linkType");
	}
	
	public function logNav() {
		$output = new DataObjectSet();
		
		if(count(self::$logs) > 0) {
			foreach(self::$logs as $log) {
				$log = $this->get_log_data($log);

				$output->push(new ArrayData(array(
					'File'		=> $log['File'],
					'Link'		=> $log['Link']
				)));
			}

			return $output;
		}
	}

	public function showLogs() {
		$output = new DataObjectSet();

		if(count(self::$logs) > 0) {
			foreach(self::$logs as $log) {
				$log = $this->get_log_data($log);

				$output->push(new ArrayData(array(
					'File'		=> $log['File'],
					'Link'		=> $log['Link'],
					'LogData'	=> $log['LogData']
				)));
			}

			return $output;
		}
	}
	
	private function get_log_data($log = "") {
		$log = explode('::', $log);

		if($log[1] == 'r')
			$fullLog = Director::baseFolder()."/$log[0]";
		elseif($log[1] == 'a')
			$fullLog = $log;
			
		$fileName	= explode('/',$log[0]);
		$fileName	= $fileName[count($fileName) - 1];
		$file		= fopen($fullLog, 'r');
		$fData		= fread($file, filesize($fullLog));
		$fData		= nl2br(strip_tags($fData));

		// Cast the log
		$castLog = new Text('Log');
		$castLog->setValue($fData);
		
		return array(
			'File'		=> $fileName,
			'Link'		=> $log[0],
			'LogData'	=> $castLog
		);
	}
}
?>