(function ($) {
    $(document).on('submit', 'form.searchForm', function(e){
        // Stop default form behavior
        e.preventDefault();

        //get form data
        const formData = $(this).serialize();
        console.log(formData);
        //AJAX request
        $.ajax(
            'http://hotel.collegelink.localhost/public/ajax/search_results.php',
            {
            type: "GET",
            dataType: "html",
            data: formData,
            }).done(function(result){
                //clear results container
                $('#search-results-container').html('');

                //append new results
                $('#search-results-container').append(result);

                //push url state
                history.pushState({}, '', 'http://hotel.collegelink.localhost/public/list.php?' + formData);
            });
    });

})(jQuery);