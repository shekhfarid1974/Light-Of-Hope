@extends('layouts.app')

@section('content')

    <div class="row g-4">

        {{-- ADD FORM --}}
        <div class="col-md-5">
            <div class="card-box">
                <h6 class="fw-bold mb-3"><i class="bi bi-plus-circle"></i> Add FAQ</h6>

                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <form action="{{ route('faqs.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Title <span class="text-danger">*</span></label>
                        <input type="text" name="title" class="form-control @error('title') is-invalid @enderror"
                            value="{{ old('title') }}" placeholder="e.g. Television PDF">
                        @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Description</label>
                        <textarea name="description" class="form-control" rows="3"
                            placeholder="Brief description of this document...">{{ old('description') }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Tags</label>
                        <input type="text" name="tags" class="form-control" value="{{ old('tags') }}"
                            placeholder="e.g. samsung, lg, sony, 4k, television">
                        <div class="form-text">Comma-separated tags to help agents find this document via search.</div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">PDF File</label>
                        <input type="file" name="pdf_file" class="form-control @error('pdf_file') is-invalid @enderror"
                            accept=".pdf">
                        @error('pdf_file') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-save"></i> Save FAQ
                    </button>

                </form>
            </div>
        </div>

        {{-- FAQ LIST --}}
        <div class="col-md-7">
            <div class="card-box">
                <h6 class="fw-bold mb-3"><i class="bi bi-question-circle"></i> FAQ List</h6>

                <table id="faqTable" class="table table-hover table-bordered">
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>Title</th>
                            <th>Tags</th>
                            <th>PDF</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($faqs as $i => $faq)
                            <tr>
                                <td>{{ $i + 1 }}</td>
                                <td>
                                    <strong>{{ $faq->title }}</strong>
                                    @if($faq->description)
                                        <br><small class="text-muted">{{ Str::limit($faq->description, 60) }}</small>
                                    @endif
                                </td>
                                <td>
                                    @if($faq->tags)
                                        @foreach(explode(',', $faq->tags) as $tag)
                                            <span class="badge bg-secondary me-1">{{ trim($tag) }}</span>
                                        @endforeach
                                    @else
                                        <span class="text-muted">—</span>
                                    @endif
                                </td>
                                <td>
                                    @if($faq->pdf_path)
                                        <a href="{{ asset('storage/' . $faq->pdf_path) }}" target="_blank"
                                            class="btn btn-sm btn-outline-danger">
                                            <i class="bi bi-file-earmark-pdf"></i> View
                                        </a>
                                    @else
                                        <span class="text-muted">—</span>
                                    @endif
                                </td>
                                <td>
                                    {{-- Edit --}}
                                    <button class="btn btn-sm btn-warning me-1" data-bs-toggle="modal"
                                        data-bs-target="#editFaqModal{{ $faq->id }}">
                                        <i class="bi bi-pencil"></i>
                                    </button>

                                    {{-- Delete --}}
                                    <form action="{{ route('faqs.destroy', $faq->id) }}" method="POST" class="d-inline"
                                        onsubmit="return confirm('Delete this FAQ?')">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-sm btn-danger">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>

                            {{-- Edit Modal --}}
                            <div class="modal fade" id="editFaqModal{{ $faq->id }}" tabindex="-1">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Edit FAQ</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <form action="{{ route('faqs.update', $faq->id) }}" method="POST"
                                            enctype="multipart/form-data">
                                            @csrf @method('PUT')
                                            <div class="modal-body row g-3">
                                                <div class="col-12">
                                                    <label class="form-label fw-semibold">Title</label>
                                                    <input type="text" name="title" class="form-control"
                                                        value="{{ $faq->title }}" required>
                                                </div>
                                                <div class="col-12">
                                                    <label class="form-label fw-semibold">Description</label>
                                                    <textarea name="description" class="form-control"
                                                        rows="3">{{ $faq->description }}</textarea>
                                                </div>
                                                <div class="col-12">
                                                    <label class="form-label fw-semibold">Tags</label>
                                                    <input type="text" name="tags" class="form-control"
                                                        value="{{ $faq->tags }}">
                                                </div>
                                                <div class="col-12">
                                                    <label class="form-label fw-semibold">Replace PDF (optional)</label>
                                                    <input type="file" name="pdf_file" class="form-control" accept=".pdf">
                                                    @if($faq->pdf_path)
                                                        <div class="form-text">
                                                            Current: <a href="{{ asset('storage/' . $faq->pdf_path) }}"
                                                                target="_blank">View PDF</a>
                                                        </div>
                                                    @endif
                                                </div>
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
        $('#faqTable').DataTable({ pageLength: 25, order: [] });
    </script>
@endpush