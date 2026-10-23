<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create('terminals', function(Blueprint $table){ $table->id(); $table->string('name'); $table->string('place'); $table->string('status')->default('active')->index(); $table->unsignedInteger('wait_minutes')->default(10); $table->unsignedInteger('capacity')->default(30); $table->timestamps(); });
        Schema::create('fare_routes', function(Blueprint $table){ $table->id(); $table->foreignId('origin_terminal_id')->constrained('terminals')->cascadeOnDelete(); $table->foreignId('destination_terminal_id')->constrained('terminals')->cascadeOnDelete(); $table->decimal('fare',8,2); $table->string('status')->default('approved')->index(); $table->timestamps(); $table->unique(['origin_terminal_id','destination_terminal_id']); });
        Schema::create('queue_entries', function(Blueprint $table){ $table->id(); $table->foreignId('user_id')->constrained()->cascadeOnDelete(); $table->foreignId('terminal_id')->constrained()->cascadeOnDelete(); $table->string('status')->default('pending')->index(); $table->string('ticket_number')->unique(); $table->timestamps(); });
    }
    public function down(): void { Schema::dropIfExists('queue_entries'); Schema::dropIfExists('fare_routes'); Schema::dropIfExists('terminals'); }
};
