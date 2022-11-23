<?php

namespace Delgont\Cms\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;

use Delgont\Cms\Models\Menu\Menu;
use Delgont\Cms\Models\Menu\MenuItem;

use Delgont\Cms\Models\Post\Post;


class MenuItemSyncCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'menuitem:sync {--fresh}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    protected $menus;

    private $attributes = ['id', 'label', 'parent_id', 'sort', 'menu_id', 'menuable_type', 'menuable_id', 'created_at'];


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
        if ($this->option('fresh')) {
            Menu::where('created_at', '<', now())->forceDelete();
            MenuItem::where('created_at', '<', now())->forceDelete();
        }

        $menus = Menu::all(['id', 'key']);

        if(count($menus) > 0){
            $this->sync($menus);
        }else{
            $this->call('menu:sync');
            $menuKeys = Menu::all(['id', 'key']);

            $this->sync($menuKeys);

        }

    }

    private function sync($menus)
    {
        foreach ($menus as $menu) {
            $items = config('web.'.$menu->key, []);
            if (count($items) > 0) {
                foreach ($items as $key => $item) {
                    MenuItem::updateOrCreate(
                        [
                            'label' => (array_key_exists('label', $item)) ? $item['label'] : Str::random(5),
                            'sort' => (array_key_exists('sort', $item)) ? $item['sort'] : 0,
                            'menuable_type' => Post::class,
                            'menu_id' => $menu->id,
                            'menuable_id' => (array_key_exists('post', $item)) ? Post::firstOrCreate(['post_title' => $item['post']])->id : null,
                            'parent_id' => (array_key_exists('parent', $item)) ? $this->getOrCreateParent($menu->id, $item['parent']) : null,
                        ]
                    );
                }
            }
        }
        $this->table($this->attributes, MenuItem::all($this->attributes));
    }

    private function getOrCreateParent($menu_id, $label)
    {
        return MenuItem::whereMenuId($menu_id)->firstOrCreate(['label' => $label],
            [
                'label' => $label,
                'menu_id' => $menu_id
            ]
        )->id;
    }

    
}
