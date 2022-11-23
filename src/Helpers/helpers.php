<?php
use Delgont\Cms\Services\Option\OptionService;


//returns a option value
if(!function_exists('option')){
    function option($option_key, $default = null, $cache = true){
        return (new OptionService)->option($option_key, $default, $cache);
    }
}
