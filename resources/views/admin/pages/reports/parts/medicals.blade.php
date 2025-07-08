{{-- <form method="POST" action="{{ route('test.medical-update',$applied_applicant->medicals_phase->uuid) }}">
    @csrf
    <input type="hidden" name="applicant_id" value="{{ $applied_applicant->id }}">
    <div class="row">
        <div class="col-sm-6">
            <select class="custom-select" name="medical_status" required>
                <option value="">Open this select menu</option>
                <option value="QUALIFIED" {{$applied_applicant->medicals_phase->medical_status == 'QUALIFIED' ? 'selected' : '' }}>
                    QUALIFIED</option>
                <option value="DISQUALIFIED" {{$applied_applicant->medicals_phase->medical_status == 'DISQUALIFIED' ? 'selected' : '' }}>
                    DISQUALIFIED</option>
            </select>
        </div>

        <div class="col-sm-6">
            <div class="form-group">
                <textarea class="form-control" name="medical_remarks" placeholder="Remarks">{{ old('medical_remarks',$applied_applicant->medicals_phase->medical_remarks) }}</textarea>
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
    action="{{ isset($applied_applicant->medicals_phase) ? route('test.medical-update', $applied_applicant->medicals_phase->uuid) : '#' }}">
    @csrf
    <input type="hidden" name="applicant_id" value="{{ $applied_applicant->id }}">

    <div class="row">
        <div class="col-sm-6">
            <select class="custom-select" name="medical_status" required>
                <option value="">Open this select menu</option>
                <option value="QUALIFIED"
                    {{ isset($applied_applicant->medicals_phase) && $applied_applicant->medicals_phase->medical_status == 'QUALIFIED' ? 'selected' : '' }}>
                    QUALIFIED
                </option>
                <option value="PENDING"
                    {{ isset($applied_applicant->medicals_phase) && $applied_applicant->medicals_phase->medical_status == 'PENDING' ? 'selected' : '' }}>
                    PENDING
                </option>
                <option value="DISQUALIFIED"
                    {{ isset($applied_applicant->medicals_phase) && $applied_applicant->medicals_phase->medical_status == 'DISQUALIFIED' ? 'selected' : '' }}>
                    DISQUALIFIED
                </option>
            </select>
        </div>

        <div class="col-sm-6">
            <div class="form-group">
                <textarea class="form-control" name="medical_remarks" placeholder="Remarks">{{ old('medical_remarks', isset($applied_applicant->medicals_phase) ? $applied_applicant->medicals_phase->medical_remarks : '') }}</textarea>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group row">
            <div class="col-sm-10">
                <button type="submit" class="btn btn-primary"
                    {{ !isset($applied_applicant->medicals_phase) ? 'disabled' : '' }}>Update</button>
            </div>
        </div>
    </div>
</form>
