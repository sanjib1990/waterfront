<?php

namespace App\Console\Commands;

use Tymon\JWTAuth\Commands\JWTGenerateCommand as JWTCommand;

/**
 * Class JWTGenerateCommand
 *
 * @package App\Console\Commands
 */
class JWTGenerateCommand extends JWTCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'jwt:gen {--show}';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->fire();
    }
}
