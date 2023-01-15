<x-layout>
    <x-slot:title>Add Blacklist | Admin</x-slot:title>
    <div class="container">
        <div class="content">
            <h1>Add new blacklist entry</h1>

            <form action="{{route('admin.blacklist.store')}}" method="POST">
                @csrf

                {{LaraForm::text('tetrio_id','Tetrio user ID', old('tetrio_id'))}}
                {{LaraForm::datetimeLocal('until','Blacklisted until (leave blank for indefinite)', old('until'))}}
                {{LaraForm::text('reason','Reason', old('reason'))}}

                <button class="button is-success" type="submit">
                    Create
                </button>
            </form>
        </div>
    </div>
</x-layout>
