<div class="mb-4">
    @include('components.form_label')
    <textarea
        name="{{$name}}"
        rows="{{$rows}}"
        placeholder="{{$placeholder}}"
        class="w-full border @error($name) border-red-500 @else border-black @enderror"
    >{{old($name,$value)}}</textarea>
    @include('components.form_error')
</div>
