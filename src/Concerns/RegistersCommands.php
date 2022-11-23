<?php

namespace Delgont\Cms\Concerns;

/**
 * Commands
 */
use Delgont\Cms\Console\Commands\InstallCommand;
use Delgont\Cms\Console\Commands\UserCommand;
use Delgont\Cms\Console\Commands\UserCreateCommand;
use Delgont\Cms\Console\Commands\UserListCommand;
use Delgont\Cms\Console\Commands\CategorySyncCommand;
use Delgont\Cms\Console\Commands\OptionSyncCommand;
use Delgont\Cms\Console\Commands\OptionListCommand;
use Delgont\Cms\Console\Commands\OptionCreateCommand;
use Delgont\Cms\Console\Commands\OptionUpdateCommand;
use Delgont\Cms\Console\Commands\OptionDeleteCommand;
use Delgont\Cms\Console\Commands\PageSyncCommand;
use Delgont\Cms\Console\Commands\PostTypeSyncCommand;
use Delgont\Cms\Console\Commands\MenuSyncCommand;
use Delgont\Cms\Console\Commands\MenuItemSyncCommand;
use Delgont\Cms\Console\Commands\TemplateSyncCommand;
use Delgont\Cms\Console\Commands\SectionSyncCommand;
use Delgont\Cms\Console\Commands\GenerateCommentsCommand;

trait RegistersCommands
{
    private function registerCommands() : void
    {
        $this->commands([
            InstallCommand::class,
            UserCommand::class,
            UserListCommand::class,
            CategorySyncCommand::class,
            OptionSyncCommand::class,
            OptionListCommand::class,
            OptionCreateCommand::class,
            OptionUpdateCommand::class,
            OptionDeleteCommand::class,
            PageSyncCommand::class,
            PostTypeSyncCommand::class,
            MenuSyncCommand::class,
            MenuItemSyncCommand::class,
            TemplateSyncCommand::class,
            SectionSyncCommand::class,
            GenerateCommentsCommand::class
        ]);
    }
}