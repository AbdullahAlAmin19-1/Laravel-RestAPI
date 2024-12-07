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

                                @if ($errors->any())
                                <ul class="alert alert-warning">
                                    @foreach ($errors->all() as $error)
                                    <li>{{$error}}</li>
                                    @endforeach
                                </ul>
                                @endif

                                <div class="card">
                                    <div class="card-header">
                                        <h4>Create Role
                                            <a href="{{ url('roles') }}" class="btn btn-danger float-end">Back</a>
                                        </h4>
                                    </div>
                                    <div class="card-body">
                                        <form action="{{ url('roles') }}" method="POST">
                                            @csrf

                                            <div class="mb-3">
                                                <label for="">Role Name</label>
                                                <input type="text" name="name" class="form-control" />
                                            </div>
                                            <div class="mb-3">
                                                <button type="submit" class="btn btn-primary">Save</button>
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
