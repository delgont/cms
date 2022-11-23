<?php

namespace Delgont\Cms\Services\Template;

use Delgont\Cms\Models\Template\Template;


class TemplateService
{
    private $template;

    public function __construct()
    {
        $this->template = new Template();
    }

    public function all()
    {
        return $this->template::withCount(['posts', 'sections'])->get();
    }

    public function show($id)
    {
        return $this->template->with([
            'posts:id,post_title,template_id'
        ])->findOrFail($id);
    }

    public function disable($id)
    {
        return $this->template->whereId($id)->update([
            'disable' => '1'
        ]);
    }

    public function enable($id)
    {
        return $this->template->whereId($id)->update([
            'disable' => '0'
        ]);
    }
}
