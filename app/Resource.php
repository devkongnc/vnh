<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Image;

class Resource extends Model
{
	const FOLDER            = "images/%s/";
	protected $fillable     = ['folder', 'filename', 'url'];

	protected $parent       = 'upload/';

	public static $sizes =  [
        //['width' => 800, 'height' => 600, 'crop' => true],
    	['width' => 675, 'height' => 450, 'crop' => true],
        ['width' => 375, 'height' => 375, 'crop' => true],
        ['width' => 375, 'height' => 250, 'crop' => true]
    ];

    /*protected static function boot() {
    	static::created(function($resource) {
    		$path = str_replace('\\', '/', public_path($resource->path));
    		foreach (static::$sizes as $size) {
    			Image::make($path, $size)->save(Image::url($path, $size['width'], $size['height'], ['crop']));
    		}
    	});
    }*/

	/*public function getFolderAttribute(){
		return str_replace("/", DIRECTORY_SEPARATOR, $this->attributes["folder"]);
	}*/

	public static function dir($dir = 'images') {
		return "upload" . DIRECTORY_SEPARATOR . $dir . DIRECTORY_SEPARATOR . "%s";
	}

	public function getUrlRawAttribute() {
		return $this->attributes['url'];
	}

	public function getUrlAttribute() {
	   return url($this->parent . $this->folder . $this->attributes['filename']);
	}

	public function getPathAttribute() {
		return $this->parent . $this->folder . $this->attributes['filename'];
	}

	public function getThumbnailAttribute() {
		return Image::url($this->path, 375, 375, ['crop' => true]);
	}

	public function getEstateThumbnailAttribute() {
		return Image::url($this->path, 375, 250, ['crop' => true]);
	}

	public function getMediumAttribute() {
		return Image::url($this->path, 675, 450, ['crop' => true]);
	}

    public function getLargeAttribute() {
        return Image::url($this->path, 800, 600, ['crop' => true]);
    }
}
