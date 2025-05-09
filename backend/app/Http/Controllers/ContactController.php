<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactRequest;
use App\Http\Resources\ContactResource;
use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index()
    {
        $contacts = Contact::orderBy('created_at', 'desc')->get();
        return ContactResource::collection($contacts);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ContactRequest $request)
    {
        $contact = Contact::create($request->validated());
        return new ContactResource($contact);
    }

    /**
     * Display the specified resource.
     */
    public function show(Contact $contact)
    {
        return new ContactResource($contact);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ContactRequest $request, Contact $contact)
    {
        $contact->update($request->validated());
        return new ContactResource($contact);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Contact $contact)
    {
        $contact->delete();
        return response()->json([
            'message' => 'Contact deleted successfully'
        ], 200);
    }
}
