<?php

namespace App\Http\Controllers;

use App\Models\Tariff;
use Composer\Util\Tar;
use Illuminate\Http\Request;

class SettingsController extends Controller
{


    public function index(Request $request) {


        $result = '';

        $tariff = Tariff::all();

        if (session('alert') == true) {
            $alert = $this->sendResponseMessage('Налаштування збережено');
            $request->session()->forget('alert');
        } else {
            $alert = '';
        }

        return view('settings/settings', [
            'user'   => $this->user,
            'alert'  => $alert,
            'tariff' => $tariff
        ]);

    }
    public function abonents(Request $request) {

        $result = '';

        $tariff = Tariff::all();

        if (session('alert') == true) {
            $alert = $this->sendResponseMessage('Налаштування збережено');
            $request->session()->forget('alert');
        } else {
            $alert = '';
        }

        return view('settings/abonents', [
            'user'   => $this->user,
            'alert'  => $alert,
            'tariff' => $tariff
        ]);

    }
}
