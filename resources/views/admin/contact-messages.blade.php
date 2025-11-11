@extends('layouts.admin')
@section('title', 'Contact Requests')

@section('content')
    @include('admin.partials.page-header', [
        'title' => 'Contact Requests',
        'icon' => 'bx bxs-message-dots'
    ])

    <div class="container-fluid">
        {{-- Filters --}}
        <div class="card p-3 mb-4">
            <div class="row g-2">
                <div class="col-md-4">
                    <input type="text" class="form-control" placeholder="Search by Name or Email">
                </div>
                <div class="col-md-2">
                    <select class="form-control">
                        <option value="">All Status</option>
                        <option>New</option>
                        <option>In Progress</option>
                        <option>Resolved</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <input type="date" class="form-control">
                </div>
                <div class="col-md-1">
                    <button class="btn btn-primary w-100"><i class='bx bx-search'></i></button>
                </div>
            </div>
        </div>

        {{-- Messages Table --}}
        <div class="card">
            <div class="table-responsive">
                <table class="table table-hover align-middle text-center table-bordered">
                    <thead class="thead-light">
                        <tr class="bg-light text-dark">
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Subject</th>
                            <th>Message</th>
                            <th>Received</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($messages as $message)
                            <tr>
                                <td>#{{ $message->id }}</td>
                                <td>{{ $message->name }}</td>
                                <td>{{ $message->email }}</td>
                                <td>{{ Str::limit($message->subject, 30) }}</td>
                                <td class="text-left">{{ Str::limit($message->message, 40) }}</td>
                                <td>{{ $message->created_at->format('d M, Y') }}</td>
                                <td>
                                    <button class="btn btn-sm btn-outline-info"><i class='bx bx-show'></i></button>
                                    <button class="btn btn-sm btn-outline-danger"><i class='bx bx-trash'></i></button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted py-5">
                                    <i class='bx bx-message-x' style="font-size: 3rem;"></i>
                                    <p class="mt-2">No contact messages found</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
