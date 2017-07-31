
$('#content').on('click', 'a[href*="://"]', function()
{
	window.open(this.href, '_blank');
	return false;
});
