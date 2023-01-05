<div class="field">
    <label for="{{$prop}}" class="label">
        <input type="checkbox" name="{{$prop}}" id="{{$prop}}" value="{{old($prop) ?? $value}}">
        {{$title}}
    </label>
    @error($prop)
    <p class="help is-danger">
        {{$message}}
    </p>
    @enderror
</div>
