$(function() {
    // vendor
    $(document).on('change', '[name="vendor"]', function(){
      var vendors = ''
      $('[name="vendor"]').each(function(){
        if (this.checked)
          vendors += ',' + $(this).val()
      })
      $('#filter_vendors').val(vendors.substring(1))
    })
    // vendor x
    
    // made_in
        $(document).on('change', '[name="made_in"]', function(){
              var combobox = ''
              $('[name="made_in"]').each(function(){
                if (this.checked)
                  combobox += ',"' + $(this).val() + '"'
              })
              //console.log(combobox);
              $('#filter_made_ins').val(combobox.substring(1))
        })
    //made_in x
    
    // sorting
    // - Click Filtering
    
    $(document).find('#catalog_sort_block ._group_values ._value').on('click', function(){
      // -- Highlight
      $(this).addClass('_active_').siblings().removeClass('_active_')

      // -- Substitute value
      $(this).parents('._group_values').find('input').val( $(this).data().srot_dir )

      // -- We collect the parameters
      filter_data_sort = '{'
      $('#catalog_sort_block ._group_values input').each(function(i,el){
        if (i > 0) filter_data_sort += ','
        filter_data_sort += '"' + $(this).attr('name') + '":"' + $(this).val() + '"'
      })
      filter_data_sort += '}'

      // -- Save to filter and session
      // console.log(filter_data_sort)
      $('#msCatalogFilterForm [name="sortby"]').val(filter_data_sort)
      $.post('/msCatalogFilter', {'filter_data_sort': filter_data_sort}, function(){
        // -- We filter 
        $('.ajax-start').click()
      })
    })
    
    $(document).find('#catalog_sort_block_price ._group_values ._value').on('click', function(){
      // -- Highlight
      $(this).addClass('_active_').siblings().removeClass('_active_')

      // -- Substitute value
      $(this).parents('._group_values').find('input').val( $(this).data().srot_dir )

      // -- We collect the parameters
      filter_data_sort = '{'
      $('#catalog_sort_block_price ._group_values input').each(function(i,el){
        if (i > 0) filter_data_sort += ','
        filter_data_sort += '"' + $(this).attr('name') + '":"' + $(this).val() + '"'
      })
      filter_data_sort += '}'

      // -- Save to filter and session
      // console.log(filter_data_sort)
      $('#msCatalogFilterForm [name="sortby"]').val(filter_data_sort)
      $.post('/msCatalogFilter', {'filter_data_sort': filter_data_sort}, function(){
        // -- We filter 
        $('.ajax-start').click()
      })
    })

    // - Highlight the active buttons from the session
    /* - Does not work
    $.post('/msCatalogFilter', {'show':true}, function(filter_data_sort){
      oFilter_data_sort = JSON.parse(filter_data_sort)
      $.each(oFilter_data_sort, function(sort_name, sort_dir){
        // -- Highlight
        $('#catalog_sort_block [data-sort_name="'+sort_name+'"]')
          .find('[data-srot_dir="'+sort_dir+'"]')
          .addClass('_active_')
          .siblings()
          .removeClass('_active_')
        // -- Substitute value
        $('#catalog_sort_block [data-sort_name="'+sort_name+'"] input').val( sort_dir )
      })
    })
    */
    // sorting x

    //MODx pdoResources Ajax Filter
    //Filter Settings
    var fadeSpeed             = 200, // Fade Animation Speed
        ajaxCountSelector     = '.ajax-count', // CSS Selector of Items Counter
        ajaxContainerSelector = '.ajax-container', // CSS Selector of Ajax Container
        ajaxItemSelector      = '.ajax-item', // CSS Selector of Ajax Item
        ajaxFormSelector      = '.ajax-form', // CSS Selector of Ajax Filter Form
        ajaxFormButtonStart   = '.ajax-start', // CSS Selector of Button Start Filtering
        ajaxFormButtonReset   = '.ajax-reset', // CSS Selector of Button Reset Ajax Form
        sortDownText          = 'Descending',
        sortUpText            = 'Ascending';

    function ajaxCount() {
        if($('.ajax-filter-count').length) {
            var count = $('.ajax-filter-count').data('count');
            $(ajaxCountSelector).text(count);
        } else {
            $(ajaxCountSelector).text($(ajaxItemSelector).length);
        }
    }ajaxCount();

    function ajaxMainFunction() {
        $('.ajax-container').addClass('_loading_');
        $.ajax({
            data: $(ajaxFormSelector).serialize()
        }).done(function(response) {
            $('.ajax-container').removeClass('_loading_');
            var $response = $(response);
            $(ajaxContainerSelector).fadeOut(fadeSpeed);
            setTimeout(function() {
                $(ajaxContainerSelector).html($response.find(ajaxContainerSelector).html()).fadeIn(fadeSpeed);
                ajaxCount();
            }, fadeSpeed);
        });
    }

    $(ajaxContainerSelector).on('click', '.ajax-more', function(e) {
        e.preventDefault();

        var offset = $(ajaxItemSelector).length;
        $.ajax({
            data: $(ajaxFormSelector).serialize()+'&offset='+offset
        }).done(function(response) {
            $('.ajax-more').remove();
            var $response = $(response);
            $response.find(ajaxItemSelector).hide();
            $(ajaxContainerSelector).append($response.find(ajaxContainerSelector).html());
            $(ajaxItemSelector).fadeIn();
        });
    })

    $(ajaxFormButtonStart).click(function(e) {
        e.preventDefault();
        ajaxMainFunction();
    })

    $(ajaxFormButtonReset).click(function(e) {
        e.preventDefault();
        $(ajaxFormSelector).trigger('reset');
        $(".input-check__input").removeAttr('checked'); 
        $('input[name=sortby]').val('pagetitle');
        $('input[name=sortdir]').val('asc');
        setTimeout(function() {
            $('[data-sort-by]').data('sort-dir', 'asc').toggleClass('button-sort-asc').text(sortUpText);
        }, fadeSpeed);
        ajaxMainFunction();
        ajaxCount();
    })

   $(''+ajaxFormSelector+' input:not(.ajax-disabled)').change(function() {
       ajaxMainFunction();
   })

    $('[data-sort-by]').data('sort-dir', 'asc').click(function() {
        var ths = $(this);
        $('input[name=sortby]').val($(this).data('sort-by'));
        $('input[name=sortdir]').val($(this).data('sort-dir'));
        setTimeout(function() {
            $('[data-sort-by]').not(this).toggleClass('button-sort-asc').text(sortUpText);
            ths.data('sort-dir') == 'asc' ? ths.data('sort-dir', 'desc').text(sortDownText) : ths.data('sort-dir', 'asc').text(sortUpText);
            $(this).toggleClass('button-sort-asc');
        }, fadeSpeed);
        ajaxMainFunction();
    });

});