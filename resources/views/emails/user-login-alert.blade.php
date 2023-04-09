@component('mail::message')

# Login Alert at {{ config('app.name') }}

Someone just logged in to your account.
If you **do not** recognize this activity, please follow this link to recover your account.

@component('mail::button', ['url' => $actionUrl ])
{{ $actionText }}
@endcomponent

Support,
{{ config('app.name') }}

{{-- Subcopy --}}
@isset($actionText)
@component('mail::subcopy')
If you're having trouble clicking the "{{ $actionText }}" button, copy and paste the URL below
into your web browser: [{{ $actionUrl }}]({{ $actionUrl }})
@endcomponent
@endisset

@endcomponent
