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
            $table->string('company');                                  // Enum per dare accessibilità in base ad azienda (indicata nell'utente)
            $table->string('title');                                    // Enum
            $table->string('surname');
            $table->string('name');
            $table->string('toponym');                                  // Enum
            $table->string('addr');
            $table->string('num');
            $table->string('apart');
            $table->string('city');
            $table->string('cap');
            $table->string('province');
            $table->string('phone_1');
            $table->string('phone_2');
            $table->string('fax');
            $table->string('smart_1');
            $table->string('smart_2');
            $table->string('email_1');
            $table->string('email_2');
            $table->string('site');
            $table->string('note');
            $table->timestamps();
        });

        Schema::create('referents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('contact_id')->constrained();
            $table->string('name');
            $table->string('title');
            $table->string('phone');
            $table->string('fax');
            $table->string('smart');
            $table->string('email');
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
