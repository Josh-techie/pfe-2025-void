<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Customer::query();

        // Filtering
        foreach ($request->get('filter', []) as $field => $value) {
            $query->where($field, 'LIKE', '%' . $value . '%');
        }

        // Sorting
        foreach ($request->get('sort', []) as $field => $direction) {
            $query->orderBy($field, $direction);
        }

        // Pagination
        $perPage = $request->get('page.size', 10); // Default page size is 10
        $pageNumber = $request->get('page.number', 1);
        $customers = $query->paginate($perPage, ['*'], 'page', $pageNumber);

        // Add custom header
        return response()->json($customers)->header('X-API-Version', 'v1');
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the request data
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:customers',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Create a new customer
        $customer = Customer::create($request->all());

        // Return the new customer with a 201 Created status code
        return response()->json($customer, 201)->header('X-API-Version', 'v1');
    }

    /**
     * Display the specified resource.
     */
    public function show(Customer $customer)
    {
        // Add custom header
        return response()->json($customer)->header('X-API-Version', 'v1');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Customer $customer)
    {
        // Validate the request data
        $validator = Validator::make($request->all(), [
            'name' => 'string|max:255',
            'email' => 'email|unique:customers,email,' . $customer->id,
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Update the customer
        $customer->update($request->all());

        // Return the updated customer
        return response()->json($customer)->header('X-API-Version', 'v1');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Customer $customer)
    {
        // Delete the customer
        $customer->delete();

        // Return a 204 No Content status code
        return response()->json(null, 204)->header('X-API-Version', 'v1');
    }
}
