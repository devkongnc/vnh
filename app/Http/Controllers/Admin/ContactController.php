<?php

namespace App\Http\Controllers\Admin;

use App\Contact;
use App\Estate;
use Excel;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $contacts = Contact::orderBy('id', 'desc')->orderBy('id', 'desc')->get();
        return view('admin.contact.index', compact('contacts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    	//
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $contact = Contact::findOrFail($id);
        $contact->update(['unread' => false]);
        $estates = Estate::whereIn('id', $contact->estates)->get();
        return view('admin.contact.show', compact('contact', 'estates'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Contact::destroy($id);
        return redirect()->action('Admin\ContactController@index')->withFlashData(['status' => 'success', 'message' => "Delete contact successfull"]);
    }

    public function export() {
        $contacts = Contact::all();
        $rows = [];
        foreach ($contacts as $index => $contact) {
            $rows[] = [
                $index + 1,
                trans('admin.user.fullname')     => $contact->name,
                trans('admin.user.phone')        => $contact->phone,
                trans('admin.user.email')        => $contact->email,
                trans('admin.common.status')     => strip_tags($contact->status),
                trans('admin.common.created at') => $contact->created_at,
                trans('admin.contact.message')   => $contact->message
            ];
        }
        Excel::create(trans('admin.entity.contact') . '_' . date('d-m-Y-H-i-s'), function($excel) use($rows) {
            $excel->sheet('Sheet1', function($sheet) use($rows) {
                $sheet->fromArray($rows);
            });
        })->download('xlsx');
        return;
    }
}
