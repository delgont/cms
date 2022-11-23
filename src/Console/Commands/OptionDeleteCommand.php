<?php

namespace Delgont\Cms\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;

use Delgont\Cms\Models\Option\Option;


class OptionDeleteCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'option:delete {--key=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete option by its key';


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
            Option::where('option_key', $this->option('key'))->delete();
            $this->info('Option deleted successfully ....!');
        }
    }

    
}
