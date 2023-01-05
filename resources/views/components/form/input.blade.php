<x-form.field :$prop :$title>
    <input type="{{$type}}" name="{{$prop}}" id="{{$prop}}" value="{{$value ?? old($prop)}}"
           class="input @error($prop) is-danger @enderror">
</x-form.field>
