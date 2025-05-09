<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // database/migrations/xxxx_create_proposals_table.php
public function up()
{
    Schema::create('proposals', function (Blueprint $table) {
        $table->id();
        $table->foreignId('customer_id')->constrained();
        $table->string('title');
        $table->text('description');
        $table->decimal('amount', 10, 2);
        $table->date('proposal_date');
        $table->date('expiry_date');
        $table->enum('status', ['draft', 'sent', 'accepted', 'rejected'])->default('draft');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('proposals');
    }
};
