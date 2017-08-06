
if($('#toc', '#content').length)
{
	$('.toc[id]', '#content')
		.map(function()
		{
			var url = Site.Url.Current + '#' + this.id;
			var txt = $(':first-child', this)
				.get(0)
				.innerText;

			var a = $('<a></a>')
				.attr('href', url)
				.text(txt);

			return $('<li>')
				.append(a)
				.get(0);
		})
		.appendTo('#toc');
}

