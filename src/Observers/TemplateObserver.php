<?php

namespace Delgont\Cms\Observers;

use Delgont\Cms\Models\Template\Template;
use Illuminate\Support\Facades\Cache;

use Delgont\Cms\Cache\Template\TemplateCacheManager;



class TemplateObserver
{

    protected $templateCacheManager;

    public function __construct()
    {
        $this->templateCacheManager = app(TemplateCacheManager::class);
    }

    /**
     * Handle the option "created" event.
     *
     * @param  \App\Option  $option
     * @return void
     */  
    public function created(Template $template)
    {
        $this->templateCacheManager->storePathInCache($template);
    }


    /**
     * Handle the option "created" event.
     *
     * @param  \App\Option  $option
     * @return void
     */  
    public function retrieved(Template $template)
    {
        $this->templateCacheManager->storePathInCache($template);
    }

    /**
     * Handle the option "updated" event.
     *
     * @param  \App\Option  $option
     * @return void
     */
    public function updated(Template $template)
    {
    }

    /**
     * Handle the option "deleted" event.
     *
     * @param  \App\Option  $option
     * @return void
     */
    public function deleted(Template $template)
    {
    }

    /**
     * Handle the option "restored" event.
     *
     * @param  \App\Option  $option
     * @return void
     */
    public function restored(Template $template)
    {
    }

    /**
     * Handle the option "force deleted" event.
     *
     * @param  \App\Option  $option
     * @return void
     */
    public function forceDeleted(Template $template)
    {
    }
}
