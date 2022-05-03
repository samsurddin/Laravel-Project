<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Tenant\Image;
use App\Models\Tenant\UploadImage;
use Intervention\Image\ImageManagerStatic as ImageManager;

class ImageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // dd(Image::paginate(10)->sortBy('created_at'));
        // $images = Image::paginate(16)->sortBy(['created_at', 'asc']);
        $images = Image::orderBy('created_at', 'DESC')->paginate(16);
        if (request()->ajax()) {
            return view('admin.images.ajaxlist', compact('images'));    
        }
        return view('admin.images.list', compact('images'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.images.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($lang, Request $request)
    {
        // dd($request->file('imageFile'));


        $request->validate([
          'imageFile' => 'required',
          'imageFile.*' => 'mimes:jpeg,jpg,png,gif,csv,txt,pdf|max:2048'
        ]);

        if($request->hasfile('imageFile')) {

            $folder = '/uploads/'.date('Y').'/'.date('m');
            $path = public_path().$folder;
            $thumb_path = $path.'/thumbnails';

            foreach($request->file('imageFile') as $file)
            {
                // $name = $file->getClientOriginalName();
                $original_name = $file->getClientOriginalName();
                $name = uniqid() . '_' . trim($original_name);
                $extension = $file->getClientOriginalExtension();

                if (!file_exists($path)) {
                    mkdir($path, 0777, true);
                }

                if ($extension != 'pdf' && $extension != 'csv' && $extension != 'txt') {
                    if (!file_exists($thumb_path)) {
                        mkdir($thumb_path, 0777, true);
                    }

                    $img = ImageManager::make($file->path());
                    $img->resize(300, 300, function ($const) {
                        $const->aspectRatio();
                    })->save($thumb_path.'/'.$name);
                }

                $file->move($path, $name);

                // $imgData['name'] = $name;
                // // $imgData['url'] = url(public_path($folder.'/'.$name));
                // $imgData['url'] = asset($folder.'/'.$name);

                $db_data = [
                    'url' => asset($folder.'/'.$name),
                    'folder' => $folder,
                    'name' => $name,
                    'extension' => $extension,
                    'alt' => '',
                    'caption' =>  '',
                    'description' =>  '',
                ];

                $image_raw = Image::create($db_data);

                // dd($imgData);

                // $fileModal = UploadImage::create($imgData);
            }
            return back()->with('success', 'File has successfully uploaded!');
        }
        return back()->with('success', 'File has successfully uploaded!');
    }

    public function createForm(){
        return view('admin.images.image-upload');
    }

    public function fileUpload(Request $request)
    {
        // dd($request->file('imageFile'));

        $request->validate([
          'imageFile' => 'required',
          'imageFile.*' => 'mimes:jpeg,jpg,png,gif,csv,txt,pdf|max:2048'
        ]);

        if($request->hasfile('imageFile')) {
            if (is_array($request->file('imageFile'))) {
                $uploaded_file = [];
                foreach($request->file('imageFile') as $file)
                {
                    $uploaded_file[] = $this->file_upload($file);
                }
            } else $uploaded_file = $this->file_upload($request->file('imageFile'));

            if ($request->ajax()) {
                return json_encode($uploaded_file);
            }
            return back()->with('success', 'File has successfully uploaded!');
        }
    }

    public function get_upload_path($extra='')
    {
        return '/uploads/'.$extra.'/'.date('Y').'/'.date('m');
    }

    public function file_upload($file)
    {
        // $folder = '/uploads/ka/'.date('Y').'/'.date('m');
        $folder = $this->get_upload_path();
        $path = public_path().$folder;
        $thumb_path = $path.'/thumbnails';

        $original_name = $file->getClientOriginalName();
        $name = uniqid() . '_' . trim($original_name);
        $extension = $file->getClientOriginalExtension();

        if (!file_exists($path)) {
            mkdir($path, 0777, true);
        }

        if ($extension != 'pdf' && $extension != 'csv' && $extension != 'txt') {
            if (!file_exists($thumb_path)) {
                mkdir($thumb_path, 0777, true);
            }

            $img = ImageManager::make($file->path());
            $img->resize(300, 300, function ($const) {
                $const->aspectRatio();
            })->save($thumb_path.'/'.$name);
        }

        $file->move($path, $name);

        $db_data = [
            'url' => asset($folder.'/'.$name),
            'folder' => $folder,
            'name' => $name,
            'extension' => $extension,
            'alt' => '',
            'caption' =>  '',
            'description' =>  '',
        ];

        $image_raw = Image::create($db_data);

        return $image_raw;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($lang, $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($lang, $id)
    {
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($lang, Request $request, $id)
    {
        // dd($request->all());
        $validated = $request->validate([
            'name' => 'required|max:255',
            'alt' => 'max:255',
            'caption' =>  'max:255',
            'description' =>  'max:1000',
        ]);
        // dd($validated);

        $update = Image::where('id', $id)->update($validated);

        if ($update) {
            return redirect(route('images.index', app()->getLocale()))->with('success', 'Image data is updated successfully!');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($lang, $id)
    {
        $img = Image::where('id', $id)->first()->toArray();
        if (!empty($img)) {
            $file = public_path().$img['folder'].'/'.$img['name'];
            $thumbnail = public_path().$img['folder'].'/thumbnails/'.$img['name'];
            // dd(unlink($file));

            $deletedRows = Image::where('id', $id)->delete();

            if ($deletedRows) {
                if(file_exists($file)){
                    @unlink($file);
                }
                if(file_exists($thumbnail)){
                    @unlink($thumbnail);
                }

                return redirect(route('images.index', app()->getLocale()))->with('success', 'Image is deleted successfully!');
            }
        }
        return redirect(route('images.index', app()->getLocale()))->with('error', 'Somethong went wrong! Image cannot be deleted! Please try again!');
    }
}
