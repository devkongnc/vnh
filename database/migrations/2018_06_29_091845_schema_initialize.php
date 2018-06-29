<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class SchemaInitialize extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        # User Schema
            Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password', 60);
            $table->rememberToken();
            $table->tinyInteger('level')->unsigned();
            $table->string('phone', 30);
            $table->string('profile', 500);
            $table->timestamps();
        });

        Schema::create('password_resets', function (Blueprint $table) {
            $table->string('email')->index();
            $table->string('token')->index();
            $table->timestamp('created_at');
        });

        # Resources Schema
             Schema::create('resources', function (Blueprint $table) {
            $table->increments('id');
            $table->string('folder');
            $table->string('filename');
            $table->string('url');
            $table->timestamps();
        });

        # RealEstate Schema
            Schema::create('estates', function (Blueprint $table) {
                $table->increments('id');
                $table->tinyInteger('status')->unsigned();
                $table->integer('product_id')->unsigned()->unique();
                $table->integer('resource_id')->unsigned()->nullable();
                $table->text('category_ids');
                $table->string('lat', 30);
                $table->string('lng', 30);
                $table->decimal('price', 10, 0);
                $table->smallInteger('deposit')->unsigned();
                $table->smallInteger('city')->unsigned();
                $table->smallInteger('area')->unsigned();
                $table->smallInteger('size')->unsigned();
                $table->smallInteger('time_to_super')->unsigned();
                $table->text('facilities');
                $table->text('inclusive');
                $table->text('surroundings');
                $table->string('address', 250)->nullable();
                $table->string('contract_limit', 250)->nullable();
                $table->integer('floor')->nullable();
                $table->string('conditioning_system', 250)->nullable();
                $table->date('anniversary')->nullable();
                $table->integer('commiss')->nullable();
                $table->smallInteger('size_rangefor_search')->unsigned();
                $table->smallInteger('building_name')->unsigned();
                $table->integer('user_id')->unsigned()->nullable();
                $table->timestamps();

                $table->foreign('resource_id')->references('id')->on('resources')->onDelete('set null');
                $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
            });

            DB::statement('ALTER TABLE estates ADD FULLTEXT facilities(facilities)');
            DB::statement('ALTER TABLE estates ADD FULLTEXT inclusive(inclusive)');
            DB::statement('ALTER TABLE estates ADD FULLTEXT surroundings(surroundings)');

            Schema::create('estate_translations', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('estate_id')->unsigned();
                $table->enum('locale', ['ja', 'en', 'vi']);
                $table->string('title', 1000);
                $table->text('description');

                $table->foreign('estate_id')->references('id')->on('estates')->onDelete('cascade');
            });
            Schema::create('estate_resource', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('estate_id')->unsigned();
                $table->integer('resource_id')->unsigned();
                $table->tinyInteger('order')->unsigned();

                $table->foreign('estate_id')->references('id')->on('estates')->onDelete('cascade');
                $table->foreign('resource_id')->references('id')->on('resources')->onDelete('cascade');
            });
            Schema::create('estate_sticky', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('estate_id')->unsigned();
                $table->timestamps();

                $table->foreign('estate_id')->references('id')->on('estates')->onDelete('cascade');
            });

            Schema::table('estates', function (Blueprint $table) {
                $table->string('slug_vi')->after('id');
                $table->string('slug_en')->after('id');
            });
            $estates = \App\Estate::all();
            foreach ($estates as $estate) {
                $estate->slug_vi = str_slug($estate->translate('title', 'vi'));
                $estate->slug_en = str_slug($estate->translate('title', 'en'));
                $estate->save();
            }


        # Category Schema
            Schema::create('categories', function (Blueprint $table) {
            $table->increments('id');
            $table->tinyInteger('status')->unsigned();
            $table->string('permalink')->unique();
            $table->boolean('sticky')->default(false);
            $table->integer('resource_id')->unsigned()->nullable();
            $table->text('sql_data');
            $table->integer('user_id')->unsigned()->nullable();
            $table->timestamps();

            $table->foreign('resource_id')->references('id')->on('resources')->onDelete('set null');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
        });

        Schema::create('category_translations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('category_id')->unsigned();
            $table->enum('locale', ['ja', 'en', 'vi']);
            $table->string('title', 1000)->index();
            $table->string('keywords');
            $table->string('meta_keywords');
            $table->string('meta_description');
            $table->text('description');

            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
        });

        Schema::create('category_estates', function (Blueprint $table) {
            $table->integer('estate_id')->unsigned();
            $table->integer('category_id')->unsigned();

            $table->foreign('estate_id')->references('id')->on('estates')->onDelete('cascade');
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
            $table->primary(['estate_id', 'category_id']);
        });

        # Review Schema
        Schema::create('reviews', function (Blueprint $table) {
            $table->increments('id');
            $table->string('permalink')->unique();
            $table->boolean('draft')->default(false);
            $table->tinyInteger('status')->unsigned();
            $table->text('categories');
            $table->text('locales_only');
            $table->dateTime('timestamp');
            $table->integer('resource_id')->unsigned()->nullable();
            $table->integer('user_id')->unsigned()->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('resource_id')->references('id')->on('resources')->onDelete('set null');
        });

        Schema::create('review_translations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('review_id')->unsigned();
            $table->enum('locale', ['ja', 'en', 'vi']);
            $table->string('title', 1000);
            $table->text('description');

            $table->index('title');
            $table->foreign('review_id')->references('id')->on('reviews')->onDelete('cascade');;
        });

        # Page Schema
        Schema::create('pages', function (Blueprint $table) {
            $table->increments('id');
            $table->tinyInteger('status')->unsigned();
            $table->string('permalink')->unique();
            $table->text('css');
            $table->integer('user_id')->unsigned()->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
        });

        Schema::create('page_translations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('page_id')->unsigned();
            $table->enum('locale', ['ja', 'en', 'vi']);
            $table->string('title', 1000);
            $table->text('html');

            $table->foreign('page_id')->references('id')->on('pages')->onDelete('cascade');
        });

        # Contact Schema
        Schema::create('contacts', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('phone', 15);
            $table->string('email');
            $table->text('message');
            $table->string('estates')->nullable();
            $table->boolean('unread')->default(true);
            $table->timestamps();
        });

        # User Schema
        Schema::table('users', function (Blueprint $table) {
            $table->integer('resource_id')->unsigned()->nullable();

            $table->foreign('resource_id')->references('id')->on('resources')->onDelete('set null');
        });

        # Ltm Translations Schema
        Schema::create('ltm_translations', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('status')->default(0);
            $table->string('locale');
            $table->string('group');
            $table->string('key');
            $table->text('value')->nullable();
            $table->timestamps();
        });

        # Options Schema
        Schema::create('options', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique();
            $table->text('value');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');

        Schema::drop('users');
        Schema::drop('password_resets');

        Schema::drop('resources');

        Schema::drop('estate_translations');
        Schema::drop('estate_resource');
        Schema::drop('estate_sticky');
        Schema::drop('estates');

        Schema::drop('category_estates');
        Schema::drop('category_translations');
        Schema::drop('categories');

        Schema::drop('review_translations');
        Schema::drop('reviews');

        Schema::drop('page_translations');
        Schema::drop('pages');

        Schema::drop('contacts');

        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign('users_resource_id_foreign');
            $table->dropColumn('resource_id');
        });

        Schema::drop('ltm_translations');

        Schema::drop('options');
    }
}
