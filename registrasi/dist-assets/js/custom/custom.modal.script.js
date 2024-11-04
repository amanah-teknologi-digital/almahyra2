"use strict";

$(document).ready(function () {
	$(".add-button").click(function(){
        $("#adding-modal").modal({
            backdrop: 'static',
            keyboard: false
        });
    });

    $(".update-button").click(function(){
        $("#updating-modal").modal({
            backdrop: 'static',
            keyboard: false
        });
    });

})


