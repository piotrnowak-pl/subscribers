<?php

// Methoda do debugowania
function pre(){
    $e = new Exception();
    $trace = explode("\n", $e->getTraceAsString());
    $tracename = $trace[0];
    if(strpos($trace[1],'log') !== false && strpos($trace[1],'debug') !== false){
        $tracename = $trace[1];
    }

    $path = dirname(__DIR__);
    $trace = explode($path,$tracename);
    $trace = $trace[1] ??'';
    $trace = explode(':',$trace);
    $trace = $trace[0] ?? '';
    $args = func_get_args();
    foreach($args as $arg){
        $a = print_r($arg,true);
        $a = str_replace('    ','  ',$a);
        $a = htmlentities($a);
        $a = str_replace('stdClass Object','<span style="font-weight:bold; color:#ffcc00">Object</span>',$a);
        $a = str_replace('Array','<span style="font-weight:bold; color:#ffcc00">Array</span>',$a);
        echo '<pre style="font:11px Monospace; border:1px solid #aaa; padding:5px; background:#444; color:white; margin:1px 0px 0px 0px;  white-space: break-spaces; "><div style="color:#aaa; background:#222; padding:1px 4px; margin:-1px">'.$trace."</div>".($a).'</pre>';
    }
}