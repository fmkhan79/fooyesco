<?php

class Printer extends CI_Controller {

    public function run_exe() {
        $path = 'C:\Receipt Printer\index.exe';

        // Escape path if needed
        $output = shell_exec("start \"\" \"$path\"");
        
        echo json_encode(['status' => 'success', 'message' => 'EXE launched']);
    }
}