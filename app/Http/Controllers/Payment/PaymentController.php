<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Payment;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class PaymentController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();

        $query = Payment::with('user')->latest();

        if (!$user->hasRole('Super Admin')) {
            $query->where('user_id', $user->id);
        }

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('amount', 'like', "%{$search}%")
                    ->orWhere('note', 'like', "%{$search}%")
                    ->orWhereDate('payment_date', $search);
            });
        }

        return $query->paginate(10);
    }

    public function store(Request $request)
    {
        $request->validate([
            'amount'       => 'required|numeric|min:0',
            'payment_date' => 'required|date',
            'note'         => 'nullable|string',
            'receipt'      => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $path = null;

        if ($request->hasFile('receipt')) {
            $path = $request->file('receipt')->store('payments', 'public');
        }

        $payment = Payment::create([
            'user_id'      => auth()->id(),
            'amount'       => $request->amount,
            'payment_date' => $request->payment_date,
            'note'         => $request->note,
            'receipt'      => $path,
            'status'       => 'pending',
        ]);

        return response()->json($payment, 201);
    }

    public function show($id)
    {
        $payment = Payment::with('user')->findOrFail($id);
        return response()->json($payment);
    }

    public function update(Request $request, Payment $payment)
    {
        $user = $request->user();

        if (!$user->can('payment-edit') && $payment->user_id !== $user->id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        if ($payment->status !== 'pending') {
            return response()->json(['message' => 'Only pending payments can be edited'], 422);
        }

        $validator = Validator::make($request->all(), [
            'amount'       => 'required|numeric|min:0',
            'payment_date' => 'required|date',
            'note'         => 'nullable|string',
            'receipt'      => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        if ($request->hasFile('receipt')) {
            if ($payment->receipt) {
                Storage::disk('public')->delete($payment->receipt);
            }

            $payment->receipt = $request->file('receipt')
                ->store('payments', 'public');
        }

        $payment->amount = $request->amount;
        $payment->payment_date = $request->payment_date;
        $payment->note = $request->note;
        $payment->save();

        return response()->json([
            'message' => 'Payment updated successfully',
            'data' => $payment
        ]);
    }

    public function destroy(Payment $payment)
    {
        $user = auth()->user();

        if (!$user->can('payment-delete') && $payment->user_id !== $user->id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $payment->delete();

        return response()->json([
            'message' => 'Delete Successfully!',
        ]);
    }

    public function approve(Payment $payment)
    {
        if (!auth()->user()->hasRole('Super Admin')) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        if ($payment->status !== 'pending') {
            return response()->json(['message' => 'Only pending payments can be approved'], 422);
        }

        $payment->update(['status' => 'approved']);

        return response()->json([
            'message' => 'Payment Approved Successfully',
            'data' => $payment
        ]);
    }

    public function reject(Payment $payment)
    {
        if (!auth()->user()->hasRole('Super Admin')) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        if ($payment->status !== 'pending') {
            return response()->json(['message' => 'Only pending payments can be rejected'], 422);
        }

        $payment->update(['status' => 'rejected']);

        return response()->json([
            'message' => 'Payment Rejected Successfully',
            'data' => $payment
        ]);
    }
}
