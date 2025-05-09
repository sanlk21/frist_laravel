<?php

namespace App\Http\Controllers;

use App\Models\Proposal;
use App\Models\Customer;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProposalController extends Controller
{
    public function index()
    {
        return Inertia::render('Proposal', [
            'proposals' => Proposal::with('customer')->latest()->get(),
            'customers' => Customer::all(),
            'editingProposal' => null
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'amount' => 'required|numeric|min:0',
            'proposal_date' => 'required|date',
            'expiry_date' => 'required|date|after:proposal_date',
            'status' => 'required|in:draft,sent,accepted,rejected'
        ]);

        Proposal::create($validated);

        return redirect()->route('proposals.index');
    }

    public function update(Request $request, Proposal $proposal)
    {
        $validated = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'amount' => 'required|numeric|min:0',
            'proposal_date' => 'required|date',
            'expiry_date' => 'required|date|after:proposal_date',
            'status' => 'required|in:draft,sent,accepted,rejected'
        ]);

        $proposal->update($validated);

        return redirect()->route('proposals.index');
    }

    public function destroy(Proposal $proposal)
    {
        $proposal->delete();
        return redirect()->route('proposals.index');
    }
}
