$(document).ready( function() {
    $(".glyphicon-plus, .glyphicon-minus").on("click", function() {
        var number = $(this).parent().parent().find("span").text();
        var span = $(this).parent().parent().find(".number");
        var name = $(this).attr("class");
        var price = $(this).parent().parent().find(".price");
        var id = span.attr("name");

        if (name.indexOf('plus') + 1){
            price.text((parseFloat(price.text()) + parseFloat(price.text()) /  parseInt(number)).toFixed(2) );
            var count = parseInt(number) + 1;
            $(span).html(' ' + count + ' ');
            $.ajax({
                url: '/~user8/book_shop/cart/add/' + id,
                method: 'GET'
            }).then(function(data) {
            });
        }
        else
    {
        if (number > 1){
            price.text((parseFloat(price.text()) - parseFloat(price.text()) /  parseInt(number)).toFixed(2));
            var count = parseInt(number) - 1;
            $(span).html(' ' + count + ' ');
            console.log(id);
            $.ajax({
                url: '/~user8/book_shop/cart/setCount/' + id,
                method: 'GET'
            }).then(function(data) {
            });
        }
    }
    })
})