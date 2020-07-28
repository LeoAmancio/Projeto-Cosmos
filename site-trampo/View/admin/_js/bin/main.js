//init sideNav
var elem_sideNav = document.querySelector(".sidenav");
var instance_sideNav = M.Sidenav.init(elem_sideNav);

//init tabs
var elem_tabs = document.querySelector(".tabs");
var instance_tabs = M.Tabs.init(elem_tabs);

//init modal
var elem_modal = document.querySelectorAll('.modal');
var instance_modal = M.Modal.init(elem_modal, {
    preventScrolling: false
});

//init select && characterCounter
$(document).ready(function () {
    $('select').formSelect();
    $('#service-description').characterCounter();
});

//init collapsible
var elem_collapsible = document.querySelectorAll('.collapsible');
var instances_collapsible = M.Collapsible.init(elem_collapsible);


try {

    var service_list = $(".section-hire .collection");
    var search_bar = $("#search-bar");
    var label_search_bar = $("#label-search-bar");

    $(search_bar).click(function () {
        if (!$(service_list).is(':visible')) {
            service_list.fadeIn();
        }
    });

    $(document).mouseup(function (e) {
        var container = service_list;

        if (!container.is(e.target) && container.has(e.target).length === 0 && !search_bar.is(e.target) && !label_search_bar.is(e.target)) {
            container.fadeOut();
        }
    });

    $("#search-bar").keyup(function () {
        var search_value = $("#search-bar").val();
        $.post("../../../Controller/searchOccupation.php", {
            suggestion: search_value
        }, function (data) {
            $(service_list).html(data);
        });
    });

} catch (error) {

}


//add shadow on navbar when scroll
var navbar = document.querySelector(".nav-extended");

if (navbar.classList.contains("z-depth-0")) {
    window.onscroll = function () {
        if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
            navbar.classList.add("z-depth-1");
            navbar.classList.remove("z-depth-0");
        } else {
            navbar.classList.add("z-depth-0");
        }
    }
}


