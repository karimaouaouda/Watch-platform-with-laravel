<?php

namespace App\Http\Controllers;

use App\Models\Code;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class LicenseController extends Controller
{
    public function check(Request $request){
        // get the inputs
        $licenseKey = $request->license_key;
        $device_unique_id = $request->device_unique_id;

        // check if the license key is valid
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
        $code = Code::all()->filter(function($code) use ($licenseKey){
            return $licenseKey == Crypt::decrypt($code->code);
        })->first();
        if(!$code->first()){
            return null;
        }

        if($code->device_id == null){
            $code->device_id = $device_unique_id;
            $code->save();
            return $code;
        }

        //check if the device id already exists
        if($code->device_id != $device_unique_id){
            return null;
        }
        return $code;
    }
}
