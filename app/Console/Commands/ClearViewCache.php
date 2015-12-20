<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ClearViewCache extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */

    protected $name = 'view:clear';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clear all compiled view files.';

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
        $cachedViews = storage_path('/framework/views/');
        $files = glob($cachedViews.'*');
        foreach($files as $file) {
            if(is_file($file)) {
                @unlink($file);
            }
        }

        $this->info('Views cache cleared!');
    }
}