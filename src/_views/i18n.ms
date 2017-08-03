{{% BLOCKS }}
{{< layout }}
{{$ title }}HTML Ipsum{{/ title }}

{{$ content}}

<h1>Localization overview</h1>

<h2>Date/Time formats</h2>

<table>
	<thead>
		<tr>
			<th>Key</th>
			<th>Format</th>
			<th>Sample</th>
		</tr>
	</thead>
	<tbody>
		{{#formats}}
		<tr>
			<td>{{key}}</td>
			<td>{{val}}</td>
			<td>{{txt}}</td>
		</tr>
		{{/formats}}
	</tbody>
</table>

{{/ content}}
{{/ layout }}
