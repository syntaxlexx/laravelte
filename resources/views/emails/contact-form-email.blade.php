@component('mail::message')

# Hi, {{ $contactMessage->name }},

We have received your message successfully.

## Your Message
{{ $contactMessage->body }}

@component('mail::panel')
# Details

Subject : **{{ $contactMessage->subject }}** <br/>
@endcomponent

We will get to you soon.
Thank you.

@isset($actionText)
@component('mail::subcopy')
If you're having trouble clicking the "{{ $actionText }}" button, copy and paste the URL below
into your web browser: [{{ $actionUrl }}]({{ $actionUrl }}).

Should you have any queries, please contact the administrator.
@endcomponent
@endisset

@endcomponent
