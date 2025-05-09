<?php

// app/Http/Controllers/TransactionController.php
namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Invoice;
use App\Models\Customer;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TransactionController extends Controller
{
    public function index()
    {
        return Inertia::render('Transaction', [
            'transactions' => Transaction::with(['invoice', 'customer'])->latest()->get(),
            'invoices' => Invoice::where('status', 'sent')->get(),
            'customers' => Customer::all(),
            'editingTransaction' => null
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'invoice_id' => 'required|exists:invoices,id',
            'customer_id' => 'required|exists:customers,id',
            'amount' => 'required|numeric|min:0',
            'payment_method' => 'required|in:credit_card,paypal,bank_transfer,cash',
            'status' => 'required|in:pending,completed,failed,refunded',
            'notes' => 'nullable|string'
        ]);

        $transaction = Transaction::create($validated);

        // Update invoice status if payment completed
        if ($validated['status'] === 'completed') {
            $transaction->invoice->update(['status' => 'paid']);
        }

        return redirect()->route('transactions.index');
    }

    public function update(Request $request, Transaction $transaction)
    {
        $validated = $request->validate([
            'invoice_id' => 'required|exists:invoices,id',
            'customer_id' => 'required|exists:customers,id',
            'amount' => 'required|numeric|min:0',
            'payment_method' => 'required|in:credit_card,paypal,bank_transfer,cash',
            'status' => 'required|in:pending,completed,failed,refunded',
            'notes' => 'nullable|string'
        ]);

        $transaction->update($validated);

        // Update invoice status if payment completed
        if ($validated['status'] === 'completed') {
            $transaction->invoice->update(['status' => 'paid']);
        }

        return redirect()->route('transactions.index');
    }

    public function destroy(Transaction $transaction)
    {
        $transaction->delete();
        return redirect()->route('transactions.index');
    }
}
