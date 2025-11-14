<div class="mb-4">
    <label>{{$label}}:</label><br/>
    <textarea
        name="{{$name}}"
        rows="{{$rows}}"
        placeholder="{{$placeholder}}"
        class="w-full border @error($name) border-red-500 @else border-black @enderror"
    >{{old($name,$value)}}</textarea>
    @error($name)
    <div class="text-red-500">{{$message}}</div>
    @enderror
</div>
