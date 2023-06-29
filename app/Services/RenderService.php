<?php

namespace App\Services;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class RenderService
{
    public static function renderItemPrice(string $itemId): string
    {
        $response = Http::openalbion()->get("/aod/east/item/{$itemId}/price", [
            'locations' => 'Caerleon,Bridgewatch,Lymhurst,Thetford,Martlock,Fort Sterling',
            'qualities' => 1,
        ])->json();

        $render = '';
        $formatNumber = function (string $str): string {
            return Str::replace(
                ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'],
                ['၀', '၁', '၂', '၃', '၄', '၅', '၆', '၇', '၈', '၉'],
                $str
            );
        };
        if ($response) {
            foreach ($response as $item) {
                if ($item['sell_price_min'] > 0) {
                    $render .= '<strong>' . $item['city'] . '</strong>';

                    $updatedAt = Carbon::parse($item['sell_price_min_date'])
                        ->setTimezone('Asia/Yangon')
                        ->diffInMinutes(now());
                    $updatedAtStr = "လွန်ခဲ့သော {$updatedAt} မိနစ်";
                    if ($updatedAt > 1440) {
                        $day = (int) ($updatedAt / 1440);
                        $updatedAtStr = "လွန်ခဲ့သော {$day} ရက်";
                    } elseif ($updatedAt > 60) {
                        $hour = (int) ($updatedAt / 60);
                        $updatedAtStr = "လွန်ခဲ့သော {$hour} နာရီ";
                    }
                    $render .= '<br /> ရောင်းစျေး - '
                        . $formatNumber($item['sell_price_min'])
                        . ' (' . $formatNumber($updatedAtStr) . ')';

                    $render .= '<br /><br />';
                }
            }
        }

        return $render;
    }
}
