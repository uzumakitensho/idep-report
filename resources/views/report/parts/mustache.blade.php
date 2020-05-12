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