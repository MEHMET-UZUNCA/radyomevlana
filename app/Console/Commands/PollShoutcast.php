<?php

namespace App\Console\Commands;

use App\Services\ShoutcastService;
use Illuminate\Console\Command;

class PollShoutcast extends Command
{
    protected $signature   = 'shoutcast:poll';
    protected $description = 'Shoutcast sunucusunu sorgular ve yeni parçayı kaydeder';

    public function handle(ShoutcastService $service): void
    {
        $service->pollAndSave();
    }
}
