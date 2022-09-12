<?php
    function testInput($a)   {
        $a=htmlspecialchars(addslashes(trim($a)));
        return $a;
    }
?>