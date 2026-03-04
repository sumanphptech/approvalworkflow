@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">Approval Requests</h1>

    @if($requests->isEmpty())
        <p>No requests found.</p>
    @else
        <table class="min-w-full border border-gray-300">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-4 py-2 border">ID</th>
                    <th class="px-4 py-2 border">Title</th>
                    <th class="px-4 py-2 border">Submitted By</th>
                    <th class="px-4 py-2 border">Status</th>
                    <th class="px-4 py-2 border">Approved By</th>
                    <th class="px-4 py-2 border">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($requests as $request)
                    <tr>
                        <td class="px-4 py-2 border">{{ $loop->iteration }}</td>
                        <td class="px-4 py-2 border">{{ $request->title }}</td>
                        <td class="px-4 py-2 border">{{ $request->user->name }}</td>
                        <td class="px-4 py-2 border capitalize">{{ $request->status }}</td>
                        <td class="px-4 py-2 border">
                            {{ $request->approver?->name ?? '-' }}
                        </td>
                        <td class="px-4 py-2 border">
                            @if(auth()->user()->role->name === 'APPROVER' && $request->status === 'pending')
                                <form action="{{ url("/requests/{$request->id}/approve") }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="bg-green-600 text-white px-2 py-1 rounded hover:bg-green-700">Approve</button>
                                </form>

                                <form action="{{ url("/requests/{$request->id}/reject") }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="bg-red-600 text-white px-2 py-1 rounded hover:bg-red-700">Reject</button>
                                </form>
                            @else
                                -
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection