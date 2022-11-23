<?php

namespace Delgont\Cms\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;

use Delgont\Cms\Models\Section\Section;



class  SectionSyncCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'section:sync';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    protected $sections;

    private $attributes = ['id', 'name', 'path', 'created_at'];


    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->sections = (config('web.sections')) ?? [];
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        if (count($this->sections)) {
            foreach ($this->sections as $key => $value) {
                Section::updateOrCreate(['path' => $key],[
                    'name' => (is_array($value)) ? (array_key_exists('name', $value)) ? $value['name'] : Str::random(10) : Str::random(10),
                    'preview' => (is_array($value)) ? (array_key_exists('preview', $value)) ? $value['preview'] : Str::random(10) : Str::random(10),
                    'path' => $key,
                    'created_at' => now()
                ]);
            }
            $this->table($this->attributes, Section::all($this->attributes));
        }else{
            $this->info('No sections to sync');
        }
    }

    
}
