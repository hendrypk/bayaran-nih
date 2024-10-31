@extends('_layout.main')

@section('title', 'Import Presence')

@section('content')

<div class="row">
    <div class="col-lg">
        <div class="card">
            <div class="card-body">

                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                <h5 class="card-title">Import Presence Data</h5>

                <!-- Import Form -->
                <form action="{{ route('import') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="file" class="form-label">Excel File</label>
                        <input type="file" class="form-control" id="file" name="file" required>
                        @error('file')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary" id="importButton">Import</button>
                </form>
                <!-- End Import Form -->
            </div>
        </div>
    </div>
</div>
@section('script')

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.getElementById('importButton', 'file').addEventListener('click', function(event) {
        event.preventDefault(); // Mencegah form submit langsung

        // Menampilkan SweetAlert2
        Swal.fire({
            icon: 'warning',
            title: 'Warning',
            text: 'System is under maintenance. Plesae try again later',
            confirmButtonText: 'OK'
        });
    });
</script>
@endsection
@endsection
