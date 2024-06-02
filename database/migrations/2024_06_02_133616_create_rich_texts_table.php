<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateRichTextsTable extends Migration
{
    public function up()
    {
        Schema::table('rich_texts', function (Blueprint $table) {
            $table->string('image_path')->nullable()->after('body'); // Add a column for image_path
        });
    }

    public function down()
    {
        Schema::table('rich_texts', function (Blueprint $table) {
            $table->dropColumn('image_path');
        });
    }
}
