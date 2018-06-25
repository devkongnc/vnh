<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Term;
use App\TermRepository;
use Artisan;
use Illuminate\Http\Request;
use URL;

class TermController extends Controller
{

    protected $type = Term::TYPE_ESTATE;

    public function __construct() {
        $this->middleware('is_admin');
       // if (str_contains(URL::previous(), 'apartment')) $this->type = Term::TYPE_APARTMENT;
    }

    /**
     * Display a listing of the resource.
     * @param $type
     * @return \Illuminate\Http\Response
     */
    public function index($type)
    {
        return view("admin.{$type}.term");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request, $type)
    {
        if ($type == 'real-estate') {
        }
        $term = new Term();
        return view('admin.real-estate.term-content', compact('term'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $type)
    {
        return $this->update($request, $type);
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
     * @param Request $request
     * @param $type
     * @param $termId
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $type, $termId)
    {
        $term = new Term($type, $termId);
        return view("admin.{$type}.term-content", compact('term', 'termId'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $type, $term = null)
    {
        if ($term == null) {
            $termKey = "term_" . count(\Config::get("{$type}"));
            $term = new Term();
            $term->_key = $termKey;
            $term->_deletable = true;
            $this->dynamic_migrate($request, $termKey);
        } else {
            $term = new Term($type, $term);
        }
        $term->_values = $request->get('values', []);
        $term->_name = $request->get('_name');
        $term->_group = $request->get('group');
        $term->_type = $request->get('type');
        with(new TermRepository([$term], [], "{$type}.php"))->writeToConfig();
        return back()->withFlashData(['status' => 'success', 'message' => trans('admin.message.success.update')]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     * @internal param int $id
     */
    public function destroy(Request $request, $type)
    {
        $key = $request->get('key');
        $term = new Term($type, $key);
        if ($term->_deletable) {

            # Rollback migration
            //$table = ($this->type === Term::TYPE_APARTMENT) ? with(new \App\ApartmentTranslate)->getTable() : with(new \App\Estate)->getTable();
            $table = with(new \App\Estate)->getTable();
            $file_name_postfix = str_replace('-', '_', "add_{$term->_key}_to_{$table}_table");
            $class = ucfirst(camel_case($file_name_postfix));
            $file = \File::glob(database_path("migrations" . DIRECTORY_SEPARATOR) . "*{$file_name_postfix}*");
            if (!empty($file)) {
                $file = array_shift($file);
                require_once $file;
                $migration = new $class();
                $migration->down();
                # Delete migration files
                \File::delete($file);
                $file = str_replace(".php", "", trim(strrchr($file, DIRECTORY_SEPARATOR), DIRECTORY_SEPARATOR));
                \DB::table("migrations")->where("migration", $file)->delete();
            }
            # Clear Config File
            with(new TermRepository([], [$term], "{$type}.php"))->writeToConfig();
            # Nếu key nằm trong search thì xóa
            $options = config('options');
            $selected = json_decode($options['search'], true);
            if (in_array($term->_key, $selected)) {
                $key = array_search($term->_key, $selected);
                unset($selected[$key]);
                $options['search'] = json_encode($selected, JSON_FORCE_OBJECT);
                writeOptions($options);
            }
        }
        return back()->withFlashData(['status' => 'success', 'message' => trans('admin.message.success.delete')]);
    }

    /**
     * Tự động migrate database
     *
     * @param  Request $request
     * @param  string  $termKey
     * @return void
     */
    private function dynamic_migrate(Request $request, $termKey) {
        # Tạo file migration
        //$table = ($this->type === Term::TYPE_APARTMENT) ? with(new \App\ApartmentTranslate)->getTable() : with(new \App\Estate)->getTable();
        $table = with(new \App\Estate)->getTable();
        Artisan::call('make:migration', ['name' => str_replace('-', '_', "add_{$termKey}_to_{$table}_table")]);

        # Ghi vào file migrate vừa tạo
        $output = Artisan::output();
        preg_match('/: ([\d_a-z]+)/', $output, $matches);
        $migrate_file_name = $matches[1] . '.php';
        $data = (object) [
            'table_name' => $table,
            'class_name' => ucfirst(camel_case(str_replace('-', '_', "add_{$termKey}_to_{$table}_table"))),
            'term_key'   => $termKey,
            'type'       => $request->type
        ];
        $content = html_entity_decode(view('partials.term-migrate', ['data' => $data])->render());
        file_put_contents(database_path('migrations/' . $migrate_file_name), "<?php \r\n" . $content);

        # Chạy Artisan migration
        Artisan::call('migrate');

    }
}
