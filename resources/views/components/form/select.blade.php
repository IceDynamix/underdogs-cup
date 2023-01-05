<x-form.field :$prop :$title>
    <div class="select @error($prop) is-danger @enderror">
        <select name="{{$prop}}" id="{{$prop}}">
            @foreach($items as $item)
                <option
                    value="{{$item->value}}"
                    @if($item == old($prop) ?? !empty($selected) && $item == $selected)
                        selected
                    @endif
                >
                    {{$item->name}}</option>
            @endforeach
        </select>
    </div>
</x-form.field>
