<?php

use App\Enums\CodeDuration;
use App\Enums\CodeStatus;
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
        Schema::create('codes', function (Blueprint $table) {
            $table->id();
            $table->mediumText('code');
            $table->enum('status', array_map( fn($case) => $case->name, CodeStatus::cases()))
            ->default(CodeStatus::UNUSED);
            $table->string('device_id')->nullable();
            $table->enum('duration', array_map( fn($case) => $case->name, CodeDuration::cases()));
            $table->timestamp('used_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('codes');
    }
};
