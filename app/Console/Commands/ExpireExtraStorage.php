<?php

namespace App\Console\Commands;

use App\Services\ExtraStorageService;
use Illuminate\Console\Command;

class ExpireExtraStorage extends Command
{
    protected $signature = 'storage:expire-extra';
    protected $description = 'إنهاء اشتراكات المساحة الإضافية المنتهية وإرجاع المساحة للأساسي';

    public function handle(ExtraStorageService $svc): int
    {
        $this->info('Expired: ' . $svc->expireDue());

        return self::SUCCESS;
    }
}
