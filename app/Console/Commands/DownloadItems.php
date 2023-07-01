<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class DownloadItems extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'download:items';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cache albion online items';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $items = file_get_contents('https://raw.githubusercontent.com/ao-data/ao-bin-dumps/master/formatted/items.json');
        $items = json_decode($items, true);
        $formattedItems = [];
        foreach ($items as $item) {
            if (!empty($item['LocalizedNames']['EN-US'])) {
                $formattedItems[] = [
                    'id' => Str::after($item['LocalizationNameVariable'], '@ITEMS_'),
                    'name' => Str::after($item['LocalizedNames']['EN-US'], '@'),
                ];
            }
        }

        Storage::put('items.json', json_encode(collect($formattedItems)->unique()->toArray()));
    }
}
