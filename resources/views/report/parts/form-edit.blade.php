<div class="col-md-6" style="margin-bottom: 20px;" id="formEditData">
	<div class="card">
		<div class="card-header">Edit Data</div>

		<div class="card-body">
			<div class="row">
				<div class="col-md-12">
					<form>
						<input type="hidden" id="uuid_edit">
						
						<div class="form-group">
							<label for="tanggal">Tahun - Bulan - Tanggal</label>
							<input type="text" class="form-control form-control-sm input-date-month" id="tanggal_edit" readonly>
						</div>

						<div class="form-group">
							<label for="tipe_idep">Tipe</label>
							<input type="text" class="form-control form-control-sm input-autocomplete" id="tipe_idep_edit" data-url="{{ url('idep-report/data-type') }}" autocomplete="off">
						</div>

						<div class="form-group">
							<label for="nama_lengkap">Nama Lengkap</label>
							<input type="text" class="form-control form-control-sm input-autocomplete" id="nama_lengkap_edit" data-url="{{ url('idep-report/data-employee') }}" autocomplete="off">
						</div>

						<div class="form-group">
							<label for="quantity">Jumlah</label>
							<input type="text" class="form-control form-control-sm input-number-format" id="quantity_edit">
						</div>

						<div class="form-group" style="display: none;">
							<label for="catatan">Catatan</label>
							<textarea class="form-control form-control-sm" id="catatan_edit"></textarea>
						</div>

						<button type="button" class="btn btn-secondary btn-sm" id="btnCancelEdit">Cancel</button>

						<button type="button" class="btn btn-primary btn-sm" id="btnSubmitEdit">Submit</button>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>