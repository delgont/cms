<?php

namespace Delgont\Cms\Console\Commands;

use Illuminate\Console\Command;
use App\User;
use Illuminate\Support\Str;


class UserCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'delgont:user
                            {--list : List all the users from the db}
                            {--create : Create user}
                            {--default : create default user}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    private $user;

    private $attributes = ['id', 'name', 'email', 'created_at'];


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
        if ($this->option('create') && $this->option('default')) {
            $this->createDefaultUser();
            return;
        }else if($this->option('create')){
            $this->createUser();
            return;
        }

        if($this->option('list')){
            $this->table($this->attributes, $this->listUsers());
        }
    }

    private function listUsers() : array 
    {
        return $this->user->all($this->attributes)->toArray();
    }

    private function createDefaultUser() : void 
    {
        $user = User::firstOrCreate(['name' => 'stephen.okello'],[
            'email' => 'stephen.okello@gmail.com',
            'password' => bcrypt('secret'),
            'email_verified_at' => now(),
            'remember_token' => Str::random(10)
        ]);
        $this->table($this->attributes, User::all($this->attributes));
        $this->info('User created or updated sussfully');
    }

    private function createUser() : void 
    {
        $username = $this->ask('username');
        $email = $this->ask('Enter Email Address?');
        $password = $this->ask('Enter Password?');

        User::create([
            'name' => $username,
            'email' => $email,
            'password' => bcrypt($password),
            'email_verified_at' => now(),
            'remember_token' => Str::random(10)
        ]);
    }

    
}
