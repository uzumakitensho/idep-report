@extends('layouts.app')

@section('content')
<div class="container">
	<div class="row justify-content-center">
		<div class="col-md-12" style="margin-bottom: 20px;">
			<div class="card">
				<div class="card-header">Import</div>

				<div class="card-body">
					<div class="row">
						<div class="col-md-8">
							<form action="{{ url('employee/import') }}" method="post" class="form-inline" enctype="multipart/form-data">
								@csrf
								<div class="form-group mx-sm-3 mb-2">
									<label for="importFile" class="sr-only">File</label>
									<input type="file" class="form-control-file" name="import_file" id="importFile">
								</div>
								<button type="submit" class="btn btn-success mb-2">Import</button>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="col-md-12">
			<div class="card">
				<div class="card-header">Daftar Karyawan</div>

				<div class="card-body">
					<div class="row">
						<div class="col-md-8">
							<table class="table table-sm table-bordered" id="employeeTable">
								<thead>
									<tr>
										<th>Nama</th>
										<th>Total Semua Idep</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
									@foreach($employees as $employee)
									<tr>
										<td>{{ $employee->full_name }}</td>
										<td>{{ $employee->total_all_quantity }}</td>
										<td>
											<a href="#" class="btn btn-sm btn-primary">Detail</a>
										</td>
									</tr>
									@endforeach	
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection

@section('content-js')
<script>
$('#employeeTable').DataTable();
</script>
@endsection
