{{-- <form method="POST"
    action="{{ $applied_applicant->aptitude_phase ? route('test.aptitude-test-update', $applied_applicant->aptitude_phase->uuid) : '#' }}">
    @csrf
    <input type="hidden" name="applicant_id" value="{{ $applied_applicant->id }}">
    <div class="row">
        <div class="col-sm-6">
            <select class="custom-select" name="aptitude_status" required>
                <option value="">Open this select menu</option>
                <option value="QUALIFIED"
                    {{ $applied_applicant->aptitude_phase->aptitude_status == 'QUALIFIED' ? 'selected' : '' }}>
                    QUALIFIED</option>
                <option value="DISQUALIFIED"
                    {{ $applied_applicant->aptitude_phase->aptitude_status == 'DISQUALIFIED' ? 'selected' : '' }}>
                    DISQUALIFIED</option>
            </select>
        </div>

        <div class="col-sm-6">
            <div class="form-group">
                <input type="text" class="form-control"
                    name="aptitude_marks"value="{{ $applied_applicant->aptitude_phase->aptitude_marks }}">
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
    action="{{ $applied_applicant->aptitude_phase ? route('test.aptitude-test-update', $applied_applicant->aptitude_phase->uuid) : '#' }}">
    @csrf
    <input type="hidden" name="applicant_id" value="{{ $applied_applicant->id }}">

    <div class="row">
        <div class="col-sm-6">
            <select class="custom-select" name="aptitude_status" required>
                <option value="">Open this select menu</option>
                <option value="QUALIFIED"
                    {{ isset($applied_applicant->aptitude_phase) && $applied_applicant->aptitude_phase->aptitude_status == 'QUALIFIED' ? 'selected' : '' }}>
                    QUALIFIED
                </option>
                <option value="PENDING"
                    {{ isset($applied_applicant->aptitude_phase) && $applied_applicant->aptitude_phase->aptitude_status == 'PENDING' ? 'selected' : '' }}>
                    PENDING
                </option>
                <option value="DISQUALIFIED"
                    {{ isset($applied_applicant->aptitude_phase) && $applied_applicant->aptitude_phase->aptitude_status == 'DISQUALIFIED' ? 'selected' : '' }}>
                    DISQUALIFIED
                </option>
            </select>
        </div>

        <div class="col-sm-6">
            <div class="form-group">
                <input type="text" class="form-control" name="aptitude_marks"
                    value="{{ isset($applied_applicant->aptitude_phase) ? $applied_applicant->aptitude_phase->aptitude_marks : '' }}">
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group row">
            <div class="col-sm-10">
                <button type="submit" class="btn btn-primary"
                    {{ !isset($applied_applicant->aptitude_phase) ? 'disabled' : '' }}>Update</button>
            </div>
        </div>
    </div>
</form>
