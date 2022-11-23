<?php

namespace Delgont\Cms\Console\Commands;

use Illuminate\Console\Command;
use App\User;
use Illuminate\Support\Str;


class UserListCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:list {--id= : User id}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'List all the users';

    private $user;

    private $attributes = ['id', 'name', 'email', 'email_verified_at', 'created_at'];


    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(User $user)
    {
        parent::__construct();
        $this->user = $user;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        if($this->option('id')){
            $this->table($this->attributes, $this->listUser($this->option('id')));
            return;
        }
        $this->table($this->attributes, $this->listUsers());
    }

    private function listUsers() : array 
    {
        return $this->user->all($this->attributes)->toArray();
    }

    private function listUser($id) : array 
    {
        return $this->user->where('id', $id)->get($this->attributes)->toArray();
    }

    
}
