<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Resource;
use DirectoryIterator;
use Folklore\Image\Facades\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class ResourceController extends Controller
{
    public function index(){
        $dir = Input::get('dir', 'images/old/0/');
        $dir = rtrim($dir, "/") . "/";
        $resources = Resource::where('folder', $dir)->get();

        $results = [];
        foreach ($resources as $resource) {
            $results[] = [
                "id" => $resource->id,
                "bigIcon" => true,
                "date" => $resource->created_at->format('d-m-Y H:i'),
                "mtime" => "",
                "name" => $resource->filename,
                "readable" => true,
                "size" => $resource->size,
                "smallIcon" => true,
                "smallThumb" => true,
                "thumb" => true,
                "thumbUrl" => $resource->thumbnail,
                "writable" => true
            ];
        }

        $dirs = $this->fillArrayWithFileNodes( new DirectoryIterator( public_path('upload/images') ) );
        return response()->json([
            "files" => $results,
            "tree" => [
                "name" => "images",
                "hasDirs" => count($dirs) == 0 ? false : true,
                "dirs" => $dirs,
                "writable" => true,
                "readable" => true,
                "current" => false,
                "removable" => true
            ],
            "dirWritable" => true
        ]);
    }

    public function expand(){

        $dir = Input::get('dir');

        $fileData = $this->fillArrayWithFileNodes( new DirectoryIterator( public_path('upload/' . $dir) ) );

        return ["dirs" => $fileData];

    }

    public function upload(Request $request){
        if ($request->has('CKEditor')) {
            $file = $request->file('upload');
            $image_width = (int) getimagesize($file)[0];
            $newfilename = cleanName($file->getClientOriginalName());
            $file->move(public_path('upload/cke'), $newfilename);
            $resource = Resource::create([
                'folder'   => 'cke/',
                'filename' => $newfilename,
            ]);
            $image_url = ($image_width > (int) Resource::$sizes[0]['width']) ? $resource->medium : $resource->url;
            return '<script type="text/javascript">window.parent.CKEDITOR.tools.callFunction("' . $request->CKEditorFuncNum . '", "' . $image_url . '", "");</script>';
        }
        $dir = $request->get('dir') . '/';
        $files = $request->file('upload');
        $ids = $response = [];
        foreach ($files as $file) {
            $newfilename = cleanName($file->getClientOriginalName());
            $file->move(public_path('upload/' . $dir), $newfilename);
            $image = Resource::create([
                'folder'   => $dir,
                'filename' => $newfilename,
            ]);
            $ids[] = $image->id;
        }
        $resources = Resource::whereIn('id', $ids)->get();
        foreach ($resources as $resource) {
            $response[] = [
                'id'        => $resource->id,
                'url'       => $request->has('is_rectangle') ? $resource->estate_thumbnail : $resource->thumbnail,
                'mediumUrl' => $resource->medium
            ];
        }
        return response()->json($response);
    }

    private function fillArrayWithFileNodes( DirectoryIterator $dir )
    {
        $data = array();
        foreach ( $dir as $node )
        {
            if ( $node->isDir() && !$node->isDot() )
            {
                $data[] = [
                    "name" => $node->getFilename(),
                    "hasDirs" => count($this->fillArrayWithFileNodes( new DirectoryIterator( $node->getPathname() ) )) == 0 ? false : true,
                    "writable" => true,
                    "readable" => true,
                    "current" => false,
                    "removable" => true
                ];
            }
        }
        return $data;
    }
}
