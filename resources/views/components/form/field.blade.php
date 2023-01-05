<div class="field">
    <label for="{{$prop}}" class="label">{{$title}}</label>
    <div class="control">
        {{$slot}}
    </div>
    @error($prop)
    <p class="help is-danger">
        {{$message}}
    </p>
    @enderror
</div>
