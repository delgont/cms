<?php

namespace Delgont\Cms\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;

use Delgont\Cms\Models\Section\Section;
use Delgont\Cms\Models\Option\ModelOption;




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
                $section = Section::updateOrCreate(['path' => $key],[
                    'name' => (is_array($value)) ? (array_key_exists('name', $value)) ? $value['name'] : Str::random(10) : Str::random(10),
                    'preview' => (is_array($value)) ? (array_key_exists('preview', $value)) ? $value['preview'] : null : null,
                    'path' => $key,
                    'created_at' => now()
                ]);
                if(is_array($value)){
                    if (array_key_exists('options', $value)) {
                        if(is_array($value['options'])){
                            foreach ($value['options'] as $optionKey => $optionValue) {
                                $section->options()->updateOrCreate(['key' => $optionKey],[
                                    'key' => $optionKey,
                                    'value' => $optionValue
                                ]);
                            }
                        }
                    }
                }
            }
            $this->info('Sychronised Sections');
            $this->table($this->attributes, Section::all($this->attributes));

            $this->info('Sychronised Section Options');
            $this->table(['key', 'value','model_type', 'model_id'], app(ModelOption::class)::where('model_type', Section::class)->get(['key', 'value','model_type', 'model_id']));
        }else{
            $this->info('No sections to sync');
        }
    }

    
}
