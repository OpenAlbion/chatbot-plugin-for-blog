<?php

namespace App\Http\Conversations;

use BotMan\BotMan\Messages\Conversations\Conversation;
use BotMan\BotMan\Messages\Outgoing\Actions\Button;
use BotMan\BotMan\Messages\Outgoing\Question;

class MenuConversation extends Conversation
{
    public function run()
    {
        $question = Question::create('အကြောင်းအရာ ရွေးချယ်ပေးပါ')
            ->addButtons([
                Button::create('Market Price')->value('market'),
                Button::create('Download Application')->value('download'),
            ]);

        $this->bot->ask($question, function ($answer) {
            if ($answer->isInteractiveMessageReply()) {
                if ($answer->getValue() == 'download') {
                    $this->bot->startConversation(new DownloadApplicationConversation());
                } elseif ($answer->getValue() == 'market') {
                    $this->bot->startConversation(new MarketPriceConversation());
                }
            } else {
                $this->repeat();
            }
        });
    }
}
