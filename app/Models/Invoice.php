<?php

// app/Models/Invoice.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Invoice extends Model
{
    protected $fillable = [
        'customer_id',
        'invoice_number',
        'issue_date',
        'due_date',
        'amount',
        'tax',
        'total_amount',
        'status',
        'notes'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($invoice) {
            $invoice->invoice_number = 'INV-' . str_pad(static::max('id') + 1, 6, '0', STR_PAD_LEFT);
            $invoice->total_amount = $invoice->amount + $invoice->tax;
        });

        static::updating(function ($invoice) {
            $invoice->total_amount = $invoice->amount + $invoice->tax;
        });
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }
}

