<?php
/**
 * Created by PhpStorm.
 * User: MyPC
 * Date: 6/13/2016
 * Time: 5:37 PM
 */

namespace App;


use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class Term {

    CONST TYPE_ESTATE    = 1;
    //CONST TYPE_APARTMENT = 2;

    public $_key; # Khóa term
    public $_group; # Nhóm term: basic, details
    public $_type; # Loại term: Text, Single Choice, Multitple Choice
    public $_name;
    public $_values; # Mảng các giá trị
    public $_deletable = false;

    public function __construct($file = 'real-estate', $key = null)
    {
        if ($key != null) {
            $categorized = explode('.', $key);
            $this->_group = $categorized[0];
            $this->_key = $categorized[1];
            $termData = \Config::get("{$file}." . $this->_key);
            $this->_name = Term::getLocaleStringAsArray($termData['name']);
            $this->_type = array_get($termData, 'type', 'text');
            $this->_deletable = isset($termData['deletable']);
            if (isset($termData['values']) && is_array($termData['values'])) {
                $values = [];
                foreach ($termData['values'] as $index => $value) {
                    $localeArray = Term::getLocaleStringAsArray($value);
                    if ($localeArray == false) {
                        $localeArray = [];
                        foreach (LaravelLocalization::getSupportedLanguagesKeys() as $key) {
                            $localeArray[$key] = $value;
                        }
                    }
                    $values[$index] = $localeArray;
                }
                $this->_values = $values;
            }
        }
    }

    public function __get($name)
    {
        switch ($name) {
            case 'values':
                $values = [];
                foreach ($this->_values as $index => $value) {
                    $values[$index] = $this->getLocaleString($value);
                }
                return $values;
            case 'name':
                return $this->getLocaleString($this->_name);
            case 'key';
                if (!isset($this->_key)) return 'unset';
                return $this->_key;
            case 'group':
                if (!isset($this->_group)) return 'basic';
                return $this->_group;
            case 'type':
                if (!isset($this->_type)) return 'text';
                return $this->_type;
        }
    }

    public function __set($name, $value)
    {
        if ($name == "values") {

        } else {
            $this->{"_".$name} = $value;
        }
    }

    public function getLocaleString($data) {
        $valuesString = '';
        foreach ($data as $language => $value) {
            $valuesString .= "[:{$language}]" . $value;
        }
        return $valuesString . "[:]";
    }

    public static function getLocaleStringAsArray($string) {
        $pattern = "/\[:(\w{2})\]([^\[]+)/";
        $count = preg_match_all($pattern, $string, $matches);
        if ($count == 0) return false;
        $result = [];
        foreach ($matches[1] as $index => $match) {
            $result[$matches[1][$index]] = $matches[2][$index];
        }
        return $result;
    }

    public static function getLocaleValue($value, $localeCode = null){
        if ($localeCode == null) {
            $localeCode = LaravelLocalization::getCurrentLocale();
        }
        $pattern = "/\[:{$localeCode}\]([^\[]+)\[:/";
        preg_match($pattern, $value, $matches);
        if (isset($matches[1])) {
            return $matches[1];
        } else {
            return "";
        }
    }

}
