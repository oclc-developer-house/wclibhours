<?php
    set_include_path(get_include_path() . PATH_SEPARATOR . 'lib/');
    set_include_path(get_include_path() . PATH_SEPARATOR . 'vendor/');
    require_once "autoload.php";
    require_once "graph.php";
    $turtle = $graph->serialise('turtle');
    print($turtle);
    
    print($graph->dump('html'));
    
?>