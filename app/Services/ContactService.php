<?php 
namespace App\Services;

use App\Models\Contact;
use App\Http\Resources\API\ContactResource;
class ContactService{
    public function storeContact(array $data)
    {
        $contact = Contact::create($data);
        return [
            'status' => true,
            'message' => __('messages.contact_created_successfully'),
            'data' => new ContactResource($contact)
        ];
    }
}