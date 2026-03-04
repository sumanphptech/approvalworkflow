@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white shadow sm:rounded-lg p-6">

            <h1 class="text-2xl font-bold mb-6">Submit a New Approval Request</h1>

            @if(session('success'))
                <div class="bg-green-100 text-green-800 p-3 mb-4 rounded">
                    {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div class="bg-red-100 text-red-800 p-3 mb-4 rounded">
                    <ul class="list-disc list-inside">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ url('/requests') }}" method="POST" class="space-y-4">
                @csrf

                <div>
                    <label for="title" class="block mb-1 font-medium">Title</label>
                    <input type="text" name="title" id="title"
                           class="border rounded w-full p-2 focus:ring focus:ring-blue-300"
                           value="{{ old('title') }}" required>
                </div>

                <button type="submit"
                        class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                    Submit Request
                </button>
                
            </form>

        </div>
    </div>
</div>
@endsection