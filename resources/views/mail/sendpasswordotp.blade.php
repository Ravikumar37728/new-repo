@component('mail::message')
Forgot Password

The Otp For Reset Password

@component('mail::button', ['url' => ''])
{{$details['otp']}}
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
