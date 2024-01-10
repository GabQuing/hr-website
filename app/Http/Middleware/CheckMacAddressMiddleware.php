<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Symfony\Component\HttpFoundation\Response;
use App\Models\store_address;
use DB;
use Illuminate\Support\Facades\Log;





class CheckMacAddressMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
    {

        // $clientMacAddress = $this->getClientMacAddress();
        // $allowedMacAddresses = store_address::
        //     pluck('mac_address')
        //     ->toArray();        
        // $currentUrl = url()->current();
        // $LocationArray = store_address::
        //     where('mac_address',$clientMacAddress)
        //     // ->pluck('store_location')
        //     ->get()
        //     ->first();
        // // dd($LocationArray);
            
        // if(!in_array($clientMacAddress,$allowedMacAddresses) && $currentUrl == url('/Attendance')){
        //     // return response('Access Denied', 403);
        //     return redirect(url('accessDenied'));
        // }

        // View::share(['macAddress' => $clientMacAddress, 'approvedMacAddress' => $allowedMacAddresses, 'dataLocation'=> $LocationArray]);
        return $next($request);
    }

    // public function getClientMacAddress()
    // {
    //     $ipAddress = $_SERVER['REMOTE_ADDR'];
    //     $command = 'arp -a ' . $ipAddress;
    //     $output = [];
    //     $result = exec($command, $output);
    
    //     // Extract MAC address using regular expression
    //     $pattern = '/[0-9a-fA-F:]{17}/'; // Regular expression to match MAC address format
    //     $match = preg_match($pattern, $result, $macAddress);
    //     $macAddress = strtoupper(str_replace(":","-",$macAddress[0]));
    
    //     return $macAddress;
    // }
}


