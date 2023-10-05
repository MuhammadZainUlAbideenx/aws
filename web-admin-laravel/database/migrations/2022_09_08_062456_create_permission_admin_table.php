<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePermissionAdminTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('permission_admin', function (Blueprint $table) {
            $table->unsignedBigInteger('permission_id')->index('permission_user_permission_id_foreign');
            $table->unsignedBigInteger('admin_id');
            $table->string('user_type');

            $table->primary(['admin_id', 'permission_id', 'user_type']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('permission_admin');
    }
}
