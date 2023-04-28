<?php

namespace App\Console\Commands;

use App\Models\LoginToken;
use Illuminate\Console\Command;

class CleanLoginTokensTable extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'system:clean-login-tokens-table';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clean Login Tokens table to improve overall performance';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // remove old stale tokens
        LoginToken::where('created_at', '<', now()->subWeeks(1))
            ->delete();

        // remove consumed tokens.
        // For analytics sake, we can maybe only rely on the first
        // option. We can track how often users use the magic link
    }
}
