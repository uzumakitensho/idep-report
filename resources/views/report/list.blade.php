@extends('layouts.app')

@section('content')
<div class="container">
	<div class="row justify-content-center">
		@include('report.parts.form-add')

		<div class="col-md-12">
			<div class="card">
				<div class="card-header">Daftar</div>

				<div class="card-body">
					<div class="row">
						<div class="col-md-8">
							<h3>Daftar</h3>
							<table class="table table-sm table-bordered">
								<thead>
									<tr>
										<th>Nama</th>
										<th>Total</th>
										<th width="3%">Action</th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td>aasas</td>
										<td>0</td>
										<td>
											<div class="dropdown">
												<button class="btn btn-sm btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
													Dropdown button
												</button>
												<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
													<a class="dropdown-item" href="#">Detail</a>
												</div>
											</div>
										</td>
									</tr>
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
$('.input-date-month').datepicker({
	format: "yyyy-mm",
	autoclose: true,
	todayHighlight: true,
	todayBtn: "linked",
	minViewMode: 1,
	endDate: "0d",
});

$('.input-autocomplete').autoComplete();
</script>
@endsection
