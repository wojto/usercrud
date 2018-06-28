const paginateToPage = function($container, params) {
    $.ajax({
        type: "GET",
        url: $container.data('url'),
        data: params,
        async: false
    })
    .done(function(response){
        $container.html(response);
        history.pushState('', '', $container.data('url')+'?'+$.param(params));
    })
    .fail(function(jqXHR, textStatus, errorThrown){
        alert('Error : ' + errorThrown);
    });

    return this;
};
