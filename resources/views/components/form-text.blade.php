<div class="mb-4">
    @include('components.form_label')
    <input
        type="text"
        name="{{$name}}"
        placeholder="{{$placeholder}}"
        value="{{old($name,$value)}}"
        class="w-full border @error($name) border-red-500 @else border-black @enderror"
    >
    @include('components.form_error')
</div>
