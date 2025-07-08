{{-- <form method="POST"
    action="{{ route('bodyselection.body-selection-update', $applied_applicant->bodySelection_phase->uuid) }}">
    @csrf
    <input type="hidden" name="applicant_id" value="{{ $applied_applicant->id }}">
    <div class="row">
        <div class="col-sm-6">
            <select class="custom-select" name="body_selection_status" required>
                <option value="">Open this select menu</option>
                <option value="QUALIFIED"
                    {{ $applied_applicant->bodySelection_phase->body_selection_status == 'QUALIFIED' ? 'selected' : '' }}>
                    QUALIFIED</option>
                <option value="DISQUALIFIED"
                    {{ $applied_applicant->bodySelection_phase->body_selection_status == 'DISQUALIFIED' ? 'selected' : '' }}>
                    DISQUALIFIED</option>
            </select>
        </div>

        <div class="col-sm-6">
            <div class="form-group">
                <textarea class="form-control" name="body_selection_remarks" placeholder="Remarks">{{ old('body_selection_remarks', $applied_applicant->bodySelection_phase->body_selection_remarks) }}</textarea>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group row">
            <div class="col-sm-10">
                <button type="submit" class="btn btn-primary">Update</button>
            </div>
        </div>
    </div>
</form> --}}

<form method="POST"
    action="{{ isset($applied_applicant->bodySelection_phase) ? route('bodyselection.body-selection-update', $applied_applicant->bodySelection_phase->uuid) : '#' }}">
    @csrf
    <input type="hidden" name="applicant_id" value="{{ $applied_applicant->id }}">

    <div class="row">
        <div class="col-sm-6">
            <select class="custom-select" name="body_selection_status" required>
                <option value="">Open this select menu</option>
                <option value="QUALIFIED"
                    {{ isset($applied_applicant->bodySelection_phase) && $applied_applicant->bodySelection_phase->body_selection_status == 'QUALIFIED' ? 'selected' : '' }}>
                    QUALIFIED
                </option>
                <option value="PENDING"
                    {{ isset($applied_applicant->bodySelection_phase) && $applied_applicant->bodySelection_phase->body_selection_status == 'PENDING' ? 'selected' : '' }}>
                    PENDING
                </option>
                <option value="DISQUALIFIED"
                    {{ isset($applied_applicant->bodySelection_phase) && $applied_applicant->bodySelection_phase->body_selection_status == 'DISQUALIFIED' ? 'selected' : '' }}>
                    DISQUALIFIED
                </option>
            </select>
        </div>

        <div class="col-sm-6">
            <div class="form-group">
                <textarea class="form-control" name="body_selection_remarks" placeholder="Remarks">{{ old('body_selection_remarks', isset($applied_applicant->bodySelection_phase) ? $applied_applicant->bodySelection_phase->body_selection_remarks : '') }}</textarea>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group row">
            <div class="col-sm-10">
                <button type="submit" class="btn btn-primary"
                    {{ !isset($applied_applicant->bodySelection_phase) ? 'disabled' : '' }}>Update</button>
            </div>
        </div>
    </div>
</form>
