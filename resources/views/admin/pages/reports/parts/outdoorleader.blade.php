{{-- <form method="POST" action="{{ route('test.outdoorlesstest-update', $applied_applicant->outdoorfitness_phase->uuid) }}">
    @csrf
    <input type="hidden" name="applicant_id" value="{{ $applied_applicant->id }}">
    <div class="row">
        <div class="col-sm-6">
            <select class="custom-select" name="outdoorleaderless_status" required>
                <option value="">Open this select menu</option>
                <option value="QUALIFIED"
                    {{ $applied_applicant->outdoorfitness_phase->outdoorleaderless_status == 'QUALIFIED' ? 'selected' : '' }}>
                    QUALIFIED</option>
                <option value="DISQUALIFIED"
                    {{ $applied_applicant->outdoorfitness_phase->outdoorleaderless_status == 'DISQUALIFIED' ? 'selected' : '' }}>
                    DISQUALIFIED</option>
            </select>
        </div>

        <div class="col-sm-6">
            <div class="form-group">
                <textarea class="form-control" name="outdoorleaderless_remarks" placeholder="Remarks">{{ old('outdoorleaderless_remarks', $applied_applicant->outdoorfitness_phase->outdoorleaderless_remarks) }}</textarea>
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
<form method="POST" action="{{ isset($applied_applicant->outdoorfitness_phase) ? route('test.outdoorlesstest-update', $applied_applicant->outdoorfitness_phase->uuid) : '#' }}">
    @csrf
    <input type="hidden" name="applicant_id" value="{{ $applied_applicant->id }}">

    <div class="row">
        <div class="col-sm-6">
            <select class="custom-select" name="outdoorleaderless_status" required>
                <option value="">Open this select menu</option>
                <option value="QUALIFIED" {{ isset($applied_applicant->outdoorfitness_phase) && $applied_applicant->outdoorfitness_phase->outdoorleaderless_status == 'QUALIFIED' ? 'selected' : '' }}>
                    QUALIFIED
                </option>
                <option value="PENDING" {{ isset($applied_applicant->outdoorfitness_phase) && $applied_applicant->outdoorfitness_phase->outdoorleaderless_status == 'PENDING' ? 'selected' : '' }}>
                    PENDING
                </option>
                <option value="DISQUALIFIED" {{ isset($applied_applicant->outdoorfitness_phase) && $applied_applicant->outdoorfitness_phase->outdoorleaderless_status == 'DISQUALIFIED' ? 'selected' : '' }}>
                    DISQUALIFIED
                </option>
            </select>
        </div>

        <div class="col-sm-6">
            <div class="form-group">
                <textarea class="form-control" name="outdoorleaderless_remarks" placeholder="Remarks">{{ old('outdoorleaderless_remarks', isset($applied_applicant->outdoorfitness_phase) ? $applied_applicant->outdoorfitness_phase->outdoorleaderless_remarks : '') }}</textarea>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group row">
            <div class="col-sm-10">
                <button type="submit" class="btn btn-primary" {{ !isset($applied_applicant->outdoorfitness_phase) ? 'disabled' : '' }}>Update</button>
            </div>
        </div>
    </div>
</form>
