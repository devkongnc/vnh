<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePageRequest;
use App\Page;
use Illuminate\Http\Request;
use LaravelLocalization;

class PageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pages = Page::with('user')->orderBy('id', 'desc')->get();
        return view('admin.static-page.index', compact('pages'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.static-page.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePageRequest $request)
    {
        try {
            $new_page = Page::create($request->all());
            return redirect()->action('Admin\PageController@edit', $new_page->id)->withFlashData(['status' => 'success', 'message' => trans('admin.message.success.create')]);
        } catch (\Exception $ex) {
            return back()->withFlashData(['status' => 'error', 'message' => $ex->getMessage()])->withInput();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $page = Page::findOrFail($id);
        return view('admin.static-page.edit', compact('page'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StorePageRequest $request, $id)
    {
        $page = Page::findOrFail($id);
        try {
            $page->update($request->all());
            return back()->withFlashData(['status' => 'success', 'message' => trans('admin.message.success.update')]);
        } catch (\Exception $ex) {
            return back()->withFlashData(['status' => 'error', 'message' => $ex->getMessage()])->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return back();
        /*Page::destroy($id);
        return redirect()->action('Admin\PageController@index')->withFlashData(['status' => 'success', 'message' => trans('admin.message.success.delete')]);*/
    }

    public function preview(Request $request, $id) {
        $data = (object) [
            'title'     => $request->title[LaravelLocalization::getCurrentLocale()],
            'html'      => $request->html[LaravelLocalization::getCurrentLocale()],
            'css'       => $request->css
        ];
        $page = new Page();
        $page->id = $id;
        $page->permalink = $request->permalink;
        return view('admin.static-page.preview', compact('data', 'page'))->with('isForm', true);
    }

    public function menu(Request $request) {
        if ($request->method() === 'POST') {
            setOption('page_menu', $request->menu);
            return back()->withFlashData(['status' => 'success', 'message' => trans('admin.message.success.update')]);
        }
        $pages = Page::where('status', Page::VISIBILITY_PUBLIC)->get();
        return view('admin.static-page.menu', compact('pages'));
    }
}
