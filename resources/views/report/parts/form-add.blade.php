<div class="col-md-12" style="margin-bottom: 20px;">
	<div class="card">
		<div class="card-header">Tambah Data</div>

		<div class="card-body">
			<div class="row">
				<div class="col-md-8">
					<form>
						<div class="form-group">
							<label for="tanggal">Tahun - Bulan</label>
							<input type="text" class="form-control form-control-sm input-date-month" id="tanggal" readonly value="{{ \Carbon\Carbon::now()->format('Y-m') }}">
						</div>
						<div class="form-group">
							<label for="nama_lengkap">Nama Lengkap</label>
							<input type="text" class="form-control form-control-sm input-autocomplete" id="nama_lengkap" data-url="{{ url('idep-report/data-employee') }}" autocomplete="off">
						</div>
						<div class="form-group">
							<label for="quantity">Jumlah</label>
							<input type="text" class="form-control form-control-sm input-number-format" id="quantity">
						</div>
						<button type="button" class="btn btn-secondary btn-sm" id="btnSubmit">Submit</button>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>

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

$('.input-autocomplete').autoComplete({
	bootstrapVersion: '4',
	minLength: 1,
});

$('.input-number-format').maskNumber({
	integer: true,
	thousands: '.',
	decimal: ','
});

$(document).ready(function(){
	$('#btnSubmit').off('click', btnSubmitHandler).on('click', btnSubmitHandler);

	function btnSubmitHandler(event){
		var tanggal = $('#tanggal').val();
		var namaLengkap = $('#nama_lengkap').val();
		var quantity = $('#quantity').val();

		console.log(tanggal);
		console.log(namaLengkap);
		console.log(quantity);
	}
});
</script>
@endsection