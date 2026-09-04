<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Extend the category enum to include the new "Body Enhancement" category.
        DB::statement("ALTER TABLE services MODIFY COLUMN category ENUM(
            'maternity_postop', 'body_treatments', 'skin_treatments', 'rejuvenation', 'body_enhancement'
        ) NOT NULL");

        Schema::table('services', function (Blueprint $table) {
            $table->string('meta_title', 160)->nullable()->after('description');
            $table->string('meta_description', 300)->nullable()->after('meta_title');
        });
    }

    public function down(): void
    {
        Schema::table('services', function (Blueprint $table) {
            $table->dropColumn(['meta_title', 'meta_description']);
        });

        // Reassign any body_enhancement rows before shrinking the enum back down.
        DB::table('services')->where('category', 'body_enhancement')->update(['category' => 'body_treatments']);

        DB::statement("ALTER TABLE services MODIFY COLUMN category ENUM(
            'maternity_postop', 'body_treatments', 'skin_treatments', 'rejuvenation'
        ) NOT NULL");
    }
};
