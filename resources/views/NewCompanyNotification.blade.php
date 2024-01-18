<x-mail::message>
# A new company has been created

##Name: {{$company->name}}
##Email: {{$company->email}}
##Phone: {{$company->phone}}

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
