<?php

// app/Http/Controllers/InvoiceController.php
namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Customer;
use Illuminate\Http\Request;
use Inertia\Inertia;

class InvoiceController extends Controller
{
    public function index()
    {
        return Inertia::render('Invoice', [
            'invoices' => Invoice::with('customer')->latest()->get(),
            'customers' => Customer::all(),
            'editingInvoice' => null
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'issue_date' => 'required|date',
            'due_date' => 'required|date|after:issue_date',
            'amount' => 'required|numeric|min:0',
            'tax' => 'required|numeric|min:0',
            'status' => 'required|in:draft,sent,paid,overdue,cancelled',
            'notes' => 'nullable|string'
        ]);

        Invoice::create($validated);

        return redirect()->route('invoices.index');
    }

    public function update(Request $request, Invoice $invoice)
    {
        $validated = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'issue_date' => 'required|date',
            'due_date' => 'required|date|after:issue_date',
            'amount' => 'required|numeric|min:0',
            'tax' => 'required|numeric|min:0',
            'status' => 'required|in:draft,sent,paid,overdue,cancelled',
            'notes' => 'nullable|string'
        ]);

        $invoice->update($validated);

        return redirect()->route('invoices.index');
    }

    public function destroy(Invoice $invoice)
    {
        $invoice->delete();
        return redirect()->route('invoices.index');
    }

    public function send(Invoice $invoice)
    {
        // Implement email sending logic here
        $invoice->update(['status' => 'sent']);
        return back()->with('success', 'Invoice sent successfully');
    }
}
