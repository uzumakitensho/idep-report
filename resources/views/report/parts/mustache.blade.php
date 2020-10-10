<script id="idepReportLogInputDate" type="x-tmpl-mustache">
<thead>
	<tr>
		<th>Created At</th>
		<th>Jenis</th>
		<th>Nama</th>
		<th>Jumlah</th>
		<th>Action</th>
	</tr>
</thead>
<tbody>
	{% #idepLogs %}
	<tr>
		<td>{% created_date %}</td>
		<td>{% type_name %}</td>
		<td>{% full_name %}</td>
		<td>{% quantity %}</td>
		<td>
			<a  
				class="btn btn-sm btn-warning btn-edit-log"
				data-uuid="{% uuid_idep_log %}" 
				data-transdate="{% trans_date %}" 
				data-typename="{% type_name %}" 
				data-fullname="{% full_name %}" 
				data-quantity="{% value %}" 
				data-description="{% description %}" 
			>Ubah</a>

			<a  
				class="btn btn-sm btn-danger btn-del-log"
				data-uuid="{% uuid_idep_log %}" 
			>Hapus</a>
		</td>
	</tr>
	{% /idepLogs %}
</tbody>
</script>

<script id="idepReportListTmplt" type="x-tmpl-mustache">
<thead>
	<tr>
		<th>Nama</th>
		<th>Total</th>
		<th width="3%">Action</th>
	</tr>
</thead>
<tbody>
	{% #idepLogs %}
	<tr>
		<td>{% full_name %}</td>
		<td>{% quantity_total %}</td>
		<td>
			<a href="#" class="btn btn-sm btn-primary">Detail</a>
		</td>
	</tr>
	{% /idepLogs %}
</tbody>
</script>

<script id="idepReportListByDateTmplt" type="x-tmpl-mustache">
<thead>
	<tr>
		<th>Tanggal</th>
		<th>Total</th>
		<th width="3%">Action</th>
	</tr>
</thead>
<tbody>
	{% #idepLogs %}
	<tr>
		<td>{% transaction_date %}</td>
		<td>{% quantity_total %}</td>
		<td>
			<a href="#" class="btn btn-sm btn-primary">Detail</a>
		</td>
	</tr>
	{% /idepLogs %}
</tbody>
</script>

<script id="detailSelectedTmplt" type="x-tmpl-mustache">
<thead>
	<tr>
		<th>Jenis</th>
		<th>Total</th>
		<th width="3%">Action</th>
	</tr>
</thead>
<tbody>
	{% #idepLogs %}
	<tr>
		<td>{% type_name %}</td>
		<td>{% quantity_total %}</td>
		<td>
			<a href="#" class="btn btn-sm btn-primary">Detail</a>
		</td>
	</tr>
	{% /idepLogs %}
</tbody>
</script>