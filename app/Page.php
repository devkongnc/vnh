<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
	use GeneralModel, MultiLanguage;

    const VISIBILITY_PUBLIC  = 0;
    const VISIBILITY_PRIVATE = 1;
    const VISIBILITY_HIDDEN  = 2;

    protected $fillable      = ['permalink', 'status', 'css'];

    public $multilinguals    = ['title', 'html'];

    public function translation() {
        return $this->hasMany('App\PageTranslate');
    }

    public function getUrlAttribute() {
        return url($this->permalink);
    }
}
