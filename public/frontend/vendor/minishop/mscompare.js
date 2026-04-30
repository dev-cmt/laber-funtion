$(function(){
  // msCompare
  
	$(document).on('click', '.msCompareTogglePage', function(){
		msProductId = $(this).parents('.ms2_form').find('[name="id"]').val()
		msCompareButton = $(this)

		$.post('/msCompare', {'id': msProductId}, function(){
			msCompareButton.prop('disabled', true)
			msCompareCount()
		})

		return false
	})

	$(document).on('click', '.msCompareToggle', function(){
		msProductId = $(this).parents('.ms2_form').find('[name="id"]').val()
		msCompareButton = $(this)

		$.post('/msCompare', {'id': msProductId}, function(){
			msCompareButton.prop('disabled', true)
			msCompareCount()
			window.location.reload()
		})

		return false
	})

	function msCompareCount(){
		$.post('/msCompare', {}, function(data){
			if (data > 0)
				$('#msCompare').find('strong').text(data)
		})
	}
	msCompareCount()
})