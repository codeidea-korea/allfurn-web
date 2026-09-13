<?php

namespace App\Console\Commands;

use App\Service\HomeService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class WarmHomeCache extends Command
{
    protected $signature = 'home:warm-cache
                            {--device=all : Cache target: all, pc, or mobile}';

    protected $description = 'Refresh the shared PC and mobile home caches without expiring stale data';

    private $homeService;

    public function __construct(HomeService $homeService)
    {
        parent::__construct();
        $this->homeService = $homeService;
    }

    public function handle()
    {
        $deviceOption = strtolower((string) $this->option('device'));
        if (! in_array($deviceOption, ['all', 'pc', 'mobile'], true)) {
            $this->error('--device must be all, pc, or mobile.');
            return 1;
        }

        $devices = $deviceOption === 'all' ? ['pc', 'mobile'] : [$deviceOption];
        $startedAt = microtime(true);
        $results = [];

        foreach ($devices as $device) {
            $deviceStartedAt = microtime(true);
            $results[$device] = $this->homeService->warmHomeCaches($device);
            $elapsedMs = round((microtime(true) - $deviceStartedAt) * 1000, 2);

            $this->info(sprintf(
                '%s cache refreshed in %sms (product_ads=%s, new_products=%s)',
                $device,
                $elapsedMs,
                $results[$device]['product_ads'] ? 'updated' : 'locked',
                $results[$device]['new_products'] ? 'updated' : 'locked'
            ));
        }

        Log::info('[HOME_CACHE] warm completed', [
            'devices' => $devices,
            'results' => $results,
            'elapsed_ms' => round((microtime(true) - $startedAt) * 1000, 2),
        ]);

        return 0;
    }
}
