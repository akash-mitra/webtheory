@push('styles')
<style>
    .grecaptcha-badge { visibility: hidden; }
</style>
@endpush

@php
    $form = \App\Form::find($id);
    $fields = json_decode(optional($form)->fields);
    $captcha_key = json_decode(\App\Parameter::getKey('captcha_service'));
@endphp

@if($form->captcha && $form->status==='Live')
    @push('post-scripts')
    <script src="https://www.google.com/recaptcha/api.js?render={{$captcha_key->site_key}}"></script>
    <script>
    function submit_form_{{$form->id}}(e)
    {
        e.preventDefault();
        grecaptcha.ready(function() {
            grecaptcha.execute("{{$captcha_key->site_key}}", {action: 'submit'}).then(function(token) {
                document.getElementById('wt_recaptcha_token').value = token
                document.getElementById('{{"form_".$form->id}}').submit()
            });
        });

    }
    </script>
    @endpush
@endif


@if(!empty($form) && $form->status==='Live')
<div class="w-full mx-auto">

    @if ($errors->any())
    <div style="background-color:#fff5f5; color:#e53e3e; border: 1px solid #e53e3e;" class="p-4 rounded-lg my-4 w-full wt-form-errors">
        Please correct the errors below and resubmit.
    </div>
    @endif

    @if (session()->has('success'))
    <div style="background-color:#F0FFF4; color:#48BB78; border: 1px solid #48BB78;" class="p-4 rounded-lg my-4 w-full wt-form-success">
        Your data has been saved successfully.
    </div>
    @else

        <form method="post" action="{{ '/api/forms/' . $form->id . '/response' }}" class="w-full" id="{{'form_'.$form->id}}">
            @csrf

            <input type="hidden" name="wt_recaptcha_token" value="" id="wt_recaptcha_token">
            <div class="text-2xl wt-form-header">{{ $form->name }}</div>
            <div class="py-3 wt-form-desc border-b">{{ $form->description }}</div>

            @foreach($fields as $field)
            <div class="w-full mt-4 wt-form-fields">

                @unless($field->type === 'checkbox')
                <label class="w-full font-semibold wt-form-field-label">{{ ucfirst($field->name) }}</label>
                <div class="text-sm text-gray-600 wt-form-field-desc">{{ optional($field)->desc}}</div>
                @endunless

                @switch($field->type)
                    @case('text')
                        <input value="{{ old($field->name) }}" name="{{$field->name}}" type="text" class="mt-2 w-full px-2 py-1 border rounded wt-form-input" placeholder="{{ optional($field)->placeholder }}">
                    @break

                    @case('email')
                        <input value="{{ old($field->name) }}" name="{{$field->name}}" type="email" class="mt-2 w-full px-2 py-1 border rounded wt-form-input" placeholder="{{ optional($field)->placeholder }}">
                    @break

                    @case('textbox')
                        <textarea name="{{ $field->name }}" class="mt-2 w-full px-2 py-1 border rounded wt-form-input" placeholder="{{ optional($field)->placeholder }}"></textarea>
                    @break

                    @case('radio')
                    <div class="my-2 wt-form-input">
                        @foreach($field->options as $option)
                        <div class="mr-2">
                            <input type="radio" name="{{$field->name}}" value="{{ $option }}" id="{{$field->name . '_' . $loop->iteration}}" @if(old($field->name) === $option) checked @endif>
                            <label for="{{$field->name . '_' . $loop->iteration}}">{{$option}}</label>
                        </div>
                        @endforeach
                    </div>
                    @break
                    @case('select')
                        <select name="{{$field->name}}" value="{{ old($field->name) }}" class="mt-2 w-full px-2 py-1 border rounded wt-form-input" placeholder="{{ optional($field)->placeholder }}">
                            <option disabled>Select an option</option>
                            @foreach($field->options as $option)
                            <option value="{{ $option}}">{{$option }}</option>
                            @endforeach
                        </select>
                    @break
                    @case('multiselect')
                        <select name="{{$field->name}}" value="{{ old($field->name) }}" class="mt-2 w-full px-2 py-1 border rounded wt-form-input" placeholder="{{ optional($field)->placeholder }}" multiple>
                            <option disabled>Select one or more options</option>
                            @foreach($field->options as $option)
                            <option value="{{ $option}}">{{$option }}</option>
                            @endforeach
                        </select>
                    @break
                    @case('checkbox')
                        <div class="flex mt-2 wt-form-input">
                            <input name="{{$field->name}}" type="checkbox" class="px-2 py-1 mr-3" {!! $field->default ? ' checked' : '' !!}>
                            <label for="{{ $field->name }}">{{ optional($field)->desc}}</label>
                        </div>
                    @break
                @endswitch

                @error($field->name)
                    <div style="color:#e53e3e;" class="text-xs py-1">{{ $message }}</div>
                @enderror
            </div>
            @endforeach

            @if($form->captcha)
                <div class="text-xs pt-4 pb-2 text-gray-400">
                    This site is protected by reCAPTCHA and the Google
                    <a class="text-blue-600 underline" href="https://policies.google.com/privacy">Privacy Policy</a> and
                    <a class="text-blue-600 underline" href="https://policies.google.com/terms">Terms of Service</a> apply.
                </div>
                <button onclick="submit_form_{{$form->id}}(event)" type="button" class="mt-2 px-4 py-2 bg-{{$data->ref->template->primaryColor}}-600 text-white rounded wt-form-button">Submit</button>
            @else
                <button type="submit" class="mt-4 px-4 py-2 bg-{{$data->ref->template->primaryColor}}-600 text-white rounded wt-form-button">Submit</button>
            @endif
        </form>
    @endif
</div>

@endif
