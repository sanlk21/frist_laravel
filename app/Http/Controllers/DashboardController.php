<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Invoice;
use App\Models\Proposal;
use App\Models\Transaction;
use Inertia\Inertia;

class DashboardController extends Controller
{
    /**
     * Display the dashboard with statistics
     */
    public function index()
    {
        return Inertia::render('Dashboard', [
            'stats' => [
                'customers' => Customer::count(),
                'proposals' => Proposal::count(),
                'invoices' => Invoice::count(),
                'revenue' => Transaction::where('status', 'completed')->sum('amount'),
            ],
            'recentCustomers' => Customer::latest()->take(5)->get(),
            'recentInvoices' => Invoice::with('customer')->latest()->take(5)->get(),
        ]);
    }
}
