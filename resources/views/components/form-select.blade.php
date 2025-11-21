<div class="mb-4">
    @include('components.form_label')
    <select name="{{$name}}">
        @foreach ($options as $key => $option)
            <option value="{{ $key }}" {{ old($name, $value) == $key ? 'selected' : '' }} >{{ $option }}</option>
        @endforeach
    </select>
    @include('components.form_error')
</div>
