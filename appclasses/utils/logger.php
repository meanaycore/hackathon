<?php

/**
 * Simple Logging Class
 */
class Logger
{
    /**
     * @var string $logFile
     */
    protected static $logFile = '';
    
    /**
     * @var boolean Logging Enabled - should be FALSE on Production
     */
    public static $loggingEnabled = TRUE;
    
    public static function setLogFile($logFile)
    {
        static::$logFile = $logFile;
    }
    
    /**
     * Method to log a line
     * @param string $comment Log Comment
     * @param string $file Name of the File
     * @param string $line Line in the file
     * @param string $method Current Method
     * 
     * @example Logger::log('log comment goes here', __FILE__, __LINE__, __METHOD__);
     */
    public static function log($comment, $file, $line, $method)
    {
        if (!static::$loggingEnabled && !empty(static::$logFile)) {
            return FALSE;
        }
        
        if (is_array($comment) || is_object($comment)) {
            $comment = print_r($comment, TRUE);
        }
        
        $log = array(
            date('Y-m-d H:i:s'),
            str_replace(APPLICATION_PATH, '', $file),
            'Line: '.$line,
            $method,
            $comment,
        );
        
        $line = implode(' | ', $log);
        
        try {
            file_put_contents(static::$logFile, "\n".$line, FILE_APPEND);
        } catch (Exception $e) {
            // Do nothing, just hide errors
        }
    }
}