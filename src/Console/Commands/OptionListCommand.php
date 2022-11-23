<?php

namespace Delgont\Cms\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;

use Delgont\Cms\Models\Option\Option;


class OptionListCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'option:list';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'List options from db';


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
       $this->table(['option_key', 'option_value', 'created_at'], Option::all(['option_key', 'option_value', 'created_at']));
    }

    
}
