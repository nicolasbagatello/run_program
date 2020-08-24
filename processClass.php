<?php
/*
 * simple class to launch an external process, keep track of the PID and status.
 *
 */

class Process {
    private $pid;
    private $command;
    private $outputFile;

    public function __construct($cl=false, $outputFile=false) {
        if ($cl != false) {
            $this->command = $cl;
            $this->outputFile = $outputFile;
            $this->runCom();
        }
    }

    private function runCom() {
        if ($this->outputFile != false) {
            // program output goes to designated file
            $outputFile = ' > ' . $this->outputFile . ' & echo $!';
        } else {
            // program output goes to dev/null
            $outputFile = ' > /dev/null 2>&1 & echo $!';
        }
        $command = 'nohup ' . $this->command . $outputFile;
        exec($command ,$op);
        $this->pid = (int)$op[0];
    }

    public function status() {
        $command = 'ps -p ' . $this->pid;
        exec($command,$op);
        if (!isset($op[1]))return false;
        else return true;
    }

    public function getOutPutFileContent(): string {
        // check if output file was set and if exist
        if($this->outputFile != false && file_exists($this->outputFile)) {
            $command_tail = 'tail -n ' . OUTPUT_FILE_LINES . ' ' . $this->outputFile;
            $tail = shell_exec($command_tail);
        } else {
            $tail = 'designated output file: ' . $this->outputFile . 'not found!';
        }

        return $tail;
    }
}
