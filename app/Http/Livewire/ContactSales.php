<?php

namespace App\Http\Livewire;

use App\Models\Contact;
use App\Models\Messages;
use Livewire\Component;
use Propaganistas\LaravelPhone\PhoneNumber;

class ContactSales extends Component
{
    public $first_name = '';
    public $last_name = '';
    public $email = '';
    public $phone = '';
    public $code = '';
    public $subject = '';
    public $message = '';
    public $company_name = '';

    public function rules(): array
    {
        return [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['required', 'phone:' . $this->code],
            'code' => ['required', 'string', 'size:2'],
            'subject' => ['required', 'string', 'max:255'],
            'message' => ['required', 'string'],
            'company_name' => ['required', 'string','max:255'],
        ];
    }

    public function messages(): array
    {
        return [
            'first_name.required' => __('First name is required'),
            'last_name.required' => __('Last name is required'),
            'email.required' => __('Email address is required'),
            'email.email' => __('Please enter a valid email address'),
            'phone.required' => __('Phone number is required'),
            'phone.phone' => __('Invalid phone number'),
            'code.required' => __('Please select a valid country code'),
            'subject.required' => __('Subject is required'),
            'message.required' => __('Message is required'),
            'company_name.required' => __('Company name is required'),
        ];
    }

    public function handleSubmit()
    {
        dd($this->phone,$this->code);
        $validated = $this->validate();

        $formattedPhone = PhoneNumber::make(
            $validated['phone'],
            $validated['code']
        )->formatE164();

        dd($formattedPhone);

        $contact = Contact::firstOrCreate(
            [
                'email' => $validated['email'],
            ],
            [
                'first_name' => $validated['first_name'],
                'last_name' => $validated['last_name'],
                'mobile' => $formattedPhone,
            ]
        );

        Messages::create([
            'contact_id' => $contact->id,
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'mobile' => $formattedPhone,
            'email' => $validated['email'],
            'subject' => $validated['subject'],
            'message' => $validated['message'],
        ]);

        $this->reset([
            'first_name',
            'last_name',
            'email',
            'phone',
            'subject',
            'message',
        ]);
        return $this->emit('success', __('Message was successfully sent!'));
    }


    public function render()
    {
        return view('livewire.contact-sales');
    }
}
