<?php

namespace App\Console\Commands;

use App\Resource;
use Illuminate\Console\Command;

class CropImage extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'resource:crop';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Crop Resource into Sizes: 300x300, 260x175';

    /**
     * Create a new command instance.
     *
     */
    private $sizes = [
        [ "width" => 300, "height" => 300 ],
        [ "width" => 300, "height" => 200 ],
        [ "width" => 600, "height" => 600 ]
    ];

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $resources = Resource::where('url', '<>', '')->get();
        $bar = $this->output->createProgressBar(count($resources));
        foreach ($resources as $resource) {
            $path = public_path('upload/' . $resource->folder) . $resource->filename;

            $this->_normalizeURL($path);
            try {
                # Không download lại hình cũ
                if (!\File::exists($path)) {
                    file_put_contents($path, file_get_contents($resource->url_raw));
                }
                # Không support windows
                /*if (DIRECTORY_SEPARATOR != "/") continue;
                foreach ($this->sizes as $size) {
                    $url = \Image::url($path, $size["width"], $size["height"]);
                    $this->_normalizeURL($url);
                    if (\File::exists($url)) continue;
                    \Image::make($path, $size, ['crop' => true])->save($url);
                }*/
            } catch (\Exception $ex) {
                $this->error($ex->getMessage());
                $resource->delete();
                continue;
            }
            $bar->advance();
        }
        $bar->finish();
    }

    private function _normalizeURL(&$url) {
        $url = str_replace("/", DIRECTORY_SEPARATOR, $url);
        $url = str_replace("\\", DIRECTORY_SEPARATOR, $url);
    }
}
