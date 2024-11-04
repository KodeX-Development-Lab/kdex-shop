<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('delivery_tasks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('title');
            $table->text('description');
            $table->date('start_date');
            $table->date('deadline');
            $table->enum('priority',['high','middle','low']);
            $table->string('customer_address');
            $table->string('phone');
            $table->enum('status',['pending','in_progress','complete'])->default('pending');
            $table->timestamps();
           
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('delivery_tasks');
    }

};
