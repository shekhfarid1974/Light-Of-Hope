@extends('layouts.blank')

@section('page-title', 'Teachers CRM Form')

@section('content')

    {{-- ===================== TOP HEADER CARD ===================== --}}
    <div class="card-box mb-3 py-3">
        <div class="row align-items-center">
            {{-- Left: Branding --}}
            <div class="col-md-3 border-end">
                <div class="fw-bold fs-4" style="color:#0f172a; letter-spacing:-.5px;">Light of Hope</div>
                <div class="text-muted small fw-semibold">Teachers Time CRM</div>
                <div class="text-muted" style="font-size:.75rem;">Participant query and enrollment system</div>
            </div>

            {{-- Center: FAQ Search --}}
            <div class="col-md-5 px-4">
                <label class="form-label fw-semibold small mb-1">Dynamic FAQ Search (Teachers)</label>
                <div class="position-relative">
                    <input type="text" id="faqSearch" class="form-control form-control-sm"
                        placeholder="Search FAQ, help topics...">
                    <ul id="faqSuggestions" class="list-group position-absolute w-100 shadow-sm"
                        style="display:none; top:100%; left:0; z-index:999; max-height:220px; overflow-y:auto;"></ul>
                </div>
            </div>

            {{-- Right: agent name --}}
            <div class="col-md-4">
                <label for="agentNameInput" class="form-label fw-semibold small mb-1">Agent Name</label>
                <input id="agentNameInput" class="form-control form-control-sm" readonly placeholder="No agent detected">
            </div>
        </div>
    </div>

    {{-- ===================== CRM SWITCHER ===================== --}}
    <div class="alert alert-primary d-flex align-items-center justify-content-between mb-3 shadow-sm border-0"
        style="background-color: #fef2f2; color: #991b1b;">
        <div>
            <i class="bi bi-info-circle-fill me-2 fs-5 align-middle"></i>
            <span class="align-middle"><strong>Is this a Kids customer?</strong> Switch back to the Kids CRM.</span>
        </div>
        <a href="{{ route('crm.kids_crm.form', request()->query()) }}" class="btn btn-danger fw-bold px-4 shadow-sm">
            <i class="bi bi-arrow-left-circle me-1"></i> Switch to Kids CRM
        </a>
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

        <form action="{{ route('crm.teachers_crm.store') }}" method="POST" id="crmForm">
            @csrf

            {{-- Hidden fields from URL --}}
            <input type="hidden" name="agent" id="agent_field">

            {{-- ════════════════════════════════════════
            SECTION 1 — Participants' Info
            ════════════════════════════════════════ --}}
            <h6 class="fw-bold mb-3 pb-1" style="color:#2563eb; border-bottom:2px solid #2563eb;">
                Section 1: Participants' Info
            </h6>

            <div class="row g-3 mb-4">
                <div class="col-md-4">
                    <label class="form-label small fw-semibold">Customer Name <span class="text-danger">*</span></label>
                    <input type="text" name="customer_name" class="form-control form-control-sm"
                        value="{{ old('customer_name') }}" required>
                </div>

                <div class="col-md-4">
                    <label class="form-label small fw-semibold">Phone <span class="text-danger">*</span></label>
                    <input type="text" name="phone" id="phone" class="form-control form-control-sm"
                        value="{{ old('phone') }}" required autocomplete="off">
                </div>

                <div class="col-md-4">
                    <label class="form-label small fw-semibold">WhatsApp</label>
                    <input type="text" name="whatsapp" class="form-control form-control-sm" value="{{ old('whatsapp') }}">
                </div>

                <div class="col-md-4">
                    <label class="form-label small fw-semibold">Email</label>
                    <input type="email" name="email" class="form-control form-control-sm" value="{{ old('email') }}">
                </div>

                <div class="col-md-4">
                    <label class="form-label small fw-semibold">Gender</label>
                    <select name="gender" class="form-select form-select-sm">
                        <option value="">-- Select --</option>
                        @foreach($genderOptions as $opt)
                            <option value="{{ $opt->name }}" {{ old('gender') == $opt->name ? 'selected' : '' }}>{{ $opt->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-4">
                    <label class="form-label small fw-semibold">Area</label>
                    <input type="text" name="area" class="form-control form-control-sm" value="{{ old('area') }}">
                </div>

                <div class="col-md-4">
                    <label class="form-label small fw-semibold">District <span class="text-danger">*</span></label>
                    <select name="district_id" class="form-select form-select-sm" required>
                        <option value="">-- Select District --</option>
                        @foreach($districts as $d)
                            <option value="{{ $d->id }}" {{ old('district_id') == $d->id ? 'selected' : '' }}>{{ $d->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-4">
                    <label class="form-label small fw-semibold">Age</label>
                    <input type="number" name="age" class="form-control form-control-sm" value="{{ old('age') }}">
                </div>

                <div class="col-md-4">
                    <label class="form-label small fw-semibold">Educational Qualification</label>
                    <select name="educational_qualification" class="form-select form-select-sm">
                        <option value="">-- Select --</option>
                        @foreach($eduQualificationOptions as $opt)
                            <option value="{{ $opt->name }}" {{ old('educational_qualification') == $opt->name ? 'selected' : '' }}>{{ $opt->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-4">
                    <label class="form-label small fw-semibold">Joining As <span class="text-danger">*</span></label>
                    <select name="joining_as" id="joining_as" class="form-select form-select-sm" required>
                        <option value="">-- Select --</option>
                        @foreach($joiningAsOptions as $opt)
                            <option value="{{ $opt->name }}" {{ old('joining_as') == $opt->name ? 'selected' : '' }}>
                                {{ $opt->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-4">
                    <label class="form-label small fw-semibold">Course</label>
                    <select name="course" class="form-select form-select-sm">
                        <option value="">-- Select --</option>
                        @foreach($courseOptions as $opt)
                            <option value="{{ $opt->name }}" {{ old('course') == $opt->name ? 'selected' : '' }}>{{ $opt->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            {{-- ════════════════════════════════════════
            SECTION 2 — Professional Summary (Tabs)
            ════════════════════════════════════════ --}}
            <div id="professionalSummaryCard" style="display:none;">
                <h6 class="fw-bold mb-3 pb-1" style="color:#2563eb; border-bottom:2px solid #2563eb;">
                    Section 2: Professional Summary
                </h6>

                {{-- Tab Headers --}}
                <ul class="nav nav-tabs mb-3" id="summaryTabs" role="tablist">
                    <li class="nav-item" role="presentation" id="tabHeaderTeacher">
                        <button class="nav-link active" id="teacher-tab" data-bs-toggle="tab" data-bs-target="#teacher-pane"
                            type="button" role="tab">Teacher Info</button>
                    </li>
                    <li class="nav-item" role="presentation" id="tabHeaderParent">
                        <button class="nav-link" id="parent-tab" data-bs-toggle="tab" data-bs-target="#parent-pane"
                            type="button" role="tab">Child's Info</button>
                    </li>
                    <li class="nav-item" role="presentation" id="tabHeaderOther">
                        <button class="nav-link" id="other-tab" data-bs-toggle="tab" data-bs-target="#other-pane"
                            type="button" role="tab">Other Summary</button>
                    </li>
                </ul>

                {{-- Tab Content --}}
                <div class="tab-content border p-3 rounded bg-light mb-4" id="summaryTabsContent">
                    {{-- Teacher Tab --}}
                    <div class="tab-pane fade show active" id="teacher-pane" role="tabpanel">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label small fw-semibold">Current Designation</label>
                                <select name="current_designation" class="form-select form-select-sm">
                                    <option value="">-- Select --</option>
                                    @foreach($currentDesignationOptions as $opt)
                                        <option value="{{ $opt->name }}" {{ old('current_designation') == $opt->name ? 'selected' : '' }}>{{ $opt->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label small fw-semibold">Years of Experience</label>
                                <input type="text" name="years_of_experience" class="form-control form-control-sm"
                                    value="{{ old('years_of_experience') }}">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label small fw-semibold">Teaching Group</label>
                                <select name="teaching_group" class="form-select form-select-sm">
                                    <option value="">-- Select --</option>
                                    @foreach($teachingGroupOptions as $opt)
                                        <option value="{{ $opt->name }}" {{ old('teaching_group') == $opt->name ? 'selected' : '' }}>{{ $opt->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-semibold">Institution Name</label>
                                <input type="text" name="institution_name" class="form-control form-control-sm"
                                    value="{{ old('institution_name') }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-semibold">Institution Address</label>
                                <input type="text" name="institution_address" class="form-control form-control-sm"
                                    value="{{ old('institution_address') }}">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label small fw-semibold">Institution Type</label>
                                <select name="institution_type" class="form-select form-select-sm">
                                    <option value="">-- Select --</option>
                                    @foreach($institutionTypeOptions as $opt)
                                        <option value="{{ $opt->name }}" {{ old('institution_type') == $opt->name ? 'selected' : '' }}>{{ $opt->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    {{-- Parents Tab --}}
                    <div class="tab-pane fade" id="parent-pane" role="tabpanel">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label small fw-semibold">Child Name</label>
                                <input type="text" name="child_name" class="form-control form-control-sm"
                                    value="{{ old('child_name') }}">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label small fw-semibold">Child Gender</label>
                                <select name="child_gender" class="form-select form-select-sm">
                                    <option value="">-- Select --</option>
                                    @foreach($childGenderOptions as $opt)
                                        <option value="{{ $opt->name }}" {{ old('child_gender') == $opt->name ? 'selected' : '' }}>{{ $opt->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label small fw-semibold">DOB (Year/Number)</label>
                                <input type="number" name="dob" class="form-control form-control-sm"
                                    value="{{ old('dob') }}" placeholder="e.g. 2018">
                            </div>
                        </div>
                    </div>

                    {{-- Others Tab --}}
                    <div class="tab-pane fade" id="other-pane" role="tabpanel">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label small fw-semibold">Type</label>
                                <select name="other_type" class="form-select form-select-sm">
                                    <option value="">-- Select --</option>
                                    @foreach($otherTypeOptions as $opt)
                                        <option value="{{ $opt->name }}" {{ old('other_type') == $opt->name ? 'selected' : '' }}>
                                            {{ $opt->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-semibold">Organization</label>
                                <input type="text" name="organization" class="form-control form-control-sm"
                                    value="{{ old('organization') }}" placeholder="Applicable for Doctor, Trainer, etc.">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ════════════════════════════════════════
            SECTION 3 — Interaction Summary
            ════════════════════════════════════════ --}}
            <h6 class="fw-bold mb-3 pb-1" style="color:#2563eb; border-bottom:2px solid #2563eb;">
                Section 3: Interaction Summary
            </h6>

            <div class="row g-3 mb-4">
                <div class="col-md-4">
                    <label class="form-label small fw-semibold">Calling Agent</label>
                    <select name="calling_agent" class="form-select form-select-sm">
                        <option value="">-- Select --</option>
                        @foreach($callingAgentOptions as $opt)
                            <option value="{{ $opt->name }}" {{ old('calling_agent') == $opt->name ? 'selected' : '' }}>
                                {{ $opt->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-4">
                    <label class="form-label small fw-semibold">Calling Purpose</label>
                    <select name="calling_purpose" class="form-select form-select-sm">
                        <option value="">-- Select --</option>
                        @foreach($callingPurposeOptions as $opt)
                            <option value="{{ $opt->name }}" {{ old('calling_purpose') == $opt->name ? 'selected' : '' }}>
                                {{ $opt->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-4">
                    <label class="form-label small fw-semibold">Calling Status</label>
                    <select name="calling_status" class="form-select form-select-sm">
                        <option value="">-- Select --</option>
                        @foreach($callingStatusOptions as $opt)
                            <option value="{{ $opt->name }}" {{ old('calling_status') == $opt->name ? 'selected' : '' }}>
                                {{ $opt->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-4">
                    <label class="form-label small fw-semibold">Data Source</label>
                    <select name="data_source_id" class="form-select form-select-sm">
                        <option value="">-- Select Source --</option>
                        @foreach($dataSources as $s)
                            <option value="{{ $s->id }}" {{ old('data_source_id') == $s->id ? 'selected' : '' }}>{{ $s->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-4">
                    <label class="form-label small fw-semibold">Next Follow-up Date (Number)</label>
                    <input type="text" name="next_follow_up_date" class="form-control form-control-sm"
                        value="{{ old('next_follow_up_date') }}" placeholder="e.g. 5">
                </div>

                <div class="col-md-4">
                    <label class="form-label small fw-semibold">Call Back</label>
                    <select name="call_back" class="form-select form-select-sm">
                        <option value="">-- Select --</option>
                        @foreach($callBackOptions as $opt)
                            <option value="{{ $opt->name }}" {{ old('call_back') == $opt->name ? 'selected' : '' }}>
                                {{ $opt->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-4">
                    <label class="form-label small fw-semibold">Call Back Date</label>
                    <input type="date" name="call_back_date" class="form-control form-control-sm"
                        value="{{ old('call_back_date') }}">
                </div>

                <div class="col-md-4">
                    <label class="form-label small fw-semibold">Call Back Time</label>
                    <input type="time" name="call_back_time" class="form-control form-control-sm"
                        value="{{ old('call_back_time') }}">
                </div>

                <div class="col-12">
                    <label class="form-label small fw-semibold">Discussion Note</label>
                    <textarea name="discussion_note" class="form-control form-control-sm" rows="3"
                        placeholder="Enter discussion details...">{{ old('discussion_note') }}</textarea>
                </div>
            </div>

            {{-- ════════════════════════════════════════
            PRODUCT HISTORY
            ════════════════════════════════════════ --}}
            <h6 class="fw-bold mb-3 pb-1" style="color:#2563eb; border-bottom:2px solid #2563eb;">
                Product History
            </h6>

            <div class="row g-3 mb-4">
                <div class="col-md-4">
                    <label class="form-label small fw-semibold">Interested Course/Product Name</label>
                    <select name="interested_course" class="form-select form-select-sm">
                        <option value="">-- Select --</option>
                        @foreach($interestedCourseOptions as $opt)
                            <option value="{{ $opt->name }}" {{ old('interested_course') == $opt->name ? 'selected' : '' }}>
                                {{ $opt->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-4">
                    <label class="form-label small fw-semibold">Date of Purchase</label>
                    <input type="date" name="date_of_purchase" class="form-control form-control-sm"
                        value="{{ old('date_of_purchase') }}">
                </div>

                <div class="col-md-4">
                    <label class="form-label small fw-semibold">Branch</label>
                    <select name="branch" class="form-select form-select-sm">
                        <option value="">-- Select --</option>
                        @foreach($branchOptions as $opt)
                            <option value="{{ $opt->name }}" {{ old('branch') == $opt->name ? 'selected' : '' }}>{{ $opt->name }}
                            </option>
                        @endforeach
                    </select>
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
                        <th>Customer/Parent Name</th>
                        <th>Phone</th>
                        <th>District</th>
                        <th>Course/Interest</th>
                        <th>Calling Status</th>
                        <th>Calling Purpose</th>
                        <th>Calling Agent</th>
                        <th>Branch</th>
                        <th>Data Source</th>
                        <th>Register Date</th>
                    </tr>
                </thead>
                <tbody id="historyBody">
                    <tr>
                        <td colspan="11" class="text-center text-danger py-3">No Data Found</td>
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

            if (params.get('agent')) {
                const agent = params.get('agent');
                $('#agent_field').val(agent);
                $('#agentNameInput').val(agent);
            }

            // Joining As Tabs management
            function handleJoiningAsChange() {
                const val = $('#joining_as').val();
                if (val) {
                    $('#professionalSummaryCard').show();
                    if (val.toLowerCase() === 'teacher') {
                        $('#tabHeaderTeacher').show();
                        $('#tabHeaderParent').hide();
                        $('#tabHeaderOther').hide();
                        $('#teacher-tab').tab('show');
                    } else if (val.toLowerCase() === 'parent') {
                        $('#tabHeaderTeacher').hide();
                        $('#tabHeaderParent').show();
                        $('#tabHeaderOther').hide();
                        $('#parent-tab').tab('show');
                    } else {
                        $('#tabHeaderTeacher').hide();
                        $('#tabHeaderParent').hide();
                        $('#tabHeaderOther').show();
                        $('#other-tab').tab('show');
                    }
                } else {
                    $('#professionalSummaryCard').hide();
                }
            }

            $('#joining_as').on('change', handleJoiningAsChange);
            handleJoiningAsChange(); // run initially

            // ─── FAQ AJAX Search ────────────────────────────────────────
            let faqTimer;
            $('#faqSearch').on('input', function () {
                clearTimeout(faqTimer);
                const q = $(this).val().trim();
                if (q.length < 2) { $('#faqSuggestions').hide().empty(); return; }

                faqTimer = setTimeout(function () {
                    $.getJSON("{{ route('faq.search') }}", { search: q, crm_type: 'teachers_crm' }, function (data) {
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

                let pdfUrl = "{{ route('faq.pdf', ['faq' => '__ID__']) }}";
                pdfUrl = pdfUrl.replace('__ID__', faq.id);

                $('#faqPdfContainer').html(
                    faq.pdf_path
                        ? '<iframe src="' + pdfUrl + '" width="100%" height="640" style="border:none;border-radius:6px;"></iframe>'
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

                $.getJSON("{{ route('crm.teachers_crm.history') }}", { phone: phone }, function (records) {
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
                    'Paid': 'success', 'Confirm': 'success', 'Pending': 'warning',
                    'Cancel': 'danger', 'No Interaction': 'secondary', 'No Communication': 'dark', 'Switched Off': 'danger'
                };

                page.forEach(function (r) {
                    const cs = r.calling_status
                        ? `<span class="badge bg-${statusColor[r.calling_status] || 'secondary'}">${r.calling_status}</span>`
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
                                <td>${r.query_status || '—'}</td>
                                <td>${r.assigned_person || '—'}</td>
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