(function($){
    $(document).on('submit','form.reviewForm', function(e){
        e.preventDefault();

        //get form Data
        const formData=$(this).serialize();

        //ajax Request
        $.ajax(
            'http://hotel.collegelink.localhost/public/ajax/room_review.php',
            {
                type: "POST",
                dataType: "html",
                data: formData
            }).done(function(result){
                //append review to list
                $('#room-reviews-container').append(result);
                //reset review form
                $('form.reviewForm').trigger('reset');
            });
    });
})(jQuery);