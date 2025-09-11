<?php

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
        Schema::create('contacts', function (Blueprint $table) {
            $table->id();
            $table->string('company');                                  // Enum
            $table->string('title')->nullable();                                    // Enum (controllare per title_id = 0)
            $table->string('surname');
            $table->string('name')->nullable();
            $table->string('toponym')->nullable();                                  // Enum
            $table->string('addr')->nullable();
            $table->string('num')->nullable();
            $table->string('apart')->nullable();
            $table->string('city')->nullable();
            $table->string('cap')->nullable();
            $table->string('province')->nullable();
            $table->string('phone_1')->nullable();
            $table->string('phone_2')->nullable();
            $table->string('fax')->nullable();
            $table->string('smart_1')->nullable();
            $table->string('smart_2')->nullable();
            $table->string('email_1')->nullable();
            $table->string('email_2')->nullable();
            $table->string('site')->nullable();
            $table->string('note')->nullable();
            $table->timestamps();
        });

        Schema::create('referents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('contact_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->string('title')->nullable();
            $table->string('phone')->nullable();
            $table->string('fax')->nullable();
            $table->string('smart')->nullable();
            $table->string('email')->nullable();
            $table->timestamps();
        });

        // Schema::create('titles', function (Blueprint $table) {       // sostituita da Enum
        //     $table->id();
        //     $table->string('name');
        //     $table->string('acronym');
        //     $table->timestamps();
        // });

        // Schema::create('toponyms', function (Blueprint $table) {     // sostituita da Enum
        //     $table->id();
        //     $table->string('name');
        //     $table->string('acronym');
        //     $table->timestamps();
        // });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('referents');
        Schema::dropIfExists('contacts');
    }
};
