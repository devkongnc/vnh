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
        # Apartment Schema
        Schema::create('apartments', function (Blueprint $table) {
            $table->increments('id');
            $table->tinyInteger('status')->unsigned();
            $table->integer('product_id')->unsigned()->unique();
            $table->string('permalink')->unique();
            $table->boolean('sticky')->default(false);
            $table->smallInteger('area')->unsigned();
            $table->tinyInteger('recommend')->unsigned();
            $table->string('lat', 30);
            $table->string('lng', 30);
            $table->integer('resource_id')->unsigned()->nullable();
            $table->integer('user_id')->unsigned()->nullable();
            $table->timestamps();

            $table->foreign('resource_id')->references('id')->on('resources')->onDelete('set null');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
        });

        Schema::create('apartment_translations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('apartment_id')->unsigned();
            $table->enum('locale', ['ja', 'en', 'vi']);
            $table->string('title', 1000);
            $table->text('description');
            $table->string('meta_keywords');
            $table->string('meta_description');

            $table->string('owner');
            $table->string('units');
            $table->string('floor_plan');
            $table->string('rent_market');
            $table->string('pet');
            $table->string('security');
            $table->string('time_to_cbd');
            $table->string('address');

            $table->string('pool');
            $table->string('gym');
            $table->string('supermarket');
            $table->string('store');
            $table->string('atm');
            $table->string('restaurant');
            $table->string('tennis');
            $table->string('bbq');
            $table->string('dog_run');

            $table->string('kitchen');
            $table->string('oven');
            $table->string('bathtub');
            $table->string('terrace');

            $table->string('children_pool');
            $table->string('outdoor_playground');
            $table->string('indoor_playground');
            $table->string('bus_stop');

            $table->foreign('apartment_id')->references('id')->on('apartments')->onDelete('cascade');
        });

        Schema::create('apartment_resource', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('apartment_id')->unsigned();
            $table->integer('resource_id')->unsigned();
            $table->tinyInteger('order')->unsigned();

            $table->foreign('apartment_id')->references('id')->on('apartments')->onDelete('cascade');
            $table->foreign('resource_id')->references('id')->on('resources')->onDelete('cascade');
        });

        # RealEstate Schema
        Schema::create('estates', function (Blueprint $table) {
            $table->increments('id');
            $table->tinyInteger('status')->unsigned();
            $table->integer('product_id')->unsigned()->unique();
            $table->integer('resource_id')->unsigned()->nullable();
            $table->integer('apartment_id')->unsigned()->nullable();
            $table->text('category_ids');
            $table->string('lat', 30);
            $table->string('lng', 30);
            $table->decimal('price', 10, 0);
            $table->smallInteger('deposit')->unsigned();
            $table->smallInteger('city')->unsigned();
            $table->smallInteger('area')->unsigned();
            $table->smallInteger('type')->unsigned();
            $table->smallInteger('size')->unsigned();
            $table->smallInteger('beds')->unsigned();
            $table->smallInteger('baths')->unsigned();
            $table->smallInteger('time_to_cbd')->unsigned();
            $table->smallInteger('time_to_super')->unsigned();
            $table->smallInteger('furniture')->unsigned();
            $table->smallInteger('kitchen')->unsigned();
            $table->smallInteger('pet')->unsigned();
            $table->text('facilities');
            $table->text('inclusive');
            $table->text('surroundings');
            $table->smallInteger('size_rangefor_search')->unsigned();
            $table->smallInteger('building_name')->unsigned();
            $table->integer('user_id')->unsigned()->nullable();
            $table->timestamps();

            $table->foreign('resource_id')->references('id')->on('resources')->onDelete('set null');
            $table->foreign('apartment_id')->references('id')->on('apartments')->onDelete('set null');
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
            //$table->integer('parent_id')->unsigned()->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('resource_id')->references('id')->on('resources')->onDelete('set null');
            //$table->foreign('parent_id')->references('id')->on('reviews')->onDelete('cascade');
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
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');

        Schema::drop('estate_translations');
        Schema::drop('estate_resource');
        Schema::drop('estate_sticky');
        Schema::drop('estates');

        Schema::drop('apartment_translations');
        Schema::drop('apartment_resource');
        Schema::drop('apartments');

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
    }
}
