<?php

namespace Delgont\Cms\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;

use Delgont\Cms\Models\Template\Template;



class  TemplateSyncCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'template:sync';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    protected $templates;

    private $attributes = ['id', 'name', 'path', 'created_at'];


    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->templates = config('web.templates');
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        if (count($this->templates)) {
            foreach ($this->templates as $key => $value) {
                Template::updateOrCreate(['path' => $key],[
                    'name' => (is_array($value)) ? (array_key_exists('name', $value)) ? $value['name'] : Str::random(10) : Str::random(10),
                    'description' => (is_array($value)) ? (array_key_exists('description', $value)) ? $value['description'] : Str::random(10) : Str::random(10),
                    'preview' => (is_array($value)) ? (array_key_exists('preview', $value)) ? $value['preview'] : Str::random(10) : Str::random(10),
                    'path' => $key,
                    'created_at' => now()
                ]);
            }
            $this->table($this->attributes, Template::withOut(['sections'])->get($this->attributes));
        }else{
            $this->info('No Template to sync');
        }
    }

    
}
