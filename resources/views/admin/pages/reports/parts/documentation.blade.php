
<form method="POST"action="{{ isset($applied_applicant->documentation_phase) ? route('document.documentation-update', $applied_applicant->documentation_phase->uuid) : '#' }}">
    @csrf
    <input type="hidden" name="applicant_id" value="{{ $applied_applicant->id }}">
    <div class="row">
        <div class="col-sm-6">
            <select class="custom-select" name="documentation_status" required>
                <option value="">Open this select menu</option>
                <option value="QUALIFIED"
                    {{ isset($applied_applicant->documentation_phase) && $applied_applicant->documentation_phase->documentation_status == 'QUALIFIED' ? 'selected' : '' }}>
                    QUALIFIED
                </option>
                <option value="PENDING"
                    {{ isset($applied_applicant->documentation_phase) && $applied_applicant->documentation_phase->documentation_status == 'PENDING' ? 'selected' : '' }}>
                    PENDING
                </option>
                <option value="DISQUALIFIED"
                    {{ isset($applied_applicant->documentation_phase) && $applied_applicant->documentation_phase->documentation_status == 'DISQUALIFIED' ? 'selected' : '' }}>
                    DISQUALIFIED
                </option>
            </select>
        </div>

        <div class="col-sm-6">
            <div class="form-group">
                <textarea class="form-control" name="documentation_remarks" placeholder="Remarks">{{ old('documentation_remarks', isset($applied_applicant->documentation_phase) ? $applied_applicant->documentation_phase->documentation_remarks : '') }}</textarea>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group row">
            <div class="col-sm-10">
                <button type="submit" class="btn btn-primary"
                    {{ !isset($applied_applicant->documentation_phase) ? 'disabled' : '' }}>Update</button>
            </div>
        </div>
    </div>
</form>
