<?php

namespace Delgont\Cms\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;

use Delgont\Cms\Models\Option\Option;


class OptionCreateCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'option:create';

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
        $this->info('Creating Option ... Please do enter the valid keys.');
        $optionKey = $this->ask('Enter option key');
        $optionValue = $this->ask('Enter Option Value');

        Option::updateOrCreate([
            'option_key' => $optionKey,
            'option_value' => $optionValue
        ]);

        $this->call('option:list');
    }

    
}
