<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
public function up()
{
    Schema::table('pemesanan', function (Blueprint $table) {
        // 1. drop foreign key
        $table->dropForeign(['menu_id']); 
        
        // 2. drop kolom
        $table->dropColumn(['menu_id', 'jumlah']);
    });
}

public function down()
{
    Schema::table('pemesanan', function (Blueprint $table) {
        // rollback (opsional)
        $table->foreignId('menu_id')->constrained('menu');
        $table->integer('jumlah')->default(1);
    });
}
};
