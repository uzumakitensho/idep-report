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