<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SupportController extends Controller
{
    function sendMessage($messaggio)
    {
        $chatID = '-594024168';
        $token = '1937471338:AAGTX_yaSDnkvt9zu_BrMCIxsWx-IkKGMBk';
        $url = "https://api.telegram.org/bot" . $token . "/sendMessage?chat_id=" . $chatID;
        $url = $url . "&text=" . urlencode($messaggio);
        $ch = curl_init();
        $optArray = array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true
        );
        curl_setopt_array($ch, $optArray);
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }

    public function sendScreen(Request $request) {
        $user = Auth::user();

        $img = $request->imgBase64;

        $image = str_replace('data:image/png;base64,', '', $img);
        $image = str_replace(' ', '+', $image);
        $filename = $user->id . '-' . time() . '.png';
        $path = public_path().'/support/screens/' . $filename;


        $success = file_put_contents($path, base64_decode($image));

        $this->sendMessage(url('/public/support/screens/' . $filename));

        return;
    }
}
