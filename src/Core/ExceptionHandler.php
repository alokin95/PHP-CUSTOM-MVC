<?php


namespace App\Core;

use Throwable;

class ExceptionHandler extends \Exception
{
    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    public function handle()
    {
        $this->getMessage();
        $path_to_log_file = dirname(__FILE__,3).'/var/logs/error.log.txt';
        $date = new \DateTime();
        $date = date_format($date,"d/m/Y H:i:s");
        file_put_contents($path_to_log_file, '[' . $date . '] ' . $this->getMessage() . ' ' . $this->getFile() . ' on line ' . $this->getLine() ."\n",FILE_APPEND | LOCK_EX);

        if (ENV('APP_ENV') === 'dev')
        {
            $browserMessage = $this->getMessage().'. See more in the log file: var/logs/error.log.txt';
            die($browserMessage);
        }
         die('Something went wrong.');
    }
}