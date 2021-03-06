(function()
{
	var loaded;
	var images = $('.loading', '#content')
		.find('img')
		.addBack('img')
		.toArray();

	// Nothing to do
	if(images.length == 0)
	{
		// NOTE: In case only .loading without img
		$('.loading', '#content').addClass('loaded');
		return;
	}

	NProgress.start();	
	var i = setInterval(function()
	{
		// While still loading
		if(loaded !== true)
		{
			// Count how many are done loading
			loaded = 0;
			for(var n = 0; n < images.length; n++)
				if(images[n].complete)
					loaded++;

			// Set progress
			NProgress.set(loaded / images.length);

			// Done when all loaded
			if(loaded == images.length)
			{
				loaded = true;
				NProgress.done();
			}
		}
		// When done loading
		else
		{
			// Make images appear
			$(images.shift())
				.closest('.loading')
				.addClass('loaded');
		}

		// When no more imags
		if(images.length == 0)
		{
			// Stop
			clearInterval(i);

			// Make sure all is loaded
			$('.loading', '#content').addClass('loaded');
		}
	}, 100);
})();
