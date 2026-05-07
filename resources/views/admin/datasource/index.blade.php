@extends('layouts.app')

@section('content')

    <div class="row g-4">

        {{-- ADD FORM --}}
        <div class="col-md-4">
            <div class="card-box">
                <h6 class="fw-bold mb-3"><i class="bi bi-plus-circle"></i> Add Data Source</h6>

                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <form action="{{ route('data-sources.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                            value="{{ old('name') }}" placeholder="e.g. Website, WhatsApp">
                        @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-save"></i> Save
                    </button>
                </form>
            </div>
        </div>

        {{-- LIST --}}
        <div class="col-md-8">
            <div class="card-box">
                <h6 class="fw-bold mb-3"><i class="bi bi-database"></i> Data Sources</h6>
                <table id="dsTable" class="table table-hover table-bordered">
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($dataSources as $i => $source)
                            <tr>
                                <td>{{ $i + 1 }}</td>
                                <td>{{ $source->name }}</td>
                                <td>
                                    {{-- Edit Button --}}
                                    <button class="btn btn-sm btn-warning me-1" data-bs-toggle="modal"
                                        data-bs-target="#editModal{{ $source->id }}">
                                        <i class="bi bi-pencil"></i>
                                    </button>

                                    {{-- Delete --}}
                                    <form action="{{ route('data-sources.destroy', $source->id) }}" method="POST"
                                        class="d-inline" onsubmit="return confirm('Delete this data source?')">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-sm btn-danger">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>

                            {{-- Edit Modal --}}
                            <div class="modal fade" id="editModal{{ $source->id }}" tabindex="-1">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Edit Data Source</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <form action="{{ route('data-sources.update', $source->id) }}" method="POST">
                                            @csrf @method('PUT')
                                            <div class="modal-body">
                                                <label class="form-label fw-semibold">Name</label>
                                                <input type="text" name="name" class="form-control" value="{{ $source->name }}"
                                                    required>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Cancel</button>
                                                <button type="submit" class="btn btn-primary">Update</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>

@endsection

@push('scripts')
    <script>
        $('#dsTable').DataTable({ pageLength: 25, order: [] });
    </script>
@endpush