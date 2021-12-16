<?php

namespace App\Http\Controllers;

use App\Models\Records;
use App\Models\RecordPhoto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\PushNotification\PushNotification;

class RecordsController extends Controller
{
    use PushNotification;
    public function show()
    {
        $list = Records::get();
        return response()->json($list);
    }

    public function insert(Request $req)
    {
        $val = Validator::make($req->all(), [
            "photo.*" => "required|mimes:jpg,png,jpeg|file|max:5000",
            'title'=>'required',
            "location" => "required|max:255",
            "longitude" => "required",
            "latitude" => "required",
            "pincode" => "required|integer",
        ]);
        if ($val->fails()) {
            return response()->json(['status' => false, "errors" => $val->errors()->all()]);
        }
        $photos = [];
        foreach ($req->photo as $item) 
        {
            $path = $item->store("upload/" . now()->toDateString(),['disk' => 'public']);
            array_push($photos, $path);
        }
        $record = Records::create($req->all());
        foreach ($photos as $photo) {
            RecordPhoto::create([
                "path" => $photo,
                "records_id" => $record->id,
            ]);
        }
        $msg = $req->location." ".$req->pincode;
        $this->sendNotificationTopic($req->title,$msg,$photos);
        // $record->photos;
        return response()->json(['status' => true, 'data' => $record ]);
    }

    public function areaData(Request $req)
    {
        if($req->pincode) 
        {
            return $this->currentCrimes($req);
        }
        else{
            return $this->customCrimes($req);
        }
    }

    public function currentCrimes(Request $req)
    {
        $list = Records::wherePincode($req->pincode)->get()->groupBy("title");
        if($list!=null)
        {
            
            return response()->json(['list' => $list , 'type' => 'current','status'=>true]);
        }
        else{return response()->json(['status' => false, 'message' => 'No Record Found']);}
    }

    public function customCrimes(Request $req)
    {
        $val = Validator::make($req->all(), [
            "location" => "required|max:255",
        ]);
        if ($val->fails()) {
            return response()->json(['status' => false, "errors" => $val->errors()->all()]);
        }
        $list = Records::whereLocation($req->location)->get()->groupBy("title");
        if($list!=null)
        {
            return response()->json(['list' => $list , 'type' => 'custom']);
        }
        else{return response()->json(['status' => false, 'message' => 'No Record Found']);}
    }

    public function areaList()
    {
        $list = Records::get()->unique(['location'])->pluck(['location']);
        return response()->json(['list' => $list]);
    }
}
