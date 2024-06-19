<?php

use Illuminate\Database\Migrations\Migration;

use Illuminate\Database\Schema\Blueprint;

use Illuminate\Support\Facades\Schema;

class AddProductSoftDelete extends Migration

{

   // migration시 - deleted_at column을 추가

    public function up()

    {

        Schema::table('AF_product', function (Blueprint $table) {

            //

            $table->softDeletes();

        });

    }

 // rollback시 - deleted_at column을 삭제

    public function down()

    {

        Schema::table('AF_product', function (Blueprint $table) {

            //

            $table->dropSoftDeletes();

        });

    }

}