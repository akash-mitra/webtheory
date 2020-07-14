@extends('emails.layout')


@section('body')

<div style="font-size: 18px; font-weight: bold; padding: 10px 0;">
    Hello Admin
</div>

<div style="padding: 10px 0; font-size: 14px;">
    <p>
        There is a form response. Below are the details:
    </p>

    <p>
        Response #: {{ $formResponse->id }}
    </p>

    <?php 
        $formFields = json_decode($formResponse->form->fields);
        $responses = json_decode($formResponse->responses);
    ?>

    @foreach($formFields as $field)
        <p>
            {{ $field->name }}: {{ $responses->{"$field->name"} }}
        </p>
    @endforeach

    <p>
        Receive Timestamp: {{ $formResponse->created_at }}
    </p>
    <p>
        From IP: {{ $formResponse->ip }}
    </p>
</div>

@endsection