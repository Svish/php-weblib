{{% BLOCKS }}
{{< layout }}
{{$ title }}HTML Ipsum{{/ title }}

{{$ content}}

<section>
	<h1>HTML Ipsum Presents<span>Test page this is</span></h1>

	<p><strong>Pellentesque habitant morbi tristique</strong> senectus et netus et malesuada fames ac turpis egestas. Vestibulum tortor quam, feugiat vitae, ultricies eget, tempor sit amet, ante.</p>

	<div class="center frames">
		<img class="loading" src="https://placehold.it/150x150">
		<img class="loading" src="https://placehold.it/150x150">
		<img class="loading" src="https://placehold.it/150x150">
	</div>

	<p>Donec eu libero sit amet quam egestas semper. <em>Aenean ultricies mi vitae est.</em> Mauris placerat eleifend leo. Quisque sit amet est et sapien ullamcorper pharetra. Vestibulum erat wisi, condimentum sed, <code>commodo vitae</code>, ornare sit amet, wisi. Aenean fermentum, elit eget tincidunt condimentum, eros ipsum rutrum orci, sagittis tempus lacus enim ac dui. <a href="javascript:void(0);">Donec non enim</a> in turpis pulvinar facilisis. Ut felis.</p>

	<h2>Header Level 2<span>Test page</span></h2>

	<ol>
		<li>Lorem ipsum dolor sit amet, consectetuer adipiscing elit.</li>
		<li>Aliquam tincidunt mauris eu risus.</li>
	</ol>

	<blockquote><p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus magna. Cras in mi at felis aliquet congue. Ut a est eget ligula molestie gravida. Curabitur massa. Donec eleifend, libero at sagittis mollis, tellus est malesuada tellus, at luctus turpis elit sit amet quam. Vivamus pretium ornare est.</p></blockquote>

	<h3>Header Level 3</h3>

	<ul>
		<li>Lorem ipsum dolor sit amet, consectetuer adipiscing elit.</li>
		<li>Aliquam tincidunt mauris eu risus.</li>
	</ul>
</section>



<section>
	<h1>Badges</h1>
	<p><span class="badge" data-name="CSS"> Not a link</span>
	<p><a class="badge" data-name="CSS" href="javascript:void(0)"> Badge</a>
	<p><a class="badge badge-1" data-name="CSS" href="javascript:void(0)"> Badge 1</a>
	<p><a class="badge badge-2" data-name="CSS" href="javascript:void(0)"> Badge 2</a>
	<p><a class="badge badge-3" data-name="CSS" href="javascript:void(0)"> Badge 3</a>
</section>



<section>
	<h1>Code</h1>
	<pre><code>#header h1 a {
	display: block;
	width: 300px;
	height: 80px;
}</code></pre>
</section>



<section>
	<h1>Forms</h1>
	<form method="post" onsubmit="javascript:return false">
		<p>
			<input placeholder="Text input" type="text" name="name" id="name" value="" />
			<br>
			<input placeholder="Text input" type="text" name="name" id="name" value="" required />
			<br>
			<input placeholder="Text input" type="text" name="name" id="name" value="Good value" required />
			<br>
			<input placeholder="Text input" type="text" name="name" id="name" value="Bad value" class="error" required />
		</p>

		<fieldset>
			<legend>Boxes</legend>
			<p>
				 <input type="radio" name="radio-choice" id="radio-choice-1" value="choice-1" />
				 <label for="radio-choice-1">Choice 1</label>

				 <input type="radio" name="radio-choice" id="radio-choice-2" value="choice-2" />
				<label for="radio-choice-2">Choice 2</label>
			</p>

			<p>
				<input type="checkbox" name="checkbox" id="checkbox" />
				<label for="checkbox">Checkbox</label>
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
			<button>{{#svg}}save{{/svg}} Enabled</button>
			<button disabled>{{#svg}}save{{/svg}} Disabled</button>
			<a href="javascript:void(0)" class="button">Link button</a>
			Text
		</p>
	</form>
</section>



<section>
	<h1>Definition lists</h1>
	<dl>
	   <dt>Ut enim ad minim veniam</dt>
	   <dd>Consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna
	aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea
	commodo consequat.</dd>
	   <dt>Lorem ipsum dolor sit amet</dt>
	   <dd>Consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna
	aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea
	commodo consequat.</dd>
	</dl>
</section>



<section>
	<h1>Tables</h1>
	<table class="full-width">
	  <thead>
		<tr>
		  <th>Header 1</th><th>Header 2</th><th>Header 3</th><th>Header 4</th>
		</tr>
	  </thead>
	  <tbody>
		<tr>
		  <td>Column 1</td><td>Column 2</td><td>Column 3</td><td>Column 4</td>
		</tr>
		<tr>
		  <td>Column 5</td><td>Column 6</td><td>Column 7</td><td>Column 8</td>
		</tr>
		<tr>
		  <td>Column 9</td><td>Column 10</td><td>Column 11</td><td>Column 12</td>
		</tr>
	  </tbody>
	</table>
	<table class="full-width">
	  <thead>
		<tr>
		  <th>Header 1</th><th>Header 2</th><th>Header 3</th><th>Header 4</th>
		</tr>
	  </thead>
	  <tbody class="striped">
		<tr>
		  <td>Column 1</td><td>Column 2</td><td>Column 3</td><td>Column 4</td>
		</tr>
		<tr>
		  <td>Column 5</td><td>Column 6</td><td>Column 7</td><td>Column 8</td>
		</tr>
		<tr>
		  <td>Column 9</td><td>Column 10</td><td>Column 11</td><td>Column 12</td>
		</tr>
	  </tbody>
	</table>
	<table class="full-width">
	  <thead>
		<tr>
		  <th>Header 1</th><th>Header 2</th><th>Header 3</th><th>Header 4</th>
		</tr>
	  </thead>
	  <tbody class="checkered">
		<tr>
		  <td>Column 1</td><td>Column 2</td><td>Column 3</td><td>Column 4</td>
		</tr>
		<tr>
		  <td>Column 5</td><td>Column 6</td><td>Column 7</td><td>Column 8</td>
		</tr>
		<tr>
		  <td>Column 9</td><td>Column 10</td><td>Column 11</td><td>Column 12</td>
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



{{/ content}}
{{/ layout }}
