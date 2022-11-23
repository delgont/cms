<?php

namespace Delgont\Cms\Console\Commands;

use Illuminate\Console\Command;
use App\User;
use Illuminate\Support\Str;
use Delgont\Cms\Models\Post\PostType;



class PostTypeSyncCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'posttype:sync';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    protected $posttypes;

    private $attributes = ['id', 'name', 'created_at'];


    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->posttypes = config('web.post_types');
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        if (count($this->posttypes)) {
            for ($i=0; $i < count($this->posttypes) ; $i++) { 
                PostType::updateOrCreate([
                    'name' => $this->posttypes[$i]
                ]);
            }
            $this->info('Good ...wel done');
            $this->table($this->attributes, PostType::all($this->attributes));
        }else{
            $this->info('No post types to sync');
        }
    }

    
}
