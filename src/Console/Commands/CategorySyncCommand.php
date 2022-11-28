<?php

namespace Delgont\Cms\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;

use Delgont\Cms\Models\Category\Category;
use Delgont\Cms\Models\Post\Post;


class CategorySyncCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'category:sync';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Synchronise categories .....';

    private $attributes = ['id', 'name', 'type', 'created_at'];



    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $categories = config('web.categories', []);
        if(count($categories)){
            for ($i=0; $i < count($categories); $i++) { 
                Category::updateOrCreate([
                    'name' => $categories[$i],
                    'type' => Post::class
                ]);
            }
            $this->info('Categories Synchronised');
            $this->table($this->attributes, Category::all($this->attributes));
        }
    }

    
}
