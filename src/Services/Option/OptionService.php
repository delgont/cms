<?php

namespace Delgont\Cms\Services\Option;

use Delgont\Cms\Models\Option\Option;


class OptionService
{
    /**
     * Gets the value of the option
     */
    public function option($key, $default = null, $cache = true)
    {
        if(cache($key)){
            return cache($key);
        }else{
            $option = Option::whereOptionKey($key)->first()['option_value'] ?? $default;
            ($cache) ? cache([$key => $option]) : '';
            return $option;
        }
    }
}

