{{-- <form method="POST" action="{{ route('fitnesstest.basicfitness-update',  $applied_applicant->basicfitness->uuid) }}">
    @csrf
    <input type="hidden" name="applicant_id" value="{{ $applied_applicant->id }}">
    <div class="row">
        <div class="col-sm-6">
            <select class="custom-select" name="basic_fitness_status" required>
                <option value="">Open this select menu</option>
                <option value="QUALIFIED" {{  $applied_applicant->basicfitness->basic_fitness_status == 'QUALIFIED' ? 'selected' : '' }}>
                    QUALIFIED</option>
                <option value="DISQUALIFIED"
                    {{  $applied_applicant->basicfitness->basic_fitness_status == 'DISQUALIFIED' ? 'selected' : '' }}>
                    DISQUALIFIED</option>
            </select>
        </div>

        <div class="col-sm-6">
            <div class="form-group">
                <textarea class="form-control" name="basic_fitness_remarks" placeholder="Remarks">{{ old('basic_fitness_remarks',  $applied_applicant->basicfitness->basic_fitness_remarks) }}</textarea>
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
    action="{{ isset($applied_applicant->basicfitness) ? route('fitnesstest.basicfitness-update', $applied_applicant->basicfitness->uuid) : '#' }}">
    @csrf
    <input type="hidden" name="applicant_id" value="{{ $applied_applicant->id }}">

    <div class="row">
        <div class="col-sm-6">
            <select class="custom-select" name="basic_fitness_status" required>
                <option value="">Open this select menu</option>
                <option value="QUALIFIED"
                    {{ isset($applied_applicant->basicfitness) && $applied_applicant->basicfitness->basic_fitness_status == 'QUALIFIED' ? 'selected' : '' }}>
                    QUALIFIED
                </option>
                <option value="PENDING"
                    {{ isset($applied_applicant->basicfitness) && $applied_applicant->basicfitness->basic_fitness_status == 'PENDING' ? 'selected' : '' }}>
                    PENDING
                </option>
                <option value="DISQUALIFIED"
                    {{ isset($applied_applicant->basicfitness) && $applied_applicant->basicfitness->basic_fitness_status == 'DISQUALIFIED' ? 'selected' : '' }}>
                    DISQUALIFIED
                </option>
            </select>
        </div>

        <div class="col-sm-6">
            <div class="form-group">
                <textarea class="form-control" name="basic_fitness_remarks" placeholder="Remarks">{{ old('basic_fitness_remarks', isset($applied_applicant->basicfitness) ? $applied_applicant->basicfitness->basic_fitness_remarks : '') }}</textarea>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group row">
            <div class="col-sm-10">
                <button type="submit" class="btn btn-primary"
                    {{ !isset($applied_applicant->basicfitness) ? 'disabled' : '' }}>Update</button>
            </div>
        </div>
    </div>
</form>
