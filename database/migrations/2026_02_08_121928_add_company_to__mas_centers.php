<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        foreach (config('database.connections') as $key => $connection) {
            if ($connection['driver'] == 'sqlsrv' && !in_array($key, ['other', 'sqlsrv'])) {
                try {
                    Schema::connection($key)->table('dbo.MasCenters', function (Blueprint $table) {
                        $table->integer('company_id')->default(\App\Models\bank\Companies::min('CompNo'));
                    });
                } catch (\Exception $e) {
                    info($e);
                }
            }
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('_mas_centers', function (Blueprint $table) {
            $table->dropColumn('company_id');
        });
    }
};
