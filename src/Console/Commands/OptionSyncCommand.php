<?php

namespace Delgont\Cms\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;

use Delgont\Cms\Models\Option\Option;


class OptionSyncCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'option:sync';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Synchronise options';


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
        $options = config('web.options', []);

        if (count($options)) {
            # code...
            foreach ($options as $key => $value) {
                # code...
                Option::updateOrCreate([
                    'option_key' => $key,
                    'option_value' => $value
                ]);
            }
            $this->info('Options synchronised successfully ......!');
            $this->call('option:list');
            return;
        }
        $this->info('No options to sync');

    }

    
}
