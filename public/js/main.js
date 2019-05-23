function showLoading(loading)
{
	if (!loading) loading = '';
	$("body").mLoading({
	   text: loading + "...",
	});		
}

/**
 * Hide loading indicator
 */
function hideLoading()
{
	$("body").mLoading('hide');
}