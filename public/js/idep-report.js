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

	namaLengkapInput.focus();
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

		axios.post(window.Laravel.idepReport.createLogURL, data)
			.then(function(resp){
				resetForm();
				enableBtn();
				showNotification('success', 'Data berhasil dibuat.', 'Sukses');
				namaLengkapInput.focus();
				renderReportTable();
			})
			.catch(function(err){
				enableBtn();
				showNotification('danger', 'Data gagal dibuat.', 'Ada error');
				namaLengkapInput.focus();
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

	renderReportTable();
	function renderReportTable(){
		axios.post(window.Laravel.idepReport.listLogURL, {})
			.then(function(resp){
				var dataRender = {
					idepLogs: resp.data.result.logs
				};

				var mustacheTmpl = $('#idepReportListTmplt').html();
				Mustache.parse(mustacheTmpl);
				var rendered = Mustache.render(mustacheTmpl, dataRender);

				$("#idepReportTable").html(rendered);

				var idepReportTable = $("#idepReportTable").DataTable();
				idepReportTable.destroy();

				var idepReportTable = $("#idepReportTable").DataTable();

			})
			.catch(function(err){
				showNotification('danger', 'Data gagal dimuat.', 'Ada error');
			});
	}
});