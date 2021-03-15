<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\MakeComponents;
use App\Traits\RequestTrait;

use App\Models\Telegram_data_source;

class TelegramController extends Controller
{
    use MakeComponents;
    use RequestTrait;

    public function refreshWebhook(Request $request)
    {
        // $url = "https://cbc857405373.ngrok.io/api/bot/tg";
        $url = route('telegram_url_webhook');

        $apiRequest = $this->apiRequest('setWebhook', [
            'url' => $url,
        ]) ? 'success' : 'failed';

        if ($apiRequest == 'success') {
            //Flash Message
            flash_alert(
                __('alert.icon_success'), //Icon
                'Webhook Set Success', //Alert Message 
                'Telegram Webhook Was Set' //Sub Alert Message
            );
        } else if ($apiRequest == 'failed') {
            //Flash Message
            flash_alert(
                __('alert.icon_error'), //Icon
                'Webhook Set Failed', //Alert Message 
                'Telegram Webhook Failed To Set' //Sub Alert Message
            );
        }

        return redirect()->back();
    }

    //Setting
    public function index()
    {
        $update = file_get_contents('php://input');
        $result = json_decode($update, true);

        $result_message = NULL;

        if (array_key_exists("my_chat_member", $result)) {
            $result_message = $result["my_chat_member"];
        } else if (array_key_exists("message", $result)) {
            $result_message = $result["message"];
        } else if (array_key_exists("edited_message", $result)) {
            $result_message = $result["edited_message"];
        }

        $chatId = ($result_message["chat"]["id"]) ? $result_message["chat"]["id"] : NULL;

        $this->Invite($result_message, $chatId);

        if (array_key_exists("text", $result_message)) {
            $this->Mute($result_message, $chatId);
        }

        // if ($action == '/start') {
        //     $text = 'Please choose city that can see time';
        //     $option = [
        //         ['Tehran', 'Jakarta'],
        //         ['London', 'New York']
        //     ];
        //     $this->apiRequest('sendMessage', [
        //         'chat_id' => $userId,
        //         'text' => $text,
        //         'reply_markup' => $this->keyboardBtn($option),
        //     ]);
        // } else {
        //     $text = $action;
        //     $option = [
        //         ['LS', 'SS']
        //     ];
        //     $this->apiRequest('sendMessage', [
        //         'chat_id' => $userId,
        //         'text' => $text,
        //         'reply_markup' => $this->keyboardBtn($option),
        //     ]);
        // }
    }

    private function Invite($result_message, $chatId)
    {
        $chat_id = Telegram_data_source::where('chat_id', $chatId)->count();

        // INVITE MANAJEMENT
        if (array_key_exists("group_chat_created", $result_message) || array_key_exists("new_chat_member", $result_message) || array_key_exists("new_chat_participant", $result_message)) {
            if ($chat_id == 0) {
                Telegram_data_source::create([
                    'chat_id' => $chatId,
                    'chat_type' => $result_message["chat"]["type"],
                    'chat_mute' => false,
                ]);

                $this->apiRequest('sendMessage', [
                    'chat_id' => $chatId,
                    'text' => "Thank You For Invited Me\n /mute for mute bot send message\n /unmute for unmute bot send message",
                ]);
            } else {
                Telegram_data_source::where('chat_id', $chatId)->update([
                    'chat_type' => $result_message["chat"]["type"],
                    'chat_mute' => false,
                ]);
            }
        } else if (array_key_exists("left_chat_member", $result_message) || array_key_exists("left_chat_participant", $result_message)) {
            Telegram_data_source::where('chat_id', $chatId)
                ->delete();
        }
    }

    private function Mute($result_message, $chatId)
    {
        $command = ($result_message['text']) ? $result_message['text'] : NULL;

        // MUTE MANAJEMEN
        if ($command == "/mute") {
            Telegram_data_source::where('chat_id', $chatId)
                ->update([
                    'chat_mute' => true,
                ]);

            $this->apiRequest('sendMessage', [
                'chat_id' => $chatId,
                'text' => "Bot Message Muted",
            ]);
        } else if ($command == "/unmute") {
            Telegram_data_source::where('chat_id', $chatId)
                ->update([
                    'chat_mute' => false,
                ]);

            $this->apiRequest('sendMessage', [
                'chat_id' => $chatId,
                'text' => "Bot Message Unmuted",
            ]);
        }
    }
}
