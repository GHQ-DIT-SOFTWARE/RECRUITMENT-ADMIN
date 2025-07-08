{{-- <form method="POST" action="{{ route('test.interview-update', $applied_applicant->interview_phase->uuid) }}">
    @csrf
    <input type="hidden" name="applicant_id" value="{{ $applied_applicant->id }}">
    <div class="row">
        <div class="col-sm-6">
            <select class="custom-select" name="interview_status" required>
                <option value="">Open this select menu</option>
                <option value="QUALIFIED"
                    {{ $applied_applicant->interview_phase->interview_status == 'QUALIFIED' ? 'selected' : '' }}>
                    QUALIFIED</option>
                <option value="DISQUALIFIED"
                    {{ $applied_applicant->interview_phase->interview_status == 'DISQUALIFIED' ? 'selected' : '' }}>
                    DISQUALIFIED</option>
            </select>
        </div>

        <div class="col-sm-6">
            <div class="form-group">
                <input type="text" class="form-control"
                    name="interview_marks"value="{{ $applied_applicant->interview_phase->interview_marks }}">
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
<form method="POST" action="{{ isset($applied_applicant->interview_phase) ? route('test.interview-update', $applied_applicant->interview_phase->uuid) : '#' }}">
    @csrf
    <input type="hidden" name="applicant_id" value="{{ $applied_applicant->id }}">

    <div class="row">
        <div class="col-sm-6">
            <select class="custom-select" name="interview_status" required>
                <option value="">Open this select menu</option>
                <option value="QUALIFIED"
                    {{ isset($applied_applicant->interview_phase) && $applied_applicant->interview_phase->interview_status == 'QUALIFIED' ? 'selected' : '' }}>
                    QUALIFIED
                </option>
                <option value="PENDING"
                    {{ isset($applied_applicant->interview_phase) && $applied_applicant->interview_phase->interview_status == 'PENDING' ? 'selected' : '' }}>
                    PENDING
                </option>
                <option value="DISQUALIFIED"
                    {{ isset($applied_applicant->interview_phase) && $applied_applicant->interview_phase->interview_status == 'DISQUALIFIED' ? 'selected' : '' }}>
                    DISQUALIFIED
                </option>
            </select>
        </div>

        <div class="col-sm-6">
            <div class="form-group">
                <input type="text" class="form-control" name="interview_marks"
                    value="{{ isset($applied_applicant->interview_phase) ? $applied_applicant->interview_phase->interview_marks : '' }}">
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group row">
            <div class="col-sm-10">
                <button type="submit" class="btn btn-primary" {{ !isset($applied_applicant->interview_phase) ? 'disabled' : '' }}>Update</button>
            </div>
        </div>
    </div>
</form>
