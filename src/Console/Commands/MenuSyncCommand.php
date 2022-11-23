<?php

namespace Delgont\Cms\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;

use Delgont\Cms\Models\Menu\Menu;



class MenuSyncCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'menu:sync {--fresh}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    protected $menus;

    private $attributes = ['id', 'name', 'key', 'created_at'];


    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->menus = config('web.menus');
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        ($this->option('fresh')) ? $this->clearAndSync() : $this->sync();
    }

    private function sync()
    {
        if (count($this->menus)) {
            foreach ($this->menus as $key => $value) {
                Menu::updateOrCreate(['key' => $key],[
                    'name' => $value,
                    'key' => $key,
                    'created_at' => now()
                ]);
            }
            $this->table($this->attributes, Menu::all($this->attributes));
        }else{
            $this->info('No Menus to sync');
        }
    }

    private function clearAndSync()
    {
        Menu::where('created_at', '<', now())->forceDelete();
        $this->sync();
    }

    
}
