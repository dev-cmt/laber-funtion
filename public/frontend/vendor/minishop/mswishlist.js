$(function(){
  // msWishlist
	$(document).on('click', '.msWishlistTogglePage', function(){
		msProductId = $(this).parents('.ms2_form').find('[name="id"]').val()
		msWishlistButton = $(this)

		$.post('/msWishlist', {'id': msProductId}, function(){
			msWishlistButton.prop('disabled', true)
			msWishlistCount()
		})

		return false
	})
	
	$(document).on('click', '.msWishlistToggle', function(){
		msProductId = $(this).parents('.ms2_form').find('[name="id"]').val()
		msWishlistButton = $(this)

		$.post('/msWishlist', {'id': msProductId}, function(){
			msWishlistButton.prop('disabled', true)
			msWishlistCount()
			window.location.reload()
		})

		return false
	})

	function msWishlistCount(){
		$.post('/msWishlist', {}, function(data){
			if (data > 0)
				$('.msWishlist').find('strong').text(data)
		})
	}
	msWishlistCount()
})