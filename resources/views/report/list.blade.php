@extends('layouts.app')

@section('content')
<div class="container">
	<div class="row justify-content-center">
		@include('report.parts.form-edit')
		@include('report.parts.form-add')

		<div class="col-md-12">
			<div class="card">
				<div class="card-header">Daftar</div>

				<div class="card-body">
					<div class="row" style="margin-bottom: 20px;">
						<div class="col-md-8">
							<h3>Log Input</h3>
							<table class="table table-sm table-bordered" id="idepReportLogInputTable"></table>
						</div>
					</div>

					<div class="row" style="margin-bottom: 20px; display: none;">
						<div class="col-md-8">
							<h3>Daftar by Karyawan</h3>
							<table class="table table-sm table-bordered" id="idepReportTable"></table>
						</div>
					</div>

					<div class="row" style="margin-bottom: 20px; display: none;">
						<div class="col-md-8">
							<h3>Daftar by Tanggal</h3>
							<table class="table table-sm table-bordered" id="idepReportByDateTable"></table>
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
window.Laravel.idepReport = {!! json_encode([
	'createLogURL' => url('idep-report/create-log'),
	'editLogURL' => url('idep-report/edit-log'),
	'deleteLogURL' => url('idep-report/delete-log'),
	'listLogURL' => url('idep-report/data-log'),
]) !!};
</script>

@include('report.parts.mustache')

<script src="{{ asset('js/idep-report.js') .'?'. time() }}"></script>
@endsection
