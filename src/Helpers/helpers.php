<?php
//use Delgont\Cms\Services\Option\OptionService;
use Delgont\Cms\Repository\Option\OptionRepository;

//returns a option value
if(!function_exists('option')){
    function option($option_key, $default = null, $cache = true){
        return app(OptionRepository::class)->setKey('option_key')->fromCache()->value($option_key, $default);
    }
}
