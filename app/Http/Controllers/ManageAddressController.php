<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\store_address;

use DB;
class ManageAddressController extends Controller
{
    // protected $fillable = [
    //     'MacAddress',
    //     'StoreLocation',
    //     'Latitude',
    //     'Longitude',
    //     'created_by',
    //     'created_at',
    // ];
    public function index()
    {
        $StoreData=[];
        $StoreData['storeTable'] = DB::table('store_addresses')
            ->get();



        return view('storeAddress', $StoreData);
    }



    public function addStoreAddress(Request $request)
    {
        $Name = $request->input('name');

        $NewStore = $request->all();
        $StoreInfo = store_address::insertGetId([
            'mac_address'=>$NewStore['MacAddress'],
            'store_location'=>$NewStore['StoreLocation'],
            'latitude'=>$NewStore['Latitude'],
            'longitude'=>$NewStore['Longitude'],
            'created_by'=>auth()->user()->name,
            'created_at'=>date('Y-m-d H:i:s')
        ]);


        return redirect()->back();


    }

    public function update(Request $request)
    {
        $id = $request->input('id');
        $address = store_address::find($id);
        $address->update([
            'mac_address' => $request->input('MacAddress'),
            'store_location' => $request->input('StoreLocation'),
            'latitude' => $request->input('Latitude'),
            'longitude' => $request->input('Longitude'),
            
        ]);
        $address->save();

        return redirect()->back();
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {

        $data = $request->all();
        
        $show_address = store_address::find($data['id']);

        return response()->json(['success'=>$show_address]);
    }

    /**
     * Show the form for editing the specified resource.
     */

    /**
     * Update the specified resource in storage.
     */
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
