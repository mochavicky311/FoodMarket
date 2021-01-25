$(document).ready(function () {

        $('.del-comment-btn').click(function () {
            if(!confirm("Confirm remove review?")){
                return false
            }
            else {
                $.post(`del/${$(this).data('restaurantid')}/${$(this).data('reviewid')}`,
                success => {
                    setInterval(location.reload(true), 5000);
                });
            }
        });

    });