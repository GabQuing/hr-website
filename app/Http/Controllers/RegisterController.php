<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Storage;
use DB;
use App\Models\registerInfo;
class RegisterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $data = [];
        $data['id'] = $id;
        return view('registerFace', $data);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $user_request = $request->all();
        $ID = registerInfo::insertGetId(['mobile_number'=>$user_request['mobile'],'first_name'=>$user_request['fname'],'middle_name'=>$user_request['mname'],'last_name'=>$user_request['lname'],'email_address'=>$user_request['email'],'employee_name'=>$user_request['lname'].'_'.$user_request['fname']]);
        $Data = [];
        $Data["ID"] = $ID;
        return view ('registerFace', $Data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $id = $request->emp_id;
        $nameOfEmployee = DB::table('users')->select('*')->where('id', $request->id)->first();


        $img = $request->image;
        $img1 = $request->image1;
        // $folderPath = "uploads/".$nameOfEmployee->employee_id.$nameOfEmployee->first_name.'/'.$nameOfEmployee->employee_id.$nameOfEmployee->first_name;
        
        $folderPath = "labels/".$nameOfEmployee->last_name.'_'. $nameOfEmployee->first_name.'/';
        
        

        for ($i=1; $i<=2; $i++) {
            if ($i == 1){
                $pic = $img;
            }else{
                $pic = $img1;
            }
            $image_parts = explode(";base64,", $pic);
            $image_type_aux = explode("image/", $image_parts[0]);
            $image_type = $image_type_aux[1];
    
            
            $image_base64 = base64_decode($image_parts[1]);
            // $fileName = $nameOfEmployee->first_name . $i . '.png';
            $fileName =  $i . '.png';
            
            // Upload the image to the specified Google Drive folder
            Storage::disk('google')->write($folderPath . $fileName, $image_base64);
        }
        DB::table('users')->where('id', $request->id)->update(['biometric_register' => 1 , 'approval_status' => 'PENDING']);

        return redirect('successRegister');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
