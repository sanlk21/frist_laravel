<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // database/migrations/xxxx_create_invoices_table.php
public function up()
{
    Schema::create('invoices', function (Blueprint $table) {
        $table->id();
        $table->foreignId('customer_id')->constrained();
        $table->string('invoice_number')->unique();
        $table->date('issue_date');
        $table->date('due_date');
        $table->decimal('amount', 10, 2);
        $table->decimal('tax', 10, 2)->default(0);
        $table->decimal('total_amount', 10, 2);
        $table->enum('status', ['draft', 'sent', 'paid', 'overdue', 'cancelled'])->default('draft');
        $table->text('notes')->nullable();
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
