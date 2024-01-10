<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UndertimesController extends Controller
{
    public function index(){
        
            //         $macAddress = '';
            // exec('ipconfig /all', $output);
            // $output = implode("\n", $output);
        
            // if (preg_match('/Wireless LAN adapter Wi-Fi:\s.*?Physical Address[\. ]+: ([\w-]+)/s', $output, $matches)) {
            //     $macAddress = $matches[1];
            // }
            
            // dd($macAddress);
        return view('my_undertimes');
    }
}
