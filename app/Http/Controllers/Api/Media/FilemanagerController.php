<?php

namespace App\Http\Controllers\Api\Media;

use App\Resources\Resource;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class FilemanagerController extends Controller
{
    public function index (Request $request) {
        $path = $this->getSpaceDirectory($request->path);

        //return $path;
        $data = $this->allFiles($path);

        return (new Resource($data));
    }

    public function createDirectory (Request $request) {
        $path = $this->getSpaceDirectory($request->path);
        $STATUS_CODE = Storage::disk('filemanager')->makeDirectory($path . $request->name) ? 200 : 204;
        
        $data = $this->allFiles($path);

        return (new Resource($data));
    }

    public function removeDirectory (Request $request) {
        $path = $this->getSpaceDirectory($request->path);

        if ( $request->type == 'folder' )
            $STATUS_CODE = Storage::disk('filemanager')->deleteDirectory($path.$request->name) ? 200 : 204;
        else
            $STATUS_CODE = Storage::disk('filemanager')->delete($path.$request->name) ? 200 : 204;
        
        $data = $this->allFiles($request->path);

        return (new Resource($data));
    }

    public function storeFile (Request $request) {
        $path = $this->getSpaceDirectory($request->path);
        $file = $request->file('file');
        if ( \Storage::disk('filemanager')->exists($path.$file->getClientOriginalName()) ) {
            $new_name = Str::afterLast($file->getClientOriginalName(), '.'.time().$file->getClientOriginalExtension());
            \Storage::disk('filemanager')->putFileAs(
                $path, 
                $file,
                $new_name
            );
        } else {
            \Storage::disk('filemanager')->putFileAs(
                $path, 
                $file,
                $file->getClientOriginalName()
            );
        }

        return response()->json([
            'status'    =>  204,
            'message'   =>  'Exito al subir los archivos'  
        ]);
    }

    private function allFiles ($path) {
        $folders_names = Storage::disk('filemanager')->directories($path);
        $folders = collect([]);
        foreach ($folders_names as $folder) {
            $folders->push(
                str::after($folder, $path)
            );
        }

        $filenames = Storage::disk('filemanager')->files($path);
        $files = collect([]);
        foreach ($filenames as $file) {
            $name = Str::after($file, $path);
            $files->push(
                collect([
                    'name'      =>  $name,
                    'storage'   =>  $path == '/' || $path == '' ? 'filemanager/'.$name : 'filemanager/'.$path.$name,
                    'path'      =>  $path == '/' || $path == '' ? asset('filemanager/' . $name) : asset('filemanager/'.$path.$name),
                    'extension' =>  Str::afterLast($file, '.')
                ])
            );
        }

        return $data = collect([
            'folders'   =>  $folders,
            'files'     =>  $files
        ]);
    }

    private function getSpaceDirectory ($path) {
        $root = '';
        if ( config('seguce92.data.filemanager.byUser') ) {
            $root = hashid_encode( \Auth::id() );
            $root = $path == '' || $path == '/' ? $root.'/' : $root.'/'.$path.'/';
        } else {
            $root = $path == '' ? '/' : $path.'/' ;
        }

        return $root;
    }
}
