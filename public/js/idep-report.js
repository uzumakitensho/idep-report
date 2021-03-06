$('.input-date-month').datepicker({
	format: "yyyy-mm-dd",
	autoclose: true,
	todayHighlight: true,
	todayBtn: "linked",
	minViewMode: 0,
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
	var tipeIdepInput = $('#tipe_idep');
	var namaLengkapInput = $('#nama_lengkap');
	var quantityInput = $('#quantity');
	var catatanInput = $('#catatan');
	var btnSubmit = $('#btnSubmit');

	namaLengkapInput.focus();

	tanggalInput.off('change', tanggalInputHandler).on('change', tanggalInputHandler);
	function tanggalInputHandler(event){
		renderReportTable();
	}

	btnSubmit.off('click', btnSubmitHandler).on('click', btnSubmitHandler);
	function btnSubmitHandler(event){
		disableAddBtn();

		var tanggal = tanggalInput.val();
		var tipeIdep = tipeIdepInput.val();
		var namaLengkap = namaLengkapInput.val();
		var quantity = parseInt(quantityInput.val().split('.').join(''));
		var catatan = catatanInput.val();

		if(!tanggal){
			alert('Pilih tanggal dulu!');
			enableAddBtn();
			return;
		}

		if(!namaLengkap){
			alert('Isi nama lengkap dulu!');
			enableAddBtn();
			return;
		}

		if(isNaN(quantity) || quantity < 1){
			alert('Isi jumlah dulu! (Harus lebih dari nol)');
			enableAddBtn();
			return;
		}

		var data = {
			transaction_at: tanggal,
			idep_type: tipeIdep,
			full_name: namaLengkap,
			quantity: quantity,
			description: catatan,
		};

		axios.post(window.Laravel.idepReport.createLogURL, data)
			.then(function(resp){
				resetCreateForm();
				enableAddBtn();
				showNotification('success', 'Data berhasil dibuat.', 'Sukses');
				namaLengkapInput.focus();
				renderReportTable();
			})
			.catch(function(err){
				enableAddBtn();
				showNotification('danger', 'Data gagal dibuat.', 'Ada error');
				namaLengkapInput.focus();
			});
	}

	function resetCreateForm(){
		namaLengkapInput.val('');
		quantityInput.val('');
		catatanInput.val('');
	}

	function enableAddBtn(){
		btnSubmit.removeAttr('disabled');
	}

	function disableAddBtn(){
		btnSubmit.attr({disabled: true});
	}

	renderReportTable();
	async function renderReportTable(){
		var selectedDate = tanggalInput.val();
		await axios.post(window.Laravel.idepReport.listLogURL, {selected_date: selectedDate})
			.then(function(resp){
				var dataRender = {
					idepLogs: resp.data.result.logs
				};
				parseMustacheTemplate(dataRender, 'idepReportListTmplt', 'idepReportTable');

				var dataRender = {
					idepLogs: resp.data.result.logsByDate
				}
				parseMustacheTemplate(dataRender, 'idepReportListByDateTmplt', 'idepReportByDateTable');

				var dataRender = {
					idepLogs: resp.data.result.logsBySelectedDate
				}
				parseMustacheTemplate(dataRender, 'detailSelectedTmplt', 'detailSelectedTable');

				var dataRender = {
					idepLogs: resp.data.result.inputLogsDate
				}
				parseMustacheTemplate(dataRender, 'idepReportLogInputDate', 'idepReportLogInputTable');

			})
			.catch(function(err){
				showNotification('danger', 'Data gagal dimuat.', 'Ada error');
			});
	}

	function parseMustacheTemplate(dataRender, templateId, renderPlaceId){
		if(typeof dataRender !== 'object') dataRender = {};

		var mustacheTmpl = $(`#${templateId}`).html();
		Mustache.parse(mustacheTmpl);
		var rendered = Mustache.render(mustacheTmpl, dataRender);

		var renderPlace = $(`#${renderPlaceId}`);

		renderPlace.html(rendered);

		var idepReportTable = renderPlace.DataTable();
		idepReportTable.destroy();

		var idepReportTable = renderPlace.DataTable();

		rebind();
	}

	$('#idepReportLogInputTable').on('draw.dt', function(){
		rebind();
	});

	function rebind(){
		$('.btn-edit-log').off('click', btnEditLogHandler).on('click', btnEditLogHandler);
		$('.btn-del-log').off('click', btnDeleteLogHandler).on('click', btnDeleteLogHandler);
	}

	$('#formAddData').removeClass('hidden');
	$('#formEditData').addClass('hidden');

	function btnEditLogHandler(event){
		$('#formAddData').addClass('hidden');
		$('#formEditData').removeClass('hidden');

		var uuid = $(this).data('uuid');
		var transdate = $(this).data('transdate');
		var typename = $(this).data('typename');
		var fullname = $(this).data('fullname');
		var quantity = $(this).data('quantity');
		var description = $(this).data('description');

		$('#uuid_edit').val(uuid);
		$('#tanggal_edit').val(transdate);
		$('#tipe_idep_edit').val(typename);
		$('#nama_lengkap_edit').val(fullname);
		$('#quantity_edit').val(quantity);
		$('#catatan_edit').val(description);

		$('#quantity_edit').focus();

		$('html, body').animate({
			scrollTop: $("#formEditData").offset().top
		}, 500);
	}

	$('#btnCancelEdit').off('click', btnCancelEditHandler).on('click', btnCancelEditHandler);
	function btnCancelEditHandler(event){
		$('#formAddData').removeClass('hidden');
		$('#formEditData').addClass('hidden');

		resetEditForm();

		$('html, body').animate({
			scrollTop: $("#formAddData").offset().top
		}, 500);
	}

	$('#btnSubmitEdit').off('click', btnSubmitEditHandler).on('click', btnSubmitEditHandler);
	async function btnSubmitEditHandler(event){
		var ans = confirm('Apakah anda yakin?');
		if(!ans) return;

		disableEditBtn();

		var uuid = $('#uuid_edit').val();
		var tanggal = $('#tanggal_edit').val();
		var tipeIdep = $('#tipe_idep_edit').val();
		var namaLengkap = $('#nama_lengkap_edit').val();
		var quantity = parseInt($('#quantity_edit').val().split('.').join(''));
		var catatan = $('#catatan_edit').val();

		if(!tanggal){
			alert('Pilih tanggal dulu!');
			enableAddBtn();
			return;
		}

		if(!namaLengkap){
			alert('Isi nama lengkap dulu!');
			enableAddBtn();
			return;
		}

		if(isNaN(quantity) || quantity < 1){
			alert('Isi jumlah dulu! (Harus lebih dari nol)');
			enableAddBtn();
			return;
		}

		var data = {
			transaction_at: tanggal,
			idep_type: tipeIdep,
			full_name: namaLengkap,
			quantity: quantity,
			description: catatan,
		};

		var editUrl = window.Laravel.idepReport.editLogURL +'/'+ uuid;
		await axios.post(editUrl, data)
			.then(function(resp){
				resetEditForm();
				enableEditBtn();
				showNotification('success', 'Data berhasil diperbaharui.', 'Sukses');
				renderReportTable();

				$('#formAddData').removeClass('hidden');
				$('#formEditData').addClass('hidden');
				namaLengkapInput.focus();

				$('html, body').animate({
					scrollTop: $("#formAddData").offset().top
				}, 500);
			})
			.catch(function(err){
				enableEditBtn();
				showNotification('danger', 'Data gagal diperbaharui.', 'Ada error');
				namaLengkapInput.focus();
			});
	}

	function resetEditForm(){
		$('#uuid_edit').val('');
		$('#tanggal_edit').val('');
		$('#tipe_idep_edit').val('');
		$('#nama_lengkap_edit').val('');
		$('#quantity_edit').val('');
		$('#catatan_edit').val('');
	}

	function enableEditBtn(){
		$('#btnSubmitEdit').removeAttr('disabled');
	}

	function disableEditBtn(){
		$('#btnSubmitEdit').attr({disabled: true});
	}

	async function btnDeleteLogHandler(event){
		var ans = confirm('Apakah anda yakin?');
		if(!ans) return;

		var uuid = $(this).data('uuid');

		var data = {};

		var delUrl = window.Laravel.idepReport.deleteLogURL +'/'+ uuid;
		await axios.post(delUrl, data)
			.then(function(resp){
				showNotification('success', 'Data berhasil dihapus.', 'Sukses');
				renderReportTable();

				$('#formAddData').removeClass('hidden');
				$('#formEditData').addClass('hidden');
				namaLengkapInput.focus();

				$('html, body').animate({
					scrollTop: $("#formAddData").offset().top
				}, 500);
			})
			.catch(function(err){
				showNotification('danger', 'Data gagal dihapus.', 'Ada error');
			});
	}
});