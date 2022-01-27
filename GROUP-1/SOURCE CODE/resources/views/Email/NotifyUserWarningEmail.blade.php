@component('mail::message')
# {{ $mailData['title'] }}

This is email is to bring to your attention that you have been reported for {{ $mailData['category'] }} in our website. A review of a report indicates that you have been performing undesirable actions in our website that is against our Terms of Services. Administrators and moderators can ban your account if deemed necessary. For now, you can still access your account as normal. However, To avoid termination of your account, please refrain from doing any undesirable activities that is against our terms of services.

@component('mail::button', ['url' => $mailData['url']])
Home
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
