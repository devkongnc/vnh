<?php
/**
 * Created by PhpStorm.
 * User: MyPC
 * Date: 6/7/2016
 * Time: 2:38 PM
 */

namespace App;


use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

trait MultiLanguage
{
    protected $localeData = [];

    public function __get($name)
    {
        if (in_array($name, $this->multilinguals))
        {
            $this->checkLocales();
            return array_get($this->localeData, LaravelLocalization::getCurrentLocale() . ".{$name}");
        }
        else
        {
            return $this->getAttribute($name);
        }
    }

    public function __set($name, $value)
    {
        if (in_array($name, $this->multilinguals))
        {
            throw new \InvalidArgumentException("`{$name}` is a multilingual field, please use `setLocaleValue` instead.");
        }
        $this->setAttribute($name, $value);
    }

    public function getLocalesData(){
        $this->checkLocales();
        return $this->localeData;
    }

    public function setLocalesData($data){
        $this->localeData = $data;
    }

    public function setLocaleValue($name, $value, $locale)
    {
        if (in_array($name, $this->multilinguals))
        {
            $this->checkLocales();
            array_set($this->localeData, "{$locale}.{$name}", $value);
        }
        else
        {
            throw new \InvalidArgumentException("`{$name}` is not a multilingual fields, add it to the `multilinguals` members first.");
        }
    }

    public function translate($name, $locale = null)
    {
        $this->checkLocales();
        if ($locale === null)
        {
            $data = [];
            foreach (LaravelLocalization::getSupportedLanguagesKeys() as $l)
            {
                $data[$l] = array_get($this->localeData, "{$l}.{$name}");
            }
            return $data;
        }
        else
        {
            return array_get($this->localeData, "{$locale}.{$name}");
        }
    }

    public static function create(array $attributes = [])
    {
        $model = parent::create([]);
        $model->update($attributes);
        return $model;
    }

    public function update(array $attributes = [], array $options = [])
    {
        foreach ($attributes as $name => $attribute) {
            if (in_array($name, $this->multilinguals)) {
                foreach ($attribute as $language => $value) {
                    $this->setLocaleValue($name, $value, $language);
                    unset($attributes[$name]);
                }
            }
        }
        return parent::update($attributes, $options);
    }

    public function save(array $options = [])
    {
        parent::save($options);

        if ($this->localeData) {
            $this->saveLocales();
        }
    }

    public function saveLocales()
    {
        if (!$this->exists)
        {
            throw new \InvalidArgumentException("The model does not exist, please save it first.");
        }
        $classBaseName = str_replace('\\', '', snake_case(class_basename($this)));
        $localeTable   = "{$classBaseName}" . "_translations";

        foreach ($this->localeData as $locale => $row)
        {
            $row['locale'] = $locale;

            $row["{$classBaseName}_id"] = $this->id;
            unset($row['id']);
            $where = [$row["{$classBaseName}_id"], $row['locale']];
            \DB::table($localeTable)->updateOrInsert(
                [
                    "{$classBaseName}_id" => $row["{$classBaseName}_id"],
                    "locale" => $row['locale']
                ],
                $row);
        }

        return true;
    }

    /**
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function locales()
    {
        return $this->hasMany('App\\' . class_basename($this) . 'Translate')->orderBy('title', 'asc');
    }

    protected function checkLocales()
    {
        $localeData = $this->locales;
        if (!$this->localeData && $localeData)
        {
            foreach ($localeData as $data)
            {
                $this->localeData[$data->locale] = $data->toArray();
            }
        }
    }

    public function newQuery()
    {
        return parent::newQuery()->with('locales');
    }
}