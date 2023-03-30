<?php

use App\Models\Configuration;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('configurations', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('value')->nullable();
            $table->string('module')->nullable()->comment('The module in which the setting resides in');
            $table->string('type')->default('text')->comment(implode(', ', [Configuration::TYPE_BOOL,Configuration::TYPE_TEXT,Configuration::TYPE_NUMBER]));
            $table->string('description')->nullable();
            $table->string('hint')->nullable()->comment('The hint to use for the setting');
            $table->string('default')->nullable()->comment('default value. Good for routes with parameters');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('configurations');
    }
};
