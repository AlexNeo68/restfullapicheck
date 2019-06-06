@component('mail::message')
# Hello, {{ $user->name }}

Thanks for create account, please verify your email

@component('mail::button', ['url' => route('verify', $user->verification_token)])
Verify
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
