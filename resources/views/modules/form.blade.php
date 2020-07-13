@php
    $form = \App\Form::find($id);
    $fields = json_decode($form->fields);
@endphp

@if($form->status==='Live')
<div class="w-full mx-auto max-w-xl">

    @if ($errors->any())
    <div style="background-color:#fff5f5; color:#e53e3e; border: 1px solid #e53e3e;" class="p-4 rounded-lg my-4 wt-form-errors">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form method="post" action="{{ '/api/forms/' . $form->id . '/response' }}" class="w-full">
        @csrf
        <div class="text-lg wt-form-header">{{ $form->name }}</div>
        <div class="py-3 wt-form-desc">{{ $form->description }}</div>

        @foreach($fields as $field)
        <div class="w-full mt-4 wt-form-fields">
            @unless($field->type === 'checkbox')
            <label class="w-full font-semibold wt-form-field-label">{{ ucfirst($field->name) }}</label>
            <div class="text-sm text-gray-600 wt-form-field-desc">{{ $field->desc}}</div>
            @endunless
            @switch($field->type)
                @case('text')
                    <input name="{{$field->name}}" type="text" class="mt-2 w-full px-2 py-1 border rounded wt-form-input" placeholder="{{ $field->placeholder }}">
                @break
                @case('email')
                    <input name="{{$field->name}}" type="email" class="mt-2 w-full px-2 py-1 border rounded wt-form-input" placeholder="{{ $field->placeholder }}">
                @break
                @case('textbox')
                    <textarea name="{{$field->name}}" class="mt-2 w-full px-2 py-1 border rounded wt-form-input" placeholder="{{ $field->placeholder }}"></textarea>
                @break
                @case('radio')
                <div class="my-2 wt-form-input">
                    @foreach($field->options as $option)
                    <div class="mr-2">
                        <input type="radio" name="{{$field->name}}" value="{{ $option }}" id="{{$field->name . '_' . $loop->iteration}}">
                        <label for="{{$field->name . '_' . $loop->iteration}}">{{$option}}</label>
                    </div>
                    @endforeach
                </div>
                @break
                @case('select')
                    <select name="{{$field->name}}" class="mt-2 w-full px-2 py-1 border rounded wt-form-input" placeholder="{{ $field->placeholder }}">
                        <option disabled>Select an option</option>
                        @foreach($field->options as $option)
                        <option value="{{ $option}}">{{$option }}</option>
                        @endforeach
                    </select>
                @break
                @case('multi')
                    <select name="{{$field->name}}" class="mt-2 w-full px-2 py-1 border rounded wt-form-input" placeholder="{{ $field->placeholder }}" multiple>
                        <option disabled>Select one or more options</option>
                        @foreach($field->options as $option)
                        <option value="{{ $option}}">{{$option }}</option>
                        @endforeach
                    </select>
                @break
                @case('checkbox')
                    <div class="flex mt-2 wt-form-input">
                        <input name="{{$field->name}}" type="checkbox" class="px-2 py-1 mr-3" value="true">
                        <label for="{{ $field->name }}">{{ $field->desc}}</label>
                    </div>
                @break
            @endswitch
        </div>
        @endforeach

        <button type="submit" class="mt-4 px-4 py-2 bg-orange-600 text-white rounded wt-form-button">Submit</button>
    </form>
</div>
@endif