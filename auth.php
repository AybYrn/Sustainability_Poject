<?php
if(count(get_included_files()) == ((version_compare(PHP_VERSION, '5.0.0', '>='))?1:0)) {
    exit('Restricted Access');
}



?>