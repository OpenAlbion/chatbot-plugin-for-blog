<?php

use App\Http\Conversations\DownloadApplicationConversation;
use App\Http\Conversations\HelpConversation;
use App\Http\Conversations\MarketPriceConversation;
use App\Http\Conversations\MenuConversation;

$botman = resolve('botman');

$botman->hears('hi|hii|hello', function ($bot) {
	$bot->startConversation(new MenuConversation());
});

$botman->hears('search', function ($bot) {
	$bot->startConversation(new MarketPriceConversation());
});

$botman->hears('download', function ($bot) {
	$bot->startConversation(new DownloadApplicationConversation());
});

$botman->hears('help', function ($bot) {
	$bot->startConversation(new HelpConversation());
})->skipsConversation();

$botman->hears('stop', function ($bot) {
	$bot->reply('ဟုတ်ကဲ့');
})->stopsConversation();

$botman->fallback(function ($bot) {
	$bot->reply('Sorry!');
	$bot->startConversation(new HelpConversation());
});
