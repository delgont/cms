<?php

namespace Delgont\Cms\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;

use Delgont\Cms\Models\Option\Option;


class OptionUpdateCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'option:update {--key=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update option by its key';


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
        if($this->option('key')){
            $optionValue = $this->ask('Enter option value');
            Option::where('option_key', $this->option('key'))->update([
                'option_value' => $optionValue
            ]);
            $this->info('Option updated successfully ....!');
        }
    }

    
}
