@extends('layouts.app')

@section('content')

    {{-- ===================== FAQ SEARCH BAR ===================== --}}
    <div class="card-box mb-4">
        <h6 class="fw-bold mb-2"><i class="bi bi-search"></i> Search FAQ / Documents</h6>
        <div class="position-relative">
            <input type="text" id="faqSearch" class="form-control" placeholder="Search by title, description, or tags...">
            <ul id="faqSuggestions" class="list-group position-absolute w-100 z-3 shadow"
                style="display:none; top:100%; left:0;"></ul>
        </div>
    </div>

    {{-- ===================== FAQ MODAL ===================== --}}
    <div class="modal fade" id="faqModal" tabindex="-1" aria-labelledby="faqModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="faqModalLabel">FAQ</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p id="faqModalDescription" class="text-muted mb-3"></p>
                    <div id="faqPdfContainer"></div>
                </div>
            </div>
        </div>
    </div>

    {{-- ===================== CRM FORM ===================== --}}
    <div class="card-box">
        <h6 class="fw-bold mb-4"><i class="bi bi-plus-circle"></i> Add New CRM Record</h6>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('crm.store') }}" method="POST">
            @csrf

            <div class="row g-3">

                {{-- Parent Name --}}
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Parent's Name <span class="text-danger">*</span></label>
                    <input type="text" name="parents_name" class="form-control @error('parents_name') is-invalid @enderror"
                        value="{{ old('parents_name') }}" placeholder="Enter parent's full name">
                    @error('parents_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                {{-- Phone --}}
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Phone <span class="text-danger">*</span></label>
                    <input type="text" name="phone" id="phone" class="form-control @error('phone') is-invalid @enderror"
                        value="{{ old('phone') }}" placeholder="01XXXXXXXXX">
                    @error('phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                {{-- Email --}}
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Email</label>
                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                        value="{{ old('email') }}" placeholder="example@email.com">
                    @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                {{-- Profession --}}
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Profession</label>
                    <input type="text" name="profession" class="form-control" value="{{ old('profession') }}"
                        placeholder="e.g. Teacher, Doctor">
                </div>

                {{-- District --}}
                <div class="col-md-6">
                    <label class="form-label fw-semibold">District</label>
                    <select name="district_id" class="form-select">
                        <option value="">— Select District —</option>
                        @foreach($districts as $district)
                            <option value="{{ $district->id }}" {{ old('district_id') == $district->id ? 'selected' : '' }}>
                                {{ $district->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Data Source --}}
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Data Source <span class="text-danger">*</span></label>
                    <select name="data_source_id" class="form-select @error('data_source_id') is-invalid @enderror">
                        <option value="">— Select Data Source —</option>
                        @foreach($dataSources as $source)
                            <option value="{{ $source->id }}" {{ old('data_source_id') == $source->id ? 'selected' : '' }}>
                                {{ $source->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('data_source_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                {{-- Child Name --}}
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Child's Name</label>
                    <input type="text" name="child_name" class="form-control" value="{{ old('child_name') }}"
                        placeholder="Child's full name">
                </div>

                {{-- Child Age --}}
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Child's Age</label>
                    <input type="text" name="child_age" class="form-control" value="{{ old('child_age') }}"
                        placeholder="e.g. 7 years">
                </div>

                {{-- Child Gender --}}
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Child's Gender</label>
                    <select name="child_gender" class="form-select">
                        <option value="">— Select —</option>
                        <option value="Male" {{ old('child_gender') == 'Male' ? 'selected' : '' }}>Male</option>
                        <option value="Female" {{ old('child_gender') == 'Female' ? 'selected' : '' }}>Female</option>
                        <option value="Other" {{ old('child_gender') == 'Other' ? 'selected' : '' }}>Other</option>
                    </select>
                </div>

                {{-- Class --}}
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Class</label>
                    <input type="text" name="class" class="form-control" value="{{ old('class') }}"
                        placeholder="e.g. Grade 3, Class 5">
                </div>

                {{-- Interested For --}}
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Interested For</label>
                    <input type="text" name="interested_for" class="form-control" value="{{ old('interested_for') }}"
                        placeholder="e.g. Math, English">
                </div>

                {{-- Assigned Person --}}
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Assigned Person</label>
                    <input type="text" name="assigned_person" id="assigned_person" class="form-control"
                        value="{{ old('assigned_person') }}" placeholder="Agent name">
                </div>

                {{-- Campaign (hidden, from URL param) --}}
                <input type="hidden" name="campaign" id="campaign_field" value="{{ old('campaign', request('campaign')) }}">

                {{-- Remarks --}}
                <div class="col-12">
                    <label class="form-label fw-semibold">Remarks</label>
                    <textarea name="remarks" class="form-control" rows="3"
                        placeholder="Any additional notes...">{{ old('remarks') }}</textarea>
                </div>

                {{-- Submit --}}
                <div class="col-12 text-end">
                    <a href="{{ route('crm.index') }}" class="btn btn-secondary me-2">Cancel</a>
                    <button type="submit" class="btn btn-primary px-4">
                        <i class="bi bi-save"></i> Save Record
                    </button>
                </div>

            </div>
        </form>
    </div>

@endsection

@push('scripts')
    <script>
        $(function () {

            // ---- Pre-fill from URL params ----
            const params = new URLSearchParams(window.location.search);
            if (params.get('phone_number')) $('#phone').val(params.get('phone_number'));
            if (params.get('agent')) $('#assigned_person').val(params.get('agent'));
            if (params.get('campaign')) $('#campaign_field').val(params.get('campaign'));

            // ---- FAQ AJAX Search ----
            let searchTimer;
            $('#faqSearch').on('input', function () {
                clearTimeout(searchTimer);
                const q = $(this).val().trim();
                if (q.length < 2) { $('#faqSuggestions').hide().empty(); return; }

                searchTimer = setTimeout(function () {
                    $.getJSON("{{ route('faq.search') }}", { search: q }, function (data) {
                        const $ul = $('#faqSuggestions').empty();
                        if (data.length === 0) {
                            $ul.append('<li class="list-group-item text-muted">No results found.</li>').show();
                            return;
                        }
                        data.forEach(function (faq) {
                            $ul.append(
                                $('<li class="list-group-item list-group-item-action" style="cursor:pointer;">')
                                    .text(faq.title)
                                    .on('click', function () {
                                        openFaqModal(faq);
                                        $ul.hide().empty();
                                        $('#faqSearch').val('');
                                    })
                            );
                        });
                        $ul.show();
                    });
                }, 300);
            });

            // Hide suggestions when clicking outside
            $(document).on('click', function (e) {
                if (!$(e.target).closest('#faqSearch, #faqSuggestions').length) {
                    $('#faqSuggestions').hide().empty();
                }
            });

            // ---- Open FAQ Modal ----
            function openFaqModal(faq) {
                $('#faqModalLabel').text(faq.title);
                $('#faqModalDescription').text(faq.description || '');

                const $pdfContainer = $('#faqPdfContainer').empty();
                if (faq.pdf_path) {
                    $pdfContainer.html(
                        '<iframe src="/storage/' + faq.pdf_path + '" width="100%" height="600px" style="border:none; border-radius:8px;"></iframe>'
                    );
                } else {
                    $pdfContainer.html('<p class="text-muted"><i class="bi bi-file-earmark-x"></i> No PDF attached.</p>');
                }

                new bootstrap.Modal(document.getElementById('faqModal')).show();
            }

        });
    </script>
@endpush