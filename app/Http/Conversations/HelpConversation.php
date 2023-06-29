<?php

namespace App\Http\Conversations;

use BotMan\BotMan\Messages\Conversations\Conversation;

class HelpConversation extends Conversation
{
	public function run()
	{
		$this->bot->reply(
			'Market Price ရှာဖွေရန် <strong>search</strong> လို့ ရိုက်ပါ</br></br>'
				. 'Application Download လုပ်ရန် <strong>download</strong> လို့ ရိုက်ပါ</br></br>'
				. 'စကားဆက်မပြောရန် <strong>stop</strong> လို့ ရိုက်ပါ'
		);
	}
}
