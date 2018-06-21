<?php
/**
 * Created by PhpStorm.
 * User: MyPC
 * Date: 6/13/2016
 * Time: 3:05 PM
 */

namespace App;

class TermRepository
{
    public $data = [];

    public $currentData = [];

    public $remove = [];

    private $fileName = '';

    public function __construct($_data, $_remove = [], $fileName = 'real-estate.php')
    {
        $this->data = array_merge($this->data, $_data);
        $this->remove = array_merge($this->remove, $_remove);
        $content = file_get_contents(config_path($fileName));
        $this->currentData = eval("?>" . $content);
        $this->fileName = $fileName;
    }

    public function push(Term $term) {
        $this->data[] = $term;
    }

    public function remove(Term $term) {
        if ($term->_deletable)
            $this->remove[] = $term;
    }

    public function writeToConfig(){
        foreach ($this->data as $item) {
            $this->currentData[$item->key]['name'] = $item->name;
            $this->currentData[$item->key]['group'] = $item->group;
            # Cho phép xóa
            if ($item->_deletable) {
                $this->currentData[$item->key]['deletable'] = true;
            }
            if ($item->key === 'size')
                $this->currentData[$item->key]['unit'] = 'm²';
            if ($this->fileName == 'real-estate.php') {
                $this->currentData[$item->key]['type'] = $item->type;
                # Set Null các giá trị term bị xóa ở estate và apartment
                /*if (isset($this->currentData[$item->key]['values'])) {
                    $diffs = array_diff1($this->currentData[$item->key]['values'], $item->values);
                    if ($this->fileName == "real-estate.php") {
                        if ($item->_type == "single") {
                            $query = Estate::query();
                            foreach ($diffs as $index => $diff) {
                                $query->orWhere($item->_key, $index);
                            }
                            $query->update([$item->_key => null]);
                        } elseif ($item->_type == "multiple") {
                            foreach ($diffs as $index => $diff) {
                                \DB::table("estates")->where($item->_key, 'LIKE', '%"' . $index . '",%')->update([
                                    $item->_key => \DB::raw("REPLACE ({$item->_key}, '\"{$index}\",', '')")
                                ]);
                                \DB::table("estates")->where($item->_key, 'LIKE', '%,"' . $index . '"]')->update([
                                    $item->_key => \DB::raw("REPLACE ({$item->_key}, '\"{$index}\"]', ']')")
                                ]);
                            }
                        }
                    }
                }*/
                $this->currentData[$item->key]['values'] = $item->values;
            }
        }

        foreach ($this->remove as $item) {
            unset($this->currentData[$item->key]);
        }

        $content = view('partials.term-config', ['repo' => $this])->render();
        file_put_contents(config_path($this->fileName), "<?php \r\n" . $content);
    }

    public function toArray(){
        return $this->currentData;
    }

}
