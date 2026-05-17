@extends('layouts.blank')

@section('page-title', 'CRM Form')

@section('content')

    {{-- ===================== TOP HEADER CARD ===================== --}}
    <div class="card-box mb-3 py-3">
        <div class="row align-items-center">

            {{-- Left: Branding --}}
            <div class="col-md-3 border-end">
                <div class="fw-bold fs-4" style="color:#0f172a; letter-spacing:-.5px;">Light of Hope</div>
                <div class="text-muted small fw-semibold">Light of Hope CRM</div>
                <div class="text-muted" style="font-size:.75rem;">Complete customer query and enrollment system</div>
            </div>

            {{-- Center: FAQ Search --}}
            <div class="col-md-5 px-4">
                <label class="form-label fw-semibold small mb-1">Dynamic FAQ Search</label>
                <div class="position-relative">
                    <input type="text" id="faqSearch" class="form-control form-control-sm"
                        placeholder="Search FAQ, help topics...">
                    <ul id="faqSuggestions" class="list-group position-absolute w-100 shadow-sm"
                        style="display:none; top:100%; left:0; z-index:999; max-height:220px; overflow-y:auto;"></ul>
                </div>
            </div>

            {{-- Right: agent name (UI only for now) --}}
            <div class="col-md-4">
                <label for="agentNameInput" class="form-label fw-semibold small mb-1">Agent Name</label>
                <input id="agentNameInput" class="form-control form-control-sm" readonly placeholder="No agent detected">
            </div>
        </div>
    </div>

    {{-- ===================== FAQ MODAL ===================== --}}
    <div class="modal fade" id="faqModal" tabindex="-1">
        <div class="modal-dialog modal-xl modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="faqModalLabel"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p id="faqModalDescription" class="text-muted mb-3"></p>
                    <div id="faqPdfContainer"></div>
                </div>
            </div>
        </div>
    </div>

    {{-- ===================== FORM CARD ===================== --}}
    <div class="card-box mb-3">

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
            </div>
        @endif

        <form action="{{ route('crm.course_outbound.store') }}" method="POST" id="crmForm">
            @csrf

            {{-- Hidden fields from URL --}}
            <input type="hidden" name="campaign" id="campaign_field">
            <input type="hidden" name="agent" id="agent_field">

            {{-- ════════════════════════════════════════
            SECTION 1 — Consumer Information
            ════════════════════════════════════════ --}}
            <h6 class="fw-bold mb-3 pb-1" style="color:#2563eb; border-bottom:2px solid #2563eb;">
                Consumer Information (Course)
            </h6>

            <div class="row g-3 mb-4">

                <div class="col-md-4">
                    <label class="form-label small fw-semibold">
                        Parent's Name <span class="text-danger">*</span>
                    </label>
                    <input type="text" name="parents_name"
                        class="form-control form-control-sm @error('parents_name') is-invalid @enderror"
                        value="{{ old('parents_name') }}">
                    @error('parents_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-4">
                    <label class="form-label small fw-semibold">
                        Child's Gender
                    </label>
                    <select name="child_gender" class="form-select form-select-sm">
                        <option value="">-- Select Gender --</option>
                        <option value="Male" {{ old('child_gender') == 'Male' ? 'selected' : '' }}>Male</option>
                        <option value="Female" {{ old('child_gender') == 'Female' ? 'selected' : '' }}>Female</option>
                        <option value="Other" {{ old('child_gender') == 'Other' ? 'selected' : '' }}>Other</option>
                    </select>
                </div>

                <div class="col-md-4">
                    <label class="form-label small fw-semibold">Profession</label>
                    <input type="text" name="profession" class="form-control form-control-sm"
                        value="{{ old('profession') }}" placeholder="e.g. Teacher, Doctor">
                </div>

                <div class="col-md-4">
                    <label class="form-label small fw-semibold">
                        Phone Number <span class="text-danger">*</span>
                    </label>
                    <input type="text" name="phone" id="phone"
                        class="form-control form-control-sm @error('phone') is-invalid @enderror" value="{{ old('phone') }}"
                        autocomplete="off">
                    @error('phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-4">
                    <label class="form-label small fw-semibold">Email</label>
                    <input type="email" name="email" class="form-control form-control-sm" value="{{ old('email') }}">
                </div>

                <div class="col-md-4">
                    <label class="form-label small fw-semibold">District</label>
                    <select name="district_id" class="form-select form-select-sm">
                        <option value="">-- Select District --</option>
                        @foreach($districts as $d)
                            <option value="{{ $d->id }}" {{ old('district_id') == $d->id ? 'selected' : '' }}>
                                {{ $d->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-4">
                    <label class="form-label small fw-semibold">Child's Name</label>
                    <input type="text" name="child_name" class="form-control form-control-sm"
                        value="{{ old('child_name') }}">
                </div>

                <div class="col-md-4">
                    <label class="form-label small fw-semibold">Child's Age</label>
                    <input type="text" name="child_age" class="form-control form-control-sm" value="{{ old('child_age') }}"
                        placeholder="e.g. 8 years">
                </div>

                <div class="col-md-4">
                    <label class="form-label small fw-semibold">Class</label>
                    <input type="text" name="class" class="form-control form-control-sm" value="{{ old('class') }}"
                        placeholder="e.g. Grade 3">
                </div>

            </div>

            {{-- ════════════════════════════════════════
            SECTION 2 — Query & Complaint
            ════════════════════════════════════════ --}}
            <h6 class="fw-bold mb-3 pb-1" style="color:#2563eb; border-bottom:2px solid #2563eb;">
                Query & Complaint
            </h6>

            <div class="row g-3 mb-4">

                <div class="col-md-4">
                    <label class="form-label small fw-semibold">Interested For</label>
                    <select name="interested_for" class="form-select form-select-sm">
                        <option value="">-- Select --</option>
                        @foreach($interestedForOptions as $opt)
                            <option value="{{ $opt->name }}" {{ old('interested_for') == $opt->name ? 'selected' : '' }}>
                                {{ $opt->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-4">
                    <label class="form-label small fw-semibold">
                        Data Source <span class="text-danger">*</span>
                    </label>
                    <select name="data_source_id"
                        class="form-select form-select-sm @error('data_source_id') is-invalid @enderror">
                        <option value="">-- Select Source --</option>
                        @foreach($dataSources as $s)
                            <option value="{{ $s->id }}" {{ old('data_source_id') == $s->id ? 'selected' : '' }}>
                                {{ $s->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('data_source_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-4">
                    <label class="form-label small fw-semibold">Calling Status</label>
                    <select name="calling_status" class="form-select form-select-sm">
                        <option value="">-- Select Status --</option>
                        @foreach($callingStatusOptions as $opt)
                            <option value="{{ $opt->name }}" {{ old('calling_status') == $opt->name ? 'selected' : '' }}>
                                {{ $opt->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-4">
                    <label class="form-label small fw-semibold">Query Source</label>
                    <select name="query_source" class="form-select form-select-sm">
                        <option value="">-- Select --</option>
                        @foreach($querySourceOptions as $opt)
                            <option value="{{ $opt->name }}" {{ old('query_source') == $opt->name ? 'selected' : '' }}>
                                {{ $opt->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-4">
                    <label class="form-label small fw-semibold">Query Status</label>
                    <select name="query_status" class="form-select form-select-sm">
                        <option value="">-- Select --</option>
                        @foreach($queryStatusOptions as $opt)
                            <option value="{{ $opt->name }}" {{ old('query_status') == $opt->name ? 'selected' : '' }}>
                                {{ $opt->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-4">
                    <label class="form-label small fw-semibold">Call Back</label>
                    <select name="call_back" class="form-select form-select-sm">
                        <option value="">-- Select --</option>
                        @foreach($callBackOptions as $opt)
                            <option value="{{ $opt->name }}" {{ old('call_back') == $opt->name ? 'selected' : '' }}>
                                {{ $opt->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <div class="col-md-2">
                    <label class="form-label small fw-semibold">Call Back Date</label>
                    <input type="date" name="call_back_date" class="form-control form-control-sm" value="{{ old('call_back_date') }}">
                </div>

                <div class="col-md-2">
                    <label class="form-label small fw-semibold">Call Back Time</label>
                    <input type="time" name="call_back_time" class="form-control form-control-sm" value="{{ old('call_back_time') }}">
                </div>

                <div class="col-md-4">
                    <label class="form-label small fw-semibold">Assigned Person</label>
                    <select name="assigned_person" id="assigned_person" class="form-select form-select-sm">
                        <option value="">-- Select --</option>
                        @foreach($assignedPersonOptions as $opt)
                            <option value="{{ $opt->name }}" {{ old('assigned_person') == $opt->name ? 'selected' : '' }}>
                                {{ $opt->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-12">
                    <label class="form-label small fw-semibold">
                        Remarks <span class="text-danger">*</span>
                    </label>
                    <textarea name="remarks" class="form-control form-control-sm" rows="3"
                        placeholder="Customer conversation notes...">{{ old('remarks') }}</textarea>
                </div>

            </div>

            {{-- Save Button --}}
            <div class="text-center py-2" style="border-top:1px solid #e2e8f0; margin-top:8px;">
                <button type="submit" class="btn btn-primary px-5">
                    Save Record
                </button>
            </div>

        </form>
    </div>

    {{-- ===================== INTERACTION HISTORY ===================== --}}
    <div class="card-box" id="historySection">
        <h6 class="fw-bold mb-3 pb-1" style="color:#2563eb; border-bottom:2px solid #2563eb;">
            Consumer Histories
            <span id="historyPhone" class="text-muted fw-normal fs-6 ms-2"></span>
        </h6>

        <div id="historyLoader" class="text-center py-3" style="display:none;">
            <div class="spinner-border spinner-border-sm text-primary"></div>
            <span class="ms-2 text-muted small">Loading history...</span>
        </div>

        <div class="table-responsive">
            <table class="table table-sm table-bordered align-middle mb-1" id="historyTable">
                <thead class="table-light">
                    <tr>
                        <th>Record ID</th>
                        <th>Parent Name</th>
                        <th>Phone</th>
                        <th>District</th>
                        <th>Interested For</th>
                        <th>Calling Status</th>
                        <th>Query Source</th>
                        <th>Query Status</th>
                        <th>Assigned Person</th>
                        <th>Data Source</th>
                        <th>Register Date</th>
                    </tr>
                </thead>
                <tbody id="historyBody">
                    <tr>
                        <td colspan="11" class="text-center text-danger py-3">
                            No Data Found
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-end gap-2 mt-2">
            <button class="btn btn-sm btn-outline-secondary" id="historyPrev" disabled>Previous</button>
            <button class="btn btn-sm btn-outline-secondary" id="historyNext" disabled>Next</button>
        </div>
    </div>

@endsection

@push('scripts')
    <script>
        $(function () {

            // ─── Pre-fill from URL params ───────────────────────────────
            const params = new URLSearchParams(window.location.search);

            if (params.get('phone_number')) {
                const ph = params.get('phone_number');
                $('#phone').val(ph);
                if (ph.length >= 6) loadHistory(ph);
            }

            if (params.get('assigned_person')) $('#assigned_person').val(params.get('assigned_person'));
            if (params.get('campaign')) $('#campaign_field').val(params.get('campaign'));
            if (params.get('agent')) {
                const agent = params.get('agent');
                $('#agent_field').val(agent);
                $('#agentNameInput').val(agent);
            }

            // ─── FAQ AJAX Search ────────────────────────────────────────
            let faqTimer;
            $('#faqSearch').on('input', function () {
                clearTimeout(faqTimer);
                const q = $(this).val().trim();
                if (q.length < 2) { $('#faqSuggestions').hide().empty(); return; }

                faqTimer = setTimeout(function () {
                    $.getJSON("{{ route('faq.search') }}", { search: q }, function (data) {
                        const $ul = $('#faqSuggestions').empty();
                        if (!data.length) {
                            $ul.append('<li class="list-group-item text-muted small py-2">No results found.</li>').show();
                            return;
                        }
                        data.forEach(function (faq) {
                            $ul.append(
                                $('<li class="list-group-item list-group-item-action py-2 small" style="cursor:pointer;">')
                                    .html('<i class="bi bi-file-earmark-pdf text-danger me-2"></i>' + faq.title)
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

            $(document).on('click', function (e) {
                if (!$(e.target).closest('#faqSearch, #faqSuggestions').length)
                    $('#faqSuggestions').hide().empty();
            });

            function openFaqModal(faq) {
                $('#faqModalLabel').text(faq.title);
                $('#faqModalDescription').text(faq.description || '');
                const $c = $('#faqPdfContainer').empty();
                $c.html(faq.pdf_path
                    ? '<iframe src="/storage/' + faq.pdf_path + '" width="100%" height="640px" style="border:none;border-radius:6px;"></iframe>'
                    : '<p class="text-muted"><i class="bi bi-file-earmark-x"></i> No PDF attached.</p>'
                );
                new bootstrap.Modal(document.getElementById('faqModal')).show();
            }

            // ─── Interaction History ─────────────────────────────────────
            let historyTimer;
            const PAGE_SIZE = 10;
            let allRecords = [];
            let currentPage = 0;

            $('#phone').on('input', function () {
                clearTimeout(historyTimer);
                const phone = $(this).val().trim();
                if (phone.length < 6) {
                    resetHistory();
                    return;
                }
                historyTimer = setTimeout(() => loadHistory(phone), 600);
            });

            function resetHistory() {
                allRecords = [];
                currentPage = 0;
                $('#historyBody').html('<tr><td colspan="11" class="text-center text-danger py-3">No Data Found</td></tr>');
                $('#historyPhone').text('');
                $('#historyPrev, #historyNext').prop('disabled', true);
            }

            function loadHistory(phone) {
                $('#historyLoader').show();
                $('#historyBody').html('');

                $.getJSON("{{ route('crm.course_outbound.history') }}", { phone: phone }, function (records) {
                    $('#historyLoader').hide();
                    allRecords = records;
                    currentPage = 0;
                    $('#historyPhone').text('— ' + phone);

                    if (!records.length) {
                        resetHistory();
                        return;
                    }
                    renderPage();
                }).fail(function () {
                    $('#historyLoader').hide();
                    $('#historyBody').html('<tr><td colspan="11" class="text-center text-danger">Failed to load.</td></tr>');
                });
            }

            function renderPage() {
                const start = currentPage * PAGE_SIZE;
                const page = allRecords.slice(start, start + PAGE_SIZE);
                const $tbody = $('#historyBody').empty();

                const statusColor = {
                    'Enrolled': 'success', 'Trial Class': 'info', 'Pending': 'warning',
                    'Cancel': 'danger', 'No Interaction': 'secondary', 'No Communication': 'dark'
                };
                const qColor = {
                    'Done': 'success', 'Pending': 'warning', 'Cancel': 'danger', 'No Interaction': 'secondary'
                };

                page.forEach(function (r) {
                    const cs = r.calling_status
                        ? `<span class="badge bg-${statusColor[r.calling_status] || 'secondary'}">${r.calling_status}</span>`
                        : '—';
                    const qs = r.query_status
                        ? `<span class="badge bg-${qColor[r.query_status] || 'secondary'}">${r.query_status}</span>`
                        : '—';

                    $tbody.append(`
                                        <tr>
                                            <td>#${r.id}</td>
                                            <td>${r.parents_name}</td>
                                            <td>${r.phone}</td>
                                            <td>${r.district}</td>
                                            <td>${r.interested_for || '—'}</td>
                                            <td>${cs}</td>
                                            <td>${r.query_source || '—'}</td>
                                            <td>${qs}</td>
                                            <td>${r.assigned_person}</td>
                                            <td>${r.data_source}</td>
                                            <td>${r.date}</td>
                                        </tr>
                                    `);
                });

                $('#historyPrev').prop('disabled', currentPage === 0);
                $('#historyNext').prop('disabled', start + PAGE_SIZE >= allRecords.length);
            }

            $('#historyPrev').on('click', function () {
                if (currentPage > 0) { currentPage--; renderPage(); }
            });
            $('#historyNext').on('click', function () {
                if ((currentPage + 1) * PAGE_SIZE < allRecords.length) { currentPage++; renderPage(); }
            });
        });
    </script>
@endpush