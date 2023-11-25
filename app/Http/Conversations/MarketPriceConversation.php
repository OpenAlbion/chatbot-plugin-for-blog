<?php

namespace App\Http\Conversations;

use App\Services\ItemService;
use BotMan\BotMan\Messages\Conversations\Conversation;
use BotMan\BotMan\Messages\Outgoing\Actions\Button;
use BotMan\BotMan\Messages\Outgoing\Question;

class MarketPriceConversation extends Conversation
{
    public function run()
    {
        $this->ask('ဘယ်ပစ္စည်း ရှာမှာလဲ?', function ($answer) {
            $items = (new ItemService)->search($answer->getText());

            $buttons = [];

            foreach (collect($items)->take(10) as $index => $item) {
                $buttons[] = Button::create($item['name'])
                    ->value($index);
            }

            if (count($buttons) > 1) {
                $question = Question::create($answer->getText().' အတွက် တစ်ခုရွေးချယ်ပါ')
                    ->addButtons($buttons);
                $this->bot->ask($question, function ($answer) use ($items) {
                    $result = (new ItemService)->detail('east', $items[$answer->getValue()]['id']);
                    if ($result != '') {
                        $this->bot->reply($items[$answer->getValue()]['name']);
                        $this->bot->typesAndWaits(1);
                        $this->bot->reply($result);
                    } else {
                        $this->bot->reply('စျေးနှုန်း ရှာမတွေ့ပါ');
                    }
                    $question = Question::create('ထပ်ရှာမှာလား?')
                        ->addButtons([
                            Button::create('အင်း')
                                ->value('yes'),
                            Button::create('တော်ပြီ')
                                ->value('no'),
                        ]);
                    $this->bot->ask($question, function ($answer) {
                        if ($answer->getValue() == 'yes') {
                            $this->bot->startConversation(new MarketPriceConversation());
                        } else {
                            $this->bot->reply('ဟုတ်ကဲ့');
                        }
                    });
                });
            } elseif (count($buttons) == 1) {
                $result = (new ItemService)->detail('east', $items[0]['id']);
                if ($result != '') {
                    $this->bot->reply($items[0]['name']);
                    $this->bot->typesAndWaits(1);
                    $this->bot->reply($result);
                } else {
                    $this->bot->reply('စျေးနှုန်း ရှာမတွေ့ပါ');
                }
                $question = Question::create('ထပ်ရှာမှာလား?')
                    ->addButtons([
                        Button::create('အင်း')
                            ->value('yes'),
                        Button::create('တော်ပြီ')
                            ->value('no'),
                    ]);
                $this->bot->ask($question, function ($answer) {
                    if ($answer->getValue() == 'yes') {
                        $this->bot->startConversation(new MarketPriceConversation());
                    } else {
                        $this->bot->reply('ဟုတ်ကဲ့');
                    }
                });
            } else {
                $this->bot->reply($answer->getText().' ရှာမတွေ့ပါ');
                $this->repeat();
            }
        });
    }
}
