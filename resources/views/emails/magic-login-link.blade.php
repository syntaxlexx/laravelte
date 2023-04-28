<x-mail::message>
# Hello

To finish logging in please click the link below

<x-mail::button :url="$url">
Click to login
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
