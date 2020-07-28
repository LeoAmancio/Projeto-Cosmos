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
    $('#service-description, #service_request_description').characterCounter();
});

//init collapsible
var elem_collapsible = document.querySelectorAll('.collapsible');
var instances_collapsible = M.Collapsible.init(elem_collapsible);

//init floating action button
var elems_floating_action_button = document.querySelectorAll('.fixed-action-btn');
var instances_floating_action_button = M.FloatingActionButton.init(elems_floating_action_button);

//init materialboxed img
var elems_materialboxed = document.querySelectorAll('.materialboxed');
var instances = M.Materialbox.init(elems_materialboxed);

//init Tooltips
var elems_tooltips = document.querySelectorAll('.tooltipped');
var instances_tooltips = M.Tooltip.init(elems_tooltips); 

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


//become worker
$("#form-becomeWorker").submit(function (event) {
    event.preventDefault();
    var select_occupation = $("#select-occupation").val();
    var work_info = $("#work-info").val();
    var work_agreement;
    var submit = $("#submit-becomeWorker").val();
    if ($("#work-agreement").is(":checked")) {
        work_agreement = true;
    } else {
        work_agreement = false;
    }
    $("#message-becomeWorker").load("../../../Controller/becomeWorker.php", {
        select_occupation: select_occupation,
        work_info: work_info,
        work_agreement: work_agreement,
        submit: submit
    });
});

//chat list conversation
try {

    $(document).ready(function () {
        var id_user = $("#id_user").val();

        function loadConversations() {
            $("section.chat .conversations").load("../../../Controller/chatList.php", {
                id_user: id_user
            });
        }

        setInterval(function () { loadConversations(); }, 2000);

    });


} catch (error) {

}

//chat conversation

try {
    $(document).ready(function () {
        var id_user_to = $("#id_user_to").val();
        var id_user_from = $("#id_user_from").val();
        var id_conversation = $("#id_conversation").val();

        function loadMessages() {
            $("section.chat .conversation .conversation-content").load("../../../Controller/chatMessage.php", {
                id_user_to: id_user_to,
                id_user_from: id_user_from,
                id_conversation: id_conversation
            });
        }

        loadMessages();
        setInterval(function () { loadMessages() }, 100);

    });
} catch (error) {

}

//chat send message

try {
    $(".conversation #form-chat").submit(function (event) {
        event.preventDefault();
        var id_user_to = $("#id_user_to").val();
        var id_user_from = $("#id_user_from").val();
        var id_conversation = $("#id_conversation").val();
        var text_message = $("#text-message").val();
        var new_message = $("#new_message").val();


        $("#form-chat-result").load("../../../Controller/chatSend.php", {
            id_user_to: id_user_to,
            id_user_from: id_user_from,
            id_conversation: id_conversation,
            text_message: text_message,
            new_message: new_message
        });

    });

} catch (error) {

}

try {
    $(document).ready(function() {
        $("#service_request_price").mask('000.000.000,00', {reverse: true});
    });
} catch (error) {
    
}


function delete_service_request(id_service_request, id_service, occupation_subcategory) {
    var link_delete = document.getElementById("delete-service-request");
    link_delete.href = "../../../Controller/dismissService.php/?id_service_request="+id_service_request+"&id_service="+id_service+"&occupation_subcategory="+occupation_subcategory;
}

function dismiss_hired_user(id_service_request, id_service, occupation_subcategory) {
    var link_dismiss = document.getElementById("dismiss-hired-user");
    link_dismiss.href = "../../../Controller/dismissHiredUser.php/?id_service_request="+id_service_request+"&id_service="+id_service+"&occupation_subcategory="+occupation_subcategory;
}

function accept_service_request(id_service_request, id_service, occupation_subcategory) {
    var link_accept = document.getElementById("accept-service-request");
    link_accept.href = "../../../Controller/acceptService.php/?id_service_request="+id_service_request+"&id_service="+id_service+"&occupation_subcategory="+occupation_subcategory;
}


