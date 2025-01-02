<form action="{{ $action }}" method="GET" class="mb-3">
    <div class="row">
        <div class="col-md-2">
            <label for="month" class="form-label">Select Month</label>
            <select class="form-select" name="month">
                @foreach (range(1, 12) as $month)
                    <option value="{{ DateTime::createFromFormat('!m', $month)->format('F') }}" 
                        {{ $selectedMonth == DateTime::createFromFormat('!m', $month)->format('F') ? 'selected' : '' }}>
                        {{ DateTime::createFromFormat('!m', $month)->format('F') }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="col-md-2">
            <label for="year" class="form-label">Select Year</label>
            <select class="form-select" name="year">
                @foreach (range(date('Y') - 1, date('Y') + 5) as $year)
                    <option value="{{ $year }}" {{ $selectedYear == $year ? 'selected' : '' }}>
                        {{ $year }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="col-md-3 align-self-end">
            <button type="submit" class="btn btn-tosca">Filter</button>
        </div>
    </div>
</form>
