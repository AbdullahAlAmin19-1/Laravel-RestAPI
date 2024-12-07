<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Roles') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-12">

                                @if (session('status'))
                                <div class="alert alert-success">{{ session('status') }}</div>
                                @endif

                                <div class="card">
                                    <div class="card-header">
                                        <h4>Role : {{ $role->name }}
                                            <a href="{{ url('roles') }}" class="btn btn-danger float-end">Back</a>
                                        </h4>
                                    </div>
                                    <div class="card-body">

                                        <form action="{{ url('roles/'.$role->id.'/give-permissions') }}" method="POST">
                                            @csrf
                                            @method('PUT')

                                            <div class="mb-3">
                                                @error('permission')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror

                                                <label for="">Permissions</label>

                                                <div class="row">
                                                    @foreach ($permissions as $permission)
                                                    <div class="col-md-2">
                                                        <label>
                                                            <input type="checkbox" name="permission[]" value="{{ $permission->name }}" {{ in_array($permission->id, $rolePermissions) ? 'checked':'' }} />
                                                            {{ $permission->name }}
                                                        </label>
                                                    </div>
                                                    @endforeach
                                                </div>

                                            </div>
                                            <div class="mb-3">
                                                <button type="submit" class="btn btn-primary">Update</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


</x-app-layout>
