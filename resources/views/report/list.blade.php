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
							<table class="table table-sm table-bordered" id="idepReportTable"></table>
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
	'listLogURL' => url('idep-report/data-log'),
]) !!};
</script>

@include('report.parts.mustache')

<script src="{{ asset('js/idep-report.js') .'?'. time() }}"></script>
@endsection
