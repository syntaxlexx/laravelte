<?php

namespace App\Actions\Frontend;

use App\Events\ContactFormWasFilled;
use App\Models\ContactMessage;
use App\Traits\CustomControllerResponsesTrait;
use App\Traits\ThemesTrait;
use Illuminate\Http\Request;
use Lorisleiva\Actions\Concerns\AsAction;
use Stevebauman\Location\Facades\Location;

class Contact
{
    use AsAction;
    use ThemesTrait;
    use CustomControllerResponsesTrait;

    public function asController(Request $request)
    {
        if($request->isMethod('get')) {
            $data = [
                'country' => 'United Kingdom',
            ];

            if ($position = Location::get()) {
                $data = [
                    'country' => $position->countryName,
                ];
            }

            return $this->generatePage('contact', 'Contact', $data);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20|min:10|required_without:email',
            'subject' => 'required|string|max:255',
            'body' => 'required|string|max:10000',
        ], [
            'name.required' => 'Please provide your name(s)',
        ]);

        $resp = ContactMessage::create([
            'user_id' => doe() ? doe()->id : null,
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'subject' => $request->subject,
            'body' => $request->body,
            'site_domain' => sanitizeDomainUrl(),
            'ip_address' => $request->ip(),
        ]);

        event(new ContactFormWasFilled($resp));

        return $request->wantsJson()
            ? $this->respJuicer($resp, "We have received your message. We shall get in touch soon.")
            : back()->with('success', "We have received your message. We shall get in touch soon.");

    }
}
