<?php
namespace Delgont\Cms\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;

use Delgont\Cms\Models\Comment\Comment;
use Delgont\Cms\Models\Post\Post;
use App\User;



class  GenerateCommentsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'comments:generate {--id=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    protected $sections;

    private $attributes = ['id', 'comment', 'created_at'];


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
        $users = User::all();
        $post = Post::findOrFail($this->option('id'));

        foreach ($users as $key => $user) {
            $user->comment(Str::random(10), [
                'id' => $post->id,
                'type' => Post::class
            ]);
        }

        $comments = Comment::where('commentable_type', 'post')->where('commentable_id', $this->option('id'))->get();

        $this->table($this->attributes, $users);
    }

    
}
