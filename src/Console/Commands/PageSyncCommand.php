<?php

namespace Delgont\Cms\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;

use Delgont\Cms\Models\Post\Post;
use Delgont\Cms\Models\Post\PostType;

use Delgont\Cms\Models\Template\Template;
use Delgont\Cms\Models\Category\Category;

use App\User;



class PageSyncCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'page:sync {--fresh} {--key=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Synchronise pages with the default content in data config file.';

    protected $pages;

    private $attributes = ['id', 'post_title', 'created_by', 'slug', 'created_at'];



    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->pages = config('data.pages', []);

    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {

        if(count($this->pages)){
            if ($this->option('fresh')) {
                # code...
                Post::where('created_at', '<', now())->forceDelete();
                $this->sync();
            } else {
                # code...
                if($this->option('key')){
                    $key = $this->option('key');
                    for ($i=0; $i < count($this->pages) ; $i++) { 
                        # code...
                        if($this->pages[$i]['page_key'] == $key){
                            Post::updateOrCreate([
                                'post_title' => (array_key_exists('post_title', $this->pages[$i])) ?  $this->pages[$i]['post_title'] : Str::random(10),
                                'post_content' => (array_key_exists('post_content', $this->pages[$i])) ?  $this->pages[$i]['post_content'] : null,
                                'extract_text' => (array_key_exists('extract_text', $this->pages[$i])) ?  $this->pages[$i]['extract_text'] : null,
                                'post_featured_image' => (array_key_exists('post_featured_image', $this->pages[$i])) ?  $this->pages[$i]['post_featured_image'] : null,
                                'slug' => (array_key_exists('slug', $this->pages[$i])) ?  $this->pages[$i]['slug'] : null,
                                'created_by' => $this->randomAuthorId(),
                            ]);
                            return;
                        }else{
                        }
                    }
                }else{
                    $this->sync();
                }
            }
            
            return;
        }
        $this->info('No options to sync');

    }

    private function sync()
    {
        for ($i=0; $i < count($this->pages) ; $i++) { 
            # code...
            $post = Post::updateOrCreate(['post_title' => $this->pages[$i]['post_title']], [
                'post_title' => (array_key_exists('post_title', $this->pages[$i])) ?  $this->pages[$i]['post_title'] : Str::random(10),
                'post_content' => (array_key_exists('post_content', $this->pages[$i])) ?  $this->pages[$i]['post_content'] : null,
                'extract_text' => (array_key_exists('extract_text', $this->pages[$i])) ?  $this->pages[$i]['extract_text'] : null,
                'post_featured_image' => (array_key_exists('post_featured_image', $this->pages[$i])) ?  $this->pages[$i]['post_featured_image'] : null,
                'slug' => (array_key_exists('slug', $this->pages[$i])) ?  $this->pages[$i]['slug'] : str_replace(' ', '-', $this->pages[$i]['post_title']),
                'post_type_id' => (array_key_exists('post_type', $this->pages[$i])) ? PostType::firstOrCreate(['name' => $this->pages[$i]['post_type']])->id : PostType::firstOrCreate(['name' => 'post'])->id,
                'template_id' => (array_key_exists('template', $this->pages[$i])) ? $this->assignTemplateToPost($this->pages[$i]['template']) : null,
                'created_by' => $this->randomAuthorId(),
            ]);


        }
        $this->info('Pages sychronized successfully ....!');
        $this->table($this->attributes, Post::all($this->attributes));

    }

    private function assignTemplateToPost($templatePath)
    {
        return Template::firstOrCreate(['path' => $templatePath],[
            'name' => Str::random(10)
        ])->id;
    }

    private function assignCategory($post, $category)
    {
        $id = Category::firstOrCreate(['name' => $category], [
            'name' => $category,
            'type' => 'posts'
        ])->id;

        ($id) ? $post->sync($id) : '';
    }

    private function randomAuthorId()
    {
        $user = User::first();
        return ($user) ? $user->id : null;
    }

    
}
