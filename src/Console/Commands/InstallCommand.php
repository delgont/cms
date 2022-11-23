<?php

namespace Delgont\Cms\Console\Commands;

use Illuminate\Console\Command;

class InstallCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'delgont:install
                            {--user : Overwrite Default User Model}
                            {--auth : Overwrite authentication middlewares}
                            {--fresh : Fresh installation or setup}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    private $fresh = false;

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
        $this->info('Doing the install');

        if($this->option('auth')){
            $this->overWriteAuthMiddlewares();
            return;
        }

        if($this->option('user')){
            $this->overWriteUserModel();
            return;
        }

        $this->overWriteAuthMiddlewares();
        $this->overWriteUserModel();
        $this->publishPublishables();
        $this->generateNotificationsTable();
    }

    private function overWriteAuthMiddlewares() : void
    {
        $fresh = ($this->option('fresh')) ? true : false;

        $this->call('vendor:publish', ['--tag' => 'delgont-overwrite-if-authenticated-redirect', '--force' => $fresh]);
        $this->call('vendor:publish', ['--tag' => 'delgont-overwrite-not-authenticated-redirect', '--force' => $fresh]);
    }

    private function overWriteUserModel() : void
    {
        $fresh = ($this->option('fresh')) ? true : false;

        $this->call('vendor:publish', ['--tag' => 'delgont-overwrite-user-model', '--force' => $fresh]);
    }

    private function publishPublishables() : void 
    {
        $fresh = ($this->option('fresh')) ? true : false;

        $this->call('vendor:publish', ['--tag' => 'delgont-config', '--force' => $fresh]);
        $this->call('vendor:publish', ['--tag' => 'delgont-config-web', '--force' => $fresh]);
        $this->call('vendor:publish', ['--tag' => 'delgont-config-web', '--force' => $fresh]);
        $this->call('vendor:publish', ['--tag' => 'delgont-config-data', '--force' => $fresh]);
    }

    private function generateNotificationsTable() : void 
    {
        $fresh = ($this->option('fresh')) ? true : false;
        if (!$fresh) {
            $this->call('notifications:table');
        }
    }
}
