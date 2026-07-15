@extends('layouts.app')

@section('page-title', 'CRM Dropdown Options')

@section('content')
<div class="row">
    {{-- Tab for selecting CRM Type --}}
    <div class="col-12 mb-3">
        <ul class="nav nav-pills">
            @foreach($crmTypes as $key => $label)
                <li class="nav-item">
                    <a class="nav-link {{ $currentCrmType === $key ? 'active fw-bold' : '' }}" 
                       href="{{ route('crm-options.index', ['crm_type' => $key]) }}">
                        {{ $label }}
                    </a>
                </li>
            @endforeach
        </ul>
    </div>

    {{-- Sidebar for selecting the type --}}
    <div class="col-md-3 mb-4">
        <div class="card-box h-100">
            <h6 class="fw-bold mb-3">Option Fields</h6>
            <div class="list-group list-group-flush">
                @foreach($types as $key => $label)
                    <a href="{{ route('crm-options.index', ['crm_type' => $currentCrmType, 'type' => $key]) }}"
                       class="list-group-item list-group-item-action {{ $currentType === $key ? 'active fw-bold' : '' }}">
                       {{ $label }}
                    </a>
                @endforeach
            </div>
        </div>
    </div>

    {{-- Main content for managing the selected type --}}
    <div class="col-md-9">
        <div class="card-box mb-4">
            <h5 class="fw-bold mb-3">Manage: {{ $crmTypes[$currentCrmType] }} - {{ $types[$currentType] }}</h5>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach($errors->all() as $e)
                            <li>{{ $e }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('crm-options.store') }}" method="POST" class="d-flex gap-2">
                @csrf
                <input type="hidden" name="crm_type" value="{{ $currentCrmType }}">
                <input type="hidden" name="type" value="{{ $currentType }}">
                <input type="text" name="name" class="form-control" placeholder="Enter new {{ strtolower($types[$currentType]) }} option..." required>
                <button type="submit" class="btn btn-primary px-4">Add</button>
            </form>
        </div>

        <div class="card-box">
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th width="50">#</th>
                            <th>Option Name</th>
                            <th width="150" class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($options as $index => $option)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $option->name }}</td>
                                <td class="text-center">
                                    <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#editModal{{ $option->id }}">
                                        <i class="bi bi-pencil"></i>
                                    </button>
                                    <form action="{{ route('crm-options.destroy', $option->id) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Delete this option?');">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-outline-danger">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>

                            <!-- Edit Modal -->
                            <div class="modal fade" id="editModal{{ $option->id }}" tabindex="-1">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <form action="{{ route('crm-options.update', $option->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <div class="modal-header">
                                                <h5 class="modal-title">Edit Option</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body">
                                                <label class="form-label">Name</label>
                                                <input type="text" name="name" class="form-control" value="{{ $option->name }}" required>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-primary">Save Changes</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center text-muted py-3">No options found for this type.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
