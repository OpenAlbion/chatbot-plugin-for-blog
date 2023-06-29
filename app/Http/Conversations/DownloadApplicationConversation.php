<?php

namespace App\Http\Conversations;

use BotMan\BotMan\Messages\Conversations\Conversation;

class DownloadApplicationConversation extends Conversation
{
    public function run()
    {
        $this->bot->reply(
            'OpenAlbion Weaponry application ကို <a href="https://play.google.com/store/apps/details?id=com.openalbion.weaponry">Google Play</a> ကနေ download ဆွဲလို့ရပါတယ်'
        );
    }
}
