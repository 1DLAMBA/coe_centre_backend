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
        Schema::table('personal_details', function (Blueprint $table) {
            $table->boolean('course_paid')->default(false)->after('has_paid'); // Replace 'last_column_name' with the actual column name after which you want to add this column
            $table->date('course_fee_reference')->nullable()->after('course_paid');
            $table->string('couse_fee_date')->nullable()->after('course_fee_reference');
            $table->string('gender')->nullable()->after('couse_fee_date');
            $table->string('place_of_birth')->nullable()->after('gender');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('personal_details', function (Blueprint $table) {
            // $table->dropColumn(['has_paid', 'application_date', 'application_trxid', 'application_reference']);
        });
    }
};
