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

						<div class="form-group">
							<label for="catatan">Catatan</label>
							<textarea class="form-control form-control-sm" id="catatan"></textarea>
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

	var tanggalInput = $('#tanggal');
	var namaLengkapInput = $('#nama_lengkap');
	var quantityInput = $('#quantity');
	var catatanInput = $('#catatan');
	var btnSubmit = $('#btnSubmit');

	btnSubmit.off('click', btnSubmitHandler).on('click', btnSubmitHandler);

	function btnSubmitHandler(event){
		disableBtn();

		var tanggal = tanggalInput.val();
		var namaLengkap = namaLengkapInput.val();
		var quantity = parseInt(quantityInput.val().split('.').join(''));
		var catatan = catatanInput.val();

		if(!tanggal){
			alert('Pilih tanggal dulu!');
			enableBtn();
			return;
		}

		if(!namaLengkap){
			alert('Isi nama lengkap dulu!');
			enableBtn();
			return;
		}

		if(isNaN(quantity) || quantity < 1){
			alert('Isi jumlah dulu! (Harus lebih dari nol)');
			enableBtn();
			return;
		}

		var data = {
			transaction_at: tanggal,
			full_name: namaLengkap,
			quantity: quantity,
			description: catatan,
		};

		axios.post("{{ url('idep-report/create-log') }}", data)
			.then(function(resp){
				resetForm();
				enableBtn();
				showNotification('success', 'Data berhasil dibuat.', 'Sukses');
			})
			.catch(function(err){
				enableBtn();
				showNotification('danger', 'Data gagal dibuat.', 'Ada error');
			});
	}

	function resetForm(){
		namaLengkapInput.val('');
		quantityInput.val('');
		catatanInput.val('');
	}

	function enableBtn(){
		btnSubmit.removeAttr('disabled');
	}

	function disableBtn(){
		btnSubmit.attr({disabled: true});
	}
});
</script>
@endsection