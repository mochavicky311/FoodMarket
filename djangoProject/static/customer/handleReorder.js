$(document).ready(function () {

    $('.reorder-btn').click(function () {

        restaurant_id = $(this).data('restaurantid');

        if(!confirm("Confirm reorder?")){
            return false
        } else {
            $.post(`reorder/${$(this).data('orderid')}`, function (data){
                setInterval(location.reload(true), 5000);
            });
        }
    });
});