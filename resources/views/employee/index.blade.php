@extends('_layout.main')
@section('title', __('sidebar.label.employee'))
@section('content')

{{ Breadcrumbs::render('employee_list') }}

<div class="row">
  <div class="col-lg">
    <div class="card">
      <div class="card-body">
        <div class="card-header d-flex align-items-center py-0">
          <h5 class="card-title mb-0 py-3">{{ __('sidebar.label.employee_list') }}</h5>
          @can('create employee')
            <div class="ms-auto my-auto">
              <a class="btn btn-tosca" href="{{route('employee.add')}}"><i class="ri-add-circle-line"></i></a>
            </div>
          @endcan
        </div>

        <!-- Table with hoverable rows -->
        <table class="table datatable table-hover">
          <thead>
            <tr>
              <th scope="col">#</th>
              <th scope="col">{{ __('employee.label.full_name') }}</th>
              <th scope="col">{{ __('employee.label.full_name') }}</th>
              <th scope="col">{{ __('employee.label.employee_status') }}</th>
              <th scope="col">{{ __('employee.label.position') }}</th>
              <th scope="col">{{ __('employee.label.job_title') }}</th>
              <th scope="col">{{ __('employee.label.division') }}</th>
              <th scope="col">{{ __('employee.label.department') }}</th>
              <th scope="col">{{ __('employee.label.sales_status') }}</th>
              <th scope="col">
                <button type="button" id="customButton" class="btn btn-untosca" data-bs-toggle="modal" data-bs-target="#columnsModal">
                  {{ __('employee.label.custom') }}
                </button>
              </th>
              
            </tr>
          </thead>
          <tbody>
            @foreach($employee as $no=>$data)
            <tr onclick="window.open('{{ route('employee.detail', $data->id) }}', '_blank')">

              <th scope="row">{{ $no+1 }}</th>
              <td>{{ $data->eid }}</td>
              <td>{{ $data->name }}</td>
              <td>{{ $data->employeeStatus->name ?? '-' }}</td>
              <td>{{ $data->position->name ?? '-' }}</td>
              <td>{{ $data->position->job_title->name ?? '-' }}</td>
              <td>{{ $data->position->division->name ?? '-' }}</td>
              <td>{{ $data->position->department->name ?? '-' }}</td>
              <td>{!! $data->sales_status == 1 ? '<i class="ri-check-double-fill"></i>' : '-' !!}</td>
              <td>

              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
        <!-- End Table with hoverable rows -->

      </div>
    </div>
  </div>
</div>
@section('script')
<script>
  document.addEventListener("DOMContentLoaded", function () {
  const customButton = document.getElementById("customButton");
  const columnsSelect = document.getElementById("columns");

  // Event listener saat form disubmit
  document.querySelector("form").addEventListener("submit", function (e) {
    e.preventDefault(); // Mencegah submit form untuk testing

    // Ambil nilai yang dipilih
    const selectedColumns = Array.from(columnsSelect.selectedOptions).map(option => option.value);

    // Update teks tombol
    if (selectedColumns.length > 0) {
      customButton.textContent = selectedColumns.join(", ");
    } else {
      customButton.textContent = "custom";
    }

    // Kirim request ke server menggunakan route
    fetch("{{ route('employee.updateTableColumns') }}", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
        "X-CSRF-TOKEN": "{{ csrf_token() }}"
      },
      body: JSON.stringify({ columns: selectedColumns })
    })
    .then(response => response.json())
    .then(data => {
      // Update tabel dengan data karyawan
      updateEmployeeTable(data);
    })
    .catch(error => console.error('Error:', error));

    // Tutup modal
    const modal = bootstrap.Modal.getInstance(document.getElementById('columnsModal'));
    modal.hide();
  });
});

function updateEmployeeTable(data) {
  const tableBody = document.querySelector("table tbody");
  tableBody.innerHTML = ""; // Kosongkan tabel sebelum update

  // Menampilkan data karyawan berdasarkan kolom yang dipilih
  data.employees.forEach(employee => {
    const tr = document.createElement("tr");

    data.columns.forEach(column => {
      const td = document.createElement("td");
      td.textContent = employee[column] || "-"; // Tampilkan "-" jika data tidak ada
      tr.appendChild(td);
    });

    tableBody.appendChild(tr);
  });
}

  // document.addEventListener("DOMContentLoaded", function () {
  //   const customButton = document.getElementById("customButton");
  //   const columnsSelect = document.getElementById("columns");

  //   // Event listener saat form disubmit
  //   document.querySelector("form").addEventListener("submit", function (e) {
  //     e.preventDefault(); // Mencegah submit form untuk testing

  //     // Ambil nilai yang dipilih
  //     const selectedColumns = Array.from(columnsSelect.selectedOptions).map(option => option.text);

  //     // Update teks tombol
  //     if (selectedColumns.length > 0) {
  //       customButton.textContent = selectedColumns.join(", ");
  //     } else {
  //       customButton.textContent = "custom";
  //     }

  //     // Tutup modal
  //     const modal = bootstrap.Modal.getInstance(document.getElementById('columnsModal'));
  //     modal.hide();
  //   });
  // });
</script>

@endsection
@endsection
@include('employee.custom_column')