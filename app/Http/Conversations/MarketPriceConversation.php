<?php

namespace App\Http\Conversations;

use App\Services\RenderService;
use BotMan\BotMan\Messages\Conversations\Conversation;
use BotMan\BotMan\Messages\Outgoing\Actions\Button;
use BotMan\BotMan\Messages\Outgoing\Question;
use Illuminate\Support\Facades\Http;

class MarketPriceConversation extends Conversation
{
	public function run()
	{
		$this->ask('ဘယ်ပစ္စည်း ရှာမှာလဲ?', function ($answer) {
			$items = Http::openalbion()->get('/search', [
				'search' => $answer->getText(),
				'limit' => 12
			])->json('data');
			$buttons = [];

			foreach (collect($items)->take(10) as $item) {
				$buttons[] = Button::create($item['name'])
					->value($item['identifier']);
			}

			if (count($buttons) > 1) {
				$question = Question::create($answer->getText() . ' အတွက် တစ်ခုရွေးချယ်ပါ')
					->addButtons($buttons);
				$this->bot->ask($question, function ($answer) {
					$this->bot->reply(
						RenderService::renderItemPrice($answer->getValue())
					);
				});
			} elseif (count($buttons) == 1) {
				$this->bot->reply(
					RenderService::renderItemPrice($items[0]['identifier'])
				);
			} else {
				$this->bot->reply($answer->getText() . ' ရှာမတွေ့ပါ');
				$this->repeat();
			}
		});
	}
}
