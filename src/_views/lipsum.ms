{{% BLOCKS }}
{{< layout }}
{{$ title }}HTML Ipsum{{/ title }}

{{$ content}}

<h1>Site styles test<span>H1</span></h1>

<section>
	<p>A paragraph with <strong>strong text</strong>, <em>emphasized text</em>, <b>bold text</b>, <i>italic text</i>, <code>inline code</code>, and <a href="javascript:void(0)">a link</a>.</p>

	<h2>Loading frames<span>H2</span></h2>

	<div class="center frames p">
		<img class="loading" src="https://placehold.it/150x150">
		<img class="loading" src="https://placehold.it/150x150">
		<img class="loading" src="https://placehold.it/150x150">
	</div>


	<h2>Lists<span>H2</span></h2>
	<h3>Ordered<span>H3</span></h3>
	<ol>
		<li>Lorem ipsum dolor sit amet, consectetuer adipiscing elit.</li>
		<li>Aliquam tincidunt mauris eu risus.</li>
	</ol>
	<h3>Unordered<span>H3</span></h3>
	<ul>
		<li>Lorem ipsum dolor sit amet, consectetuer adipiscing elit.</li>
		<li>Aliquam tincidunt mauris eu risus.</li>
	</ul>

	<h3>Definition lists</h3>
	<dl>
		<dt>Ut enim ad minim veniam</dt>
		<dd>Consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna
		aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea
		commodo consequat.</dd>
		<dt>Lorem ipsum dolor sit amet</dt>
		<dd>Consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna
		aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea
		commodo consequat.</dd>

		<dt>First topics</dt>
		<dt>Second topics</dt>
		<dd>The definition</dd>

		<dt>One topic</dt>
		<dd>First definition</dd>
		<dd>Second definition</dd>

	</dl>

	<h2>Blockquote</h2>
	<blockquote>
		<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus magna. Cras in mi at felis aliquet congue. Ut a est eget ligula molestie gravida. Curabitur massa. Donec eleifend, libero at sagittis mollis, tellus est malesuada tellus, at luctus turpis elit sit amet quam. Vivamus pretium ornare est.</p>
	</blockquote>

</section>



<section>
	<h1>Accent colors</h1>

	<p class="accent accent1">
	<p class="accent accent2">
	<p class="accent accent3">

</section>

<hr>

<section>
	<h1>Forms</h1>
	<form method="post" onsubmit="javascript:return false">
		<p>
			<input type="text" placeholder="Text input" name="name" id="name">
			<br>
			<input type="text" placeholder="Optional input" name="name" id="name" value="" optional>
			<br>
			<input type="text" placeholder="Required input" name="name" id="name" value="" required />
		</p>
		<p>
			<input type="text" placeholder="Text input" name="name" id="name" value="Good value" required />
			<br>
			<input type="text" placeholder="Text input" name="name" id="name" value="Bad value" class="error" required />
		</p>

		<fieldset>
			<legend>Boxes</legend>
			<p>
				 <input type="radio" name="radio-choice" id="radio-choice-1" value="choice-1" />
				 <label for="radio-choice-1">Choice 1</label>

				 <input type="radio" name="radio-choice" id="radio-choice-2" value="choice-2" />
				<label for="radio-choice-2">Choice 2</label>

				 <input type="radio" name="radio-choice" id="radio-choice-3" value="choice-3" />
				<label for="radio-choice-3">Choice 3</label>
			</p>

			<p>
				<input type="checkbox" name="checkbox[]" id="checkbox-1" />
				<label for="checkbox-1">Checkbox 1</label>

				<input type="checkbox" name="checkbox[]" id="checkbox-2" />
				<label for="checkbox-2">Checkbox 2</label>

				<input type="checkbox" name="checkbox[]" id="checkbox-3" />
				<label for="checkbox-3">Checkbox 3</label>
			</p>
		</fieldset>

		<p>
			<select name="select-choice" id="select-choice">
				<option value="Choice 1">Choice 1</option>
				<option value="Choice 2">Choice 2</option>
				<option value="Choice 3">Choice 3</option>
			</select>
		</p>

		<p>
			<textarea placeholder="Textarea" name="textarea" id="textarea"></textarea>
		</p>

		<p>
			<button type="submit">{{#svg}}save{{/svg}} Submit</button>
			<button type="button">Enabled</button>
			<button type="button" disabled>Disabled</button>
			<a href="javascript:void(0)" class="button">Link.button</a>
			Text
		</p>
	</form>
</section>

<hr>

<section>
	<h1>Tables</h1>
	<table class="full-width">
		<thead>
			<tr>
				<th>Header 1</th>
				<th>Header 2</th>
				<th>Header 3</th>
				<th>Header 4</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td>Column 1</td>
				<td>Column 2</td>
				<td>Column 3</td>
				<td>Column 4</td>
			</tr>
			<tr>
				<td>Column 5</td>
				<td>Column 6</td>
				<td>Column 7</td>
				<td>Column 8</td>
			</tr>
			<tr>
				<td>Column 9</td>
				<td>Column 10</td>
				<td>Column 11</td>
				<td>Column 12</td>
			</tr>
		</tbody>
	</table>

	<table class="full-width">
		<thead>
			<tr>
				<th>Header 1</th>
				<th>Header 2</th>
				<th>Header 3</th>
				<th>Header 4</th>
			</tr>
		</thead>
		<tbody class="striped">
			<tr>
				<td>Column 1</td>
				<td>Column 2</td>
				<td>Column 3</td>
				<td>Column 4</td>
			</tr>
			<tr>
				<td>Column 5</td>
				<td>Column 6</td>
				<td>Column 7</td>
				<td>Column 8</td>
			</tr>
			<tr>
				<td>Column 9</td>
				<td>Column 10</td>
				<td>Column 11</td>
				<td>Column 12</td>
			</tr>
		</tbody>
	</table>

	<table class="full-width">
		<thead>
			<tr>
				<th>Header 1</th>
				<th>Header 2</th>
				<th>Header 3</th>
				<th>Header 4</th>
			</tr>
		</thead>
		<tbody class="checkered">
			<tr>
				<td>Column 1</td>
				<td>Column 2</td>
				<td>Column 3</td>
				<td>Column 4</td>
			</tr>
			<tr>
				<td>Column 5</td>
				<td>Column 6</td>
				<td>Column 7</td>
				<td>Column 8</td>
			</tr>
			<tr>
				<td>Column 9</td>
				<td>Column 10</td>
				<td>Column 11</td>
				<td>Column 12</td>
			</tr>
		</tbody>
	</table>
</section>

<hr>

<section>
	<h1>Frames</h1>
	<div class="frames">
		<div>Column 1</div>
		<a href="javascript:void(0)">Column 2</a>
		<a href="javascript:void(0)">Column 3</a>
		<div>Column 4</div>
		<div>
			<img src="https://placehold.it/75x75">
			<div>Column 5</div>
		</div>
		<div>Column 6</div>
		<div>Column 7</div>
		<div>Column 8</div>
	</div>
</section>

<hr>

<section>
	<h1>Flex</h1>
	<div class="flex">
		<section>
			<h2>Section 1</h2>
			<img src="https://placehold.it/150x50">
		</section>
		<section>
			<h2>Section 2</h2>
			<img src="https://placehold.it/150x150">
		</section>
		<section>
			<h2>Section 3</h2>
			<img src="https://placehold.it/150x275">
		</section>
		<section>
			<h2>Section 4</h2>
			<img src="https://placehold.it/150x55">
		</section>
		<section>
			<h2>Section 5</h2>
			<img src="https://placehold.it/150x105">
		</section>
		<section>
			<h2>Section 6</h2>
			<img src="https://placehold.it/150x175">
		</section>
		<section>
			<h2>Section 7</h2>
			<img src="https://placehold.it/150x175">
		</section>
	</div>
</section>

<hr>

<section>
	<h1>Columns</h1>
	<div class="columns">
		<section>
			<h2>Section 1</h2>
			<img src="https://placehold.it/150x50">
		</section>
		<section>
			<h2>Section 2</h2>
			<img src="https://placehold.it/150x150">
		</section>
		<section>
			<h2>Section 3</h2>
			<img src="https://placehold.it/150x275">
		</section>
		<section>
			<h2>Section 4</h2>
			<img src="https://placehold.it/150x55">
		</section>
		<section>
			<h2>Section 5</h2>
			<img src="https://placehold.it/150x105">
		</section>
		<section>
			<h2>Section 6</h2>
			<img src="https://placehold.it/150x175">
		</section>
		<section>
			<h2>Section 7</h2>
			<img src="https://placehold.it/150x175">
		</section>
	</div>
</section>



<section>
	<h1>Code</h1>
	<pre><code>#header h1 a {
	display: block;
	width: 300px;
	height: 80px;
}</code></pre>
</section>



{{/ content}}
{{/ layout }}
