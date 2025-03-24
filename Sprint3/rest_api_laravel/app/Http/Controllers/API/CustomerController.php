<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\CustomerResource;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CustomerController extends Controller
{
    // Let's create our index function: get all records of customers in our db
    public function index()
    {

        $customers = Customer::get();

        if ($customers->count() > 0) {
            return CustomerResource::collection($customers);
        } else {
            return response()->json(['message' => 'No record available'], 200);
        }
    }

    // store function to create a new customer
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'All fields are mandatory',
                'errors' => $validator->messages(),
            ], 422);
        }

        // Insert the record into the model AND get the created customer object
        $customer = Customer::create([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        // return what we want in the endpoint hence why created the resource
        return response()->json(['message' => 'Customer Created SUCCESSFULLY', 'data' => new CustomerResource($customer)], 201); // Corrected: Passing the $customer object
    }

    // show fuunction to retrieve a customer
    public function show(Customer $customer)
    {
        return new CustomerResource($customer);
    }

    // update function to update an existing customer
    public function update(Request $request, Customer $customer)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'All fields are mandatory',
                'errors' => $validator->messages(),
            ], 422);
        }

        // Insert the record into the model AND get the created customer object
        $customer->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        // return what we want in the endpoint hence why created the resource
        return response()->json(['message' => 'Customer Updated SUCCESSFULLY', 'data' => new CustomerResource($customer)], 200); // Corrected: Passing the $customer object

    }

    // destroy function to delete a customer from our db
    public function destroy(Customer $customer)
    {
        $customer->delete();
        return response()->json(['message' => 'Customer Deleted Successfully'], 200);
    }

}
