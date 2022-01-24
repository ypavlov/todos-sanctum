<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class ResetToken extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'todo:reset-token {user_id}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Resets user api_token by user_id';

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
     * @return int
     */
    public function handle()
    {
        $user = User::find($this->argument('user_id'));

        if ($user) {
            $this->info('new token: '. $user->createToken('api_token')->plainTextToken);
        }
    }
}
