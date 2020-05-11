<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\api\File;
use Image;


class FileController extends Controller
{
    function pattern(Request $request){
        // echo $request->number;
        // die;
        if(isset($request->number)){
            return view("welcome", ["number" => $request->number]);
        }
    }

    function uploads(Request $request){
        $vals = \Validator::make($request->all(),[
            'image' => 'required|mimes:png,jpg|max:10000',
        ],[
            'image.required' => 'Image required',
            'image.mimes' => 'Only JPG and PNG files allowed',
            'image.max' => 'Max 10MB file allowed'
        ]);
        try {
            if($vals->fails()){
                return response()->json([
                    'status' => false,
                    'msg' => $vals->errors()->first('image')
                ], 200);
            }
            set_time_limit(0);
            $image = $request->file('image');
            $fileName = time()."_".$image->getClientOriginalExtension();
            $dirPath = public_path('/images');

            $img = Image::make($image->getRealPath());

            $img->greyscale();
            $img->resize(1000, 1000)->save($dirPath.'/1000/'. '1000_'.$fileName);
            $img->resize(750, 750)->save($dirPath.'/750/'. '750_'.$fileName);
            $img->resize(530, 530)->save($dirPath.'/530/'. '530_'.$fileName);
            $img->resize(300, 300)->save($dirPath.'/300/'. '300_'.$fileName);

            $data = json_encode([
                '1000'=> '/images/1000/1000_' . $fileName,
                '750'=> '/images/750/750_' . $fileName,
                '530'=> '/images/530/530_' . $fileName,
                '300'=> '/images/300/300_' . $fileName
                ]);
            $filesInsert = new File;
            $filesInsert->images= $data;
            $filesInsert->save();

            $status = false;
            $msg = "Can not insert image, Something is wrong.";
            if ($filesInsert) {
                $status = true;
                $msg = "Image added.";
            }
            return response()->json([
                'status' => $status,
                'msg' => $msg
            ], 200);

        } catch (\Exception $e) {
            throw $e;
            return response()->json([
                'status' => false,
                'msg' => 'Something is Wrong, Please try again.'
            ], 200);
        }
    }

    function delete(){
        $getData=File::where('created_at', '<', \Carbon\Carbon::now()->subMinutes(30)->toDateTimeString());
        foreach($getData->get() as $data){
            $filePathsArr = json_decode($data['images']);
            foreach ($filePathsArr as $key => $value) {
                if (file_exists(public_path($value))) {
                    unlink(public_path($value));
                }
            }
        }
        $deleteData = $getData->delete();
        $status = false;
        $msg = "Can not detele image, Something is wrong.";
        if ($deleteData) {
            $status = true;
            $msg = "Image deleted.";
        }
        return response()->json([
            'status' => $status,
            'msg' => $msg,
        ], 200);
    }
}
