
"use strict";

function Vendas() {
    this.init();
}

Vendas.prototype.init = function () {
    var self = this;

    $(".question").on("click", ".title", function () {
        var $question = $(this).parent();
        var $answer = $question.find(".answer");

        $question.toggleClass("open");
        $answer.slideToggle(300);
    });

    app.ajaxSelect({
        element: "#selectState",
        target: "#selectCity",
    });
};

$(document).ready(function () {
    new Vendas();
});

