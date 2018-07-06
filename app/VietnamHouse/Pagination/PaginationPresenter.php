<?php
namespace App\VietnamHouse\Pagination;

use Illuminate\Pagination\SimpleBootstrapThreePresenter;
use Illuminate\Support\HtmlString;

/**
 * Created by PhpStorm.
 * User: MyPC
 * Date: 5/15/2016
 * Time: 11:18 AM
 */
class PaginationPresenter extends \Illuminate\Pagination\BootstrapThreePresenter
{
    public function render()
    {
        if ($this->hasPages()) {
            return new HtmlString(
                (($this->paginator->hasMorePages()) ? '<div class="row">'.
                    '<div class="col-md-12 center">'.
                        '<a href="' . $this->paginator->nextPageUrl() . '" class="more-blk-btn">' . trans('front.next page') . '</a>' : '') .
                        '<div class="clearfix"></div>'.
                        '<ul class="pagination-blk">' .
                        $this->getPreviousButton('<span class="icon-arrow-prev">&lt;</span>') .
                        $this->getLinks() .
                        $this->getNextButton('<span class="icon-arrow-next">&gt;</span>') .
                        '</ul>'.
                        '</div>'.
                '</div>'
            );
        }
        return '';
    }

    public function map_render()
    {
        if ($this->hasPages()) {
            return new HtmlString(
                '<div class="row map-list-pagi">'.
                    '<div class="col-md-12 right nopadding-r">'.
                        '<ul class="col-md-7 col-xs-5 pagination-blk">' .
                            $this->getPreviousButton('<span class="icon-arrow-prev">&lt;</span>') .
                            $this->getLinks() .
                            $this->getNextButton('<span class="icon-arrow-next">&gt;</span>') .
                        '</ul>'.
                (($this->paginator->hasMorePages()) ?
                    '<a href="' . $this->paginator->nextPageUrl() . '" class="more-blk-btn">' . trans('front.next page') . '</a>' : '') .
                    '</div>'.
                '</div>'
            );
        }
        return '';
    }

}
