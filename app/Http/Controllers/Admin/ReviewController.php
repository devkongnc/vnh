<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\ReviewModelRequest;
use App\Review;
use Excel;
use LaravelLocalization;

class ReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->has('category')) {
            $category = (int) $request->category;
            if ($category < 0 or $category > 5) $category = 0;
            $reviews = Review::with('resource')->where('categories', 'LIKE', "%{$category}%")->orderBy('id', 'desc')->get();
        } else $reviews = Review::with('user')->orderBy('id', 'desc')->get();
        return view('admin.review.index', compact('reviews'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $review = new Review();
        $review->permalink = (int) Review::max('id') + 1;
        return view('admin.review.create', compact('review'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ReviewModelRequest $request)
    {
        $title = $request->title;
        if (!empty($title['en'])) $request->merge(['permalink' => str_slug($title['en'], '-')]);
        elseif (!empty($title['vi'])) $request->merge(['permalink' => str_slug($title['vi'], '-')]);
        # Tạo nháp review
        $new_review = Review::create($request->all());
        return redirect()->action('Admin\ReviewController@edit', $new_review->id)->withFlashData(['status' => 'success', 'message' => trans('admin.message.success.create')]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Review $review
     * @return \Illuminate\Http\Response
     * @internal param int $id
     */
    public function edit(Review $review)
    {
        return view('admin.review.edit', compact('review'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param Review $draft
     * @return \Illuminate\Http\Response
     * @throws \Exception
     * @internal param Review $review
     */
    public function update(ReviewModelRequest $request, $review)
    {
        /*if ($request->get('action') == "publish") {
            if ($request->get('is_draft') == false) {
                if ($review->is_draft) {
                    # Nếu đây là bản nháp, tiến hành cập nhật
                    $parent_review = $review->getPublished();
                    $parent_review->update($request->all());
                    return redirect()->action('Admin\ReviewController@edit', $parent_review->id);
                } else {
                    # Nếu đây là bản chính thức
                    if ($review->exists) {
                        $review->update($request->all());
                    } else {
                        $review = Review::create($request->all());
                    }
                    return redirect()->action('Admin\ReviewController@edit', $review->id);
                }
            }
        }
        # Còn lại xem như tương tác với nháp
        $draft = $review->getDraft();
        $draft->update($request->all());*/
        //dd($request->all());
        $review->update($request->all());
        return back()->withFlashData(['status' => 'success', 'message' => trans('admin.message.success.update')]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Review $review)
    {
        $review->delete();
        return redirect()->action('Admin\ReviewController@index')->withFlashData(['status' => 'success', 'message' => trans('admin.message.success.delete')]);
    }

    /**
     * @param Review $review
     * @param $action
     */
    private function draftProcess(Review $review, $action){
        # Nếu không phải bài nháp
        if ($review->is_draft == false) {
            $review = $review->getDraft();
        }
    }

    public function preview(ReviewModelRequest $request) {
        $data = (object) [
            'title'       => $request->title[LaravelLocalization::getCurrentLocale()],
            'description' => $request->description[LaravelLocalization::getCurrentLocale()],
        ];
        $review = new Review([
            'permalink'  => $request->permalink,
            'title'      => $data->title,
            'categories' => $request->categories
        ]);
        return view('admin.review.preview', compact('data', 'review'));
    }

    public function export() {
        $reviews = Review::all();
        $rows = [];
        foreach ($reviews as $index => $review) {
            $rows[] = [
                $index + 1,
                trans('admin.common.title')          => $review->title,
                trans('admin.review.category')       => implode(',', $review->categoriesName),
                trans('admin.common.status')         => strip_tags($review->visibility),
                trans('admin.common.created at')     => $review->created_at,
                trans('admin.apartment.description') => $review->description
            ];
        }
        Excel::create(trans('admin.entity.review') . '_' . date('d-m-Y-H-i-s'), function($excel) use($rows) {
            $excel->sheet('Sheet1', function($sheet) use($rows) {
                $sheet->fromArray($rows);
            });
        })->download('xlsx');
        return;
    }
}
