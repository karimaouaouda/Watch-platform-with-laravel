<?php

namespace App\Http\Controllers;

use App\Models\Code;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class LicenseController extends Controller
{
    public function check(Request $request){
        $licenseKey = $request->license_key;
        $device_unique_id = $request->device_unique_id;

        $license = $this->getLicense($licenseKey, $device_unique_id);
        
        if(!$license){
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid license key'
            ], 404);
        }
        return response()->json([
            'status' => 'success',
            'message' => 'License key is valid'
        ]);
    }

    public function getLicense($licenseKey, $device_unique_id){
        //check if the device id already exists
        $code = Code::where('device_id', $device_unique_id);
        if( $code->first() ){
            return Code::all()->filter(function($code) use ($licenseKey){
                dd(Crypt::encrypt($licenseKey) == Crypt::decrypt($code->code));
                return $licenseKey == Crypt::decrypt($code->code);
            })->first();
        }
        $code = Code::all()->filter(function($code) use ($licenseKey){
            dd(Crypt::encrypt($licenseKey) == Crypt::decrypt($code->code));
            return $licenseKey == Crypt::decrypt($code->code);
        })->first();
        //update the code and set the device id to the current one
        $code->device_id = $device_unique_id;
        $code->save();
        return $code;
    }
}
