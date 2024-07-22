<x-mail::message>
# Shortened URL
 
Hi,
Click the button to visit the shortened page({{ $trimmedUrl }}).
 
<x-mail::button :url="$url">
{{ $trimmedUrl }}
</x-mail::button>
 
Thanks,<br>
{{ config('app.name') }}
</x-mail::message>