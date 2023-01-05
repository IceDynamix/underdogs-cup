<x-form.field :$prop :$title>
    <textarea name="{{$prop}}" id="{{$prop}}" class="textarea @error($prop) is-danger @enderror"
              placeholder="{{$placeholder}}" content="{{$value ?? old($prop)}}"></textarea>
</x-form.field>
