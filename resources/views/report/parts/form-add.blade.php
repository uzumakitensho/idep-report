<div class="col-md-12" style="margin-bottom: 20px;" id="formAddData">
	<div class="card">
		<div class="card-header">Tambah Data</div>

		<div class="card-body">
			<div class="row">
				<div class="col-md-6">
					<form>
						<div class="form-group">
							<label for="tanggal">Tahun - Bulan - Tanggal</label>
							<input type="text" class="form-control form-control-sm input-date-month" id="tanggal" readonly value="{{ \Carbon\Carbon::now()->format('Y-m-d') }}">
						</div>

						<div class="form-group">
							<label for="tipe_idep">Tipe</label>
							<input type="text" class="form-control form-control-sm input-autocomplete" id="tipe_idep" data-url="{{ url('idep-report/data-type') }}" autocomplete="off">
						</div>

						<div class="form-group">
							<label for="nama_lengkap">Nama Lengkap</label>
							<input type="text" class="form-control form-control-sm input-autocomplete" id="nama_lengkap" data-url="{{ url('idep-report/data-employee') }}" autocomplete="off">
						</div>

						<div class="form-group">
							<label for="quantity">Jumlah</label>
							<input type="text" class="form-control form-control-sm input-number-format" id="quantity">
						</div>

						<div class="form-group" style="display: none;">
							<label for="catatan">Catatan</label>
							<textarea class="form-control form-control-sm" id="catatan"></textarea>
						</div>

						<button type="button" class="btn btn-secondary btn-sm" id="btnSubmit">Submit</button>
					</form>
				</div>

				<div class="col-md-6">
					<h3>Detail Tanggal Terpilih</h3>
					<table class="table table-sm table-bordered" id="detailSelectedTable"></table>
				</div>
			</div>
		</div>
	</div>
</div>