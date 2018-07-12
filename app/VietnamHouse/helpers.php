<?php
function img_exists($url) {
    if (file_exists(public_path($url))) {
       return asset($url);
    } else {
        \App\Contracts\CustomLog::write('image','Missing file: '.$url);
        return config('app.default_img_src');
    }
}

function getLocaleString($data) {
    $valuesString = '';
    foreach ($data as $language => $value) {
        $valuesString .= "[:{$language}]" . $value;
    }
    return $valuesString . "[:]";
}

function getLocaleStringAsArray($string) {
    $pattern = "/\[:(\w{2})\]([^\[]+)/";
    $count = preg_match_all($pattern, $string, $matches);
    if ($count == 0) return false;
    $result = [];
    foreach ($matches[1] as $index => $match) {
        $result[$matches[1][$index]] = $matches[2][$index];
    }
    return $result;
}

function getLocaleValue($value, $localeCode = null){
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

function showMenu($current_page, array $menu, array $pages_by_id, $index = 2) {
    echo '<ul class="list sub-menu-' . $index . '">';
    foreach ($menu as $item) {
        if (property_exists($item, 'url'))
            echo '<li><a href="' . LaravelLocalization::getLocalizedURL(null, url($item->url)) . '">' . getLocaleValue($item->id) . '</a>';
        else
            echo '<li><a class="' . (($current_page !== NULL and $current_page->id === $item->id) ? 'active' : '') . '" href="' . LaravelLocalization::getLocalizedURL(null, $pages_by_id[$item->id]->permalink) . '">' . $pages_by_id[$item->id]->title . '</a>';
        if (!empty($item->children)) showMenu($current_page, $item->children, $pages_by_id, $index + 1);
        echo '</li>';
    }
    echo '</ul>';
}

function showMenuAdmin(array $menu, array $pages_by_id) {
    echo '<ol class="dd-list">';
    foreach ($menu as $item) {
        if (property_exists($item, 'url'))
            echo '<li class="dd-item" data-id="' . $item->id . '" data-url="' . $item->url . '" data-new="1" data-deleted="0"><div class="dd-handle">' . getLocaleValue($item->id) . '</div> <span class="button-delete btn btn-default btn-xs pull-right" data-owner-id="' . $item->id . '"> <i class="fa fa-times-circle-o" aria-hidden="true"></i> </span>';
        else
            echo '<li class="dd-item" data-id="' . $item->id . '" data-new="1" data-deleted="0"><div class="dd-handle">' . $pages_by_id[$item->id]->title . '</div> <span class="button-delete btn btn-default btn-xs pull-right" data-owner-id="' . $item->id . '"> <i class="fa fa-times-circle-o" aria-hidden="true"></i> </span>';
        if (!empty($item->children)) showMenuAdmin($item->children, $pages_by_id);
        echo '</li>';
    }
    echo '</ol>';
}

function option($name) {
    $option = \Cache::rememberForever('option.' . $name, function() use($name) {
        return \App\Option::where('name', $name)->first();
    });
    return (!empty($option->value)) ? $option->value : '';
}

function setOption($name, $value) {
    $status = \App\Option::where('name', $name)->update(['value' => $value]);
    if ($status) Cache::forget('option.' . $name);
    return $status;
}

function writeOptions($options) {
    $file_content = '<?php' . PHP_EOL. PHP_EOL . 'return [' . PHP_EOL;
    foreach ($options as $key => $value) {
        $file_content .= "\t'$key' => '{$value}'," . PHP_EOL;
    }
    $file_content .= '];';
    file_put_contents(config_path('options.php'), $file_content);
}

function cleanName($file) {
    $filename = pathinfo($file, PATHINFO_FILENAME);
    $ext = pathinfo($file, PATHINFO_EXTENSION);
    return preg_replace('/\W/', '', $filename) . '-' . bin2hex(openssl_random_pseudo_bytes(5)) . '.' . $ext;
}
