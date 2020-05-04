
<?php

include_once 'configs/config.php';


spl_autoload_register(function ($inc) {

    require_once 'libraries/' . $inc . '.class.php';
});
