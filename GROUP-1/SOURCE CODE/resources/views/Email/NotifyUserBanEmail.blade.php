@component('mail::message')
# {{ $mailData['title'] }}

We are sorry to notify you that the administrators at e-barter.co has decided to ban you for some unfortunate reasons.
Click the button below if you want to send an appeal.

@component('mail::button', ['url' => $mailData['url']])
Appeal
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
