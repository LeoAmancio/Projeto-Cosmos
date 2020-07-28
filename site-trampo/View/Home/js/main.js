var service_list = $("div.search");
var search_bar = $("#search-bar");

$(search_bar).click(function () {
    if(!$(service_list).is(":visible")) {
        service_list.fadeIn();
    }
});

$(document).mouseup(function (e) {
    var container = service_list;

    if (!container.is(e.target) && container.has(e.target).length === 0 && !search_bar.is(e.target)) {
        container.fadeOut();
    }
});

$("#search-bar").keyup(function() {
    var search_value = $("#search-bar").val();
    $.post("php/searchOccupation.php", {
        suggestion: search_value
    },function(data) {
        $(service_list).html(data);
    });  
});