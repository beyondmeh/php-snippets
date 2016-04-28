#!/usr/bin/php
<?php

/*********************************************\     
 *       Deadfish~ Interpreter in PHP        *
 *       ~~~~~~~~~~~~~~~~~~~~~~~~~~~~        *
 *     Copyright (c) 2016 Timothy Keith      *
 *  Licensed under the BSD 2-Clause License  *
 *                                           *
 *       http://github.com/keithieopia       *
 *                                           *
\*********************************************/ 

if ($argc > 0) {
    interpret($argv[1]);
    echo "\n";
}
else {
 
    $accumulator = 0;
    while (true) {
        $line = readline('>> ');
        interpret($line);
        
        echo "\n";
    }
}
    
function interpret($line) {
    global $accumulator;
            
    for ($i = 0; $i < strlen($line); $i++){
                
        switch ($line[$i]) {

            //_Vanilla Deadfish_________________________________________________
            case 'i':
                $accumulator++;
                break;
            
            case 'd':
                $accumulator--;
                break;
                
            case 's':
                $accumulator **= 2;
                break;
                
            case 'o':
                echo $accumulator;
                break;
            
            //_Deadfish~________________________________________________________
            case 'h':
                exit;
                break;
                
            case 'w':    
                echo 'Hello, World!';
                break;
                
            case 'c':
                echo chr($accumulator);
                break;
                
            case '{':
                $remaining = substr($line, $i + 1);
                $run = substr($remaining, 0, strpos($remaining, '}'));
                
                for ($x = 0; $x < 10; $x++) {
                    interpret($run);
                }
                
                $i += strlen($run) + 1;
                break;
                
            case '(':
                $remaining = substr($line, $i + 1);
                $run = substr($remaining, 0, strpos($remaining, ')'));
                
                if ($accumulator != 0) {
                    interpret($run);
                }
                
                $i += strlen($run) + 1;
                break;
                break;
                
            default:
                echo 'deadfish: Syntax Error: ' . $line[$i];
                exit(1);
        }
        
        if ($accumulator == -1 || $accumulator == 256) $accumulator = 0;

    }
}

?>
