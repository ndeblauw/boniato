<label>{{$label}}:</label>
<input
    type="text"
    name="{{$name}}"
    placeholder="{{$placeholder}}"
    value="{{old('name',$value)}}"
    class="border @error($name) border-red-500 @else border-black @enderror"
>
@error($name)
<div class="text-red-500">{{$message}}</div>
@enderror
