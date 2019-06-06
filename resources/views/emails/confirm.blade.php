@component('mail::message')
# Hello, {{ $user->name }}

Your changed email, please confirm it

@component('mail::button', ['url' => route('verify', $user->verification_token)])
Confirm
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
