<?php

namespace Delgont\Cms\Models\File;


use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\File as RealFile;

use Delgont\Cms\Models\Concerns;



class File extends Model
{
    use Concerns\Searchable,
        Concerns\Categorable,
        Concerns\Groupable,
        Concerns\HasOptions,
        Concerns\Iconable;

    /**
     * Searchable file attributes
     */
    protected $searchable = ['label', 'mime_type', 'description'];

    protected $with = ['categories', 'groups', 'icon:id,url,iconable_id'];


    public static function boot() {

	    parent::boot();

	    static::deleted(function($file) {
            \Log::info($file->url);
            if (RealFile::exists(public_path($file->url))) {
                RealFile::delete(public_path($file->url));
            }
	    });

	    static::deleting(function($file) {
	    });
	    
	}

    /**
     * Local Scope to get models of mime type image
     * 
     * @param $query
     * @param string $category
     * @return Object
     */
    public function scopeImage($query, $mimeType = null) : Object
    {
        return $query
        ->where('mime_type', 'LIKE', '%'.'image/'.'%');
    }


   
}
