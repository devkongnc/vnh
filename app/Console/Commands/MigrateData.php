<?php

namespace App\Console\Commands;

use App\Estate;
use App\Resource;
use App\Term;
use App\TermRepository;
use App\User;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class MigrateData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'migrate:server';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Migrate data from old database';

    private function _initEstates() {
        $terms = $this->_initTerms();
        \DB::table('estates')->delete();
        \DB::statement('ALTER TABLE estates AUTO_INCREMENT = 1;');
        \DB::statement('ALTER TABLE estate_resource AUTO_INCREMENT = 1;');
        $estates = \DB::connection('old_server')->select('
            SELECT cscart_products.product_code, cscart_products.product_id, cscart_products.list_price, cscart_products.status, cscart_products.timestamp, cscart_product_descriptions.product, cscart_product_descriptions.full_description, cscart_product_descriptions.lang_code
            FROM cscart_products JOIN cscart_product_descriptions ON cscart_products.product_id = cscart_product_descriptions.product_id
            ORDER BY cscart_products.product_id ASC
        ;');
        $estates = new Collection($estates);
        $estates = $estates->groupBy(function ($estate){
            return $estate->product_code;
        });
        $bar = $this->output->createProgressBar(count($estates));
        foreach ($estates as $product_code => $estate) {
            $model = Estate::create([
                'product_id' => $estate[0]->product_code,
                'status'     => $estate[0]->status == 'A' ? Estate::VISIBILITY_PUBLIC : ($estate[0]->status == 'H' ? Estate::VISIBILITY_PRIVATE : Estate::VISIBILITY_HIDDEN),
                'price'      => $estate[0]->list_price,
            ]);
            foreach ($estate as $localeEstate) {
                $model->setLocaleValue('title', $localeEstate->product, $this->_convertLocaleKey($localeEstate->lang_code));
                $model->setLocaleValue('description', $localeEstate->full_description, $this->_convertLocaleKey($localeEstate->lang_code));
            }

            # Set Resource
            $images = \DB::connection('old_server')->select("
                SELECT cscart_images.image_path, cscart_images.image_id, cscart_images_links.type
                FROM cscart_images JOIN cscart_images_links ON cscart_images.image_id = cscart_images_links.detailed_id
                WHERE cscart_images_links.object_id={$estate[0]->product_id}
            ");

            if (!\File::exists(public_path("upload/images/$model->product_id")))
                \File::makeDirectory(public_path("upload/images/$model->product_id"), intval('0775', 8), true);

            $resources = [];
            foreach ($images as $index => $image) {
                $id = $image->image_id > 999 ? (int) ($image->image_id / 1000) : 0;
                /*$group = (int)($model->product_id / 10000);
                $group = $group * 10000 . "-" . ($group+1)*10000;*/
                $resource = Resource::create([
                    'folder'   => "images/{$model->product_id}/",
                    'filename' => $image->image_path,
                    'url'      => "http://vietnamhouse.jp/images/detailed/{$id}/{$image->image_path}"
                ]);
                /*$resource = Resource::where([
                    'url' => "http://vietnamhouse.jp/images/detailed/{$id}/{$image->image_path}"
                ])->first();*/

                if ($image->type === 'M') {
                    $model->resource_id = $resource->id;
                    $resources[$resource->id] = ['order' => 0];
                } else $resources[$resource->id] = ['order' => $index + 1];
            }

            /*if (count($resources) > 0) {
                $model->resource_id = $resources[0]->id;
                unset($resources[0]);
            }*/

            # Set Term
            $term_values = new Collection(\DB::connection('old_server')->select("SELECT * FROM cscart_product_features_values WHERE cscart_product_features_values.lang_code = 'EN' AND cscart_product_features_values.product_id = {$estate[0]->product_id};"));
            $term_values = $term_values->groupBy(function ($item){
                return $item->feature_id;
            });

            foreach ($terms as $index => $term) {
                $term_value = $term_values->get($index);

                if (in_array($term->key, ['text', 'tel', 'e_mail', 'street', 'maximum_sizeoffice'])) continue;
                if ($term->key == 'text') continue;
                if ($term->type == 'multiple') {
                    $value = $term_value != null ? json_encode($term_value->lists('variant_id')->all()) : '[]';
                } else {
                    $value = $term_value != null ? $term_value[0]->variant_id : 0;
                }
                /*if ($index == 29 && $model->product_id == 22026) {
                    $this->comment($term->key);
                    $this->comment($value);
                }*/
                if (isset($term)) {
                    $model->{$term->key} = $value;
                }
            }

            $model->created_at = Carbon::createFromTimestamp($estate[0]->timestamp)->toDateTimeString();
            $model->save(['timestamps' => false]);
            $model->resources()->sync($resources);
            $bar->advance();
        }
        $bar->finish();
    }

    private function _initTerms() {
        \Auth::login(User::first());
        # Terms from features
        $features = \DB::connection('old_server')->select("SELECT cscart_product_features_descriptions.feature_id, cscart_product_features_descriptions.description, cscart_product_features_descriptions.lang_code FROM cscart_product_features JOIN cscart_product_features_descriptions on cscart_product_features.feature_id =  cscart_product_features_descriptions.feature_id;");
        $feature_values = \DB::connection('old_server')->select("SELECT cscart_product_feature_variant_descriptions.variant, cscart_product_feature_variant_descriptions.variant_id, cscart_product_feature_variants.feature_id, cscart_product_feature_variant_descriptions.lang_code FROM cscart_product_feature_variant_descriptions JOIN cscart_product_feature_variants ON cscart_product_feature_variant_descriptions.variant_id = cscart_product_feature_variants.variant_id ORDER BY cscart_product_feature_variant_descriptions.variant_id;");
        $valuesOfFeature = with(new Collection($feature_values))->groupBy(function($value) {
            return $value->feature_id;
        });
        file_put_contents('values', json_encode($valuesOfFeature));
        $features = new Collection($features);
        $groupFeatures = $features->groupBy(function ($feature){
            return $feature->feature_id;
        });
        $terms = [];
        foreach ($groupFeatures as $index => $feature) {
            $name = [];
            $values = [];
            foreach ($feature as $data) {
                $name[strtolower($this->_convertLocaleKey($data->lang_code))] = $data->description;
            }

            if (!isset($valuesOfFeature[$feature[0]->feature_id])) continue;
            $valuesCollection = new Collection($valuesOfFeature[$feature[0]->feature_id]);
            $valuesCollection->each(function ($item) use (&$values){
                $values[$item->variant_id][strtolower($this->_convertLocaleKey($item->lang_code))] = $item->variant;
            });

            $term = new Term();
            $term->_key = Str::slug(str_replace("-", "_", strtolower($name['en'])), "_");
            $term->_name = $name;
            if ($term->_key == 'facilities' || $term->_key == 'surroundings' || $term->_key == 'inclusive') {
                $term->_type = 'multiple';
                $term->_group = 'details';
            }
            else
                $term->_type = "single";
            $term->_values = $values;
            $terms[$feature[0]->feature_id] = $term;
        }

        $repo = new TermRepository($terms);
        $repo->writeToConfig();
        return $terms;
    }

    private function _convertLocaleKey($key) {
        switch ($key) {
            case "JP": return "ja";
            case "VN": return "vi";
            case "EN": return "en";
        }
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $estates = $this->_initEstates();
    }
}
