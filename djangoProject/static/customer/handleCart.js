$(document).ready(function () {

        $('.add-cart').click( function () {
            $.post(`add/${$(this).data('restaurantid')}/${$(this).data('productid')}`,
                 function(data) {
                    if(data === 'Cannot add item from different vendors.'){
                        alert(data)
                    } else {
                       setInterval(location.reload(true), 5000);
                    }
            });
        });

        $('.remove-btn').click(function () {
            if(!confirm("Confirm remove from cart?")){
                return false
            }
            else {
                $.post(`remove/${$(this).data('productid')}`,
                success => {
                    setInterval(location.reload(true), 5000);
                });
            }
        });

        $('.qty-input').change(function () {
            $.post(`update/${$(this).data('productid')}/${$(this).val()}`,
                success => {
                    setInterval(location.reload(true), 5000);
                });
        });
    });