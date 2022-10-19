$("#selectAll").click(function () {
    if (!$(".clickBox").is(":checked")) {
        $("#btnCheckbox").removeClass("dissapire");
    } else {
        $("#btnCheckbox").addClass("dissapire");
    }

    $("input[type=checkbox]").prop("checked", $(this).prop("checked"));
});

$("input[type=checkbox]").click(function () {
    if ($(".clickBox").is(":checked")) {
        $("#btnCheckbox").removeClass("dissapire");
    } else {
        $("#btnCheckbox").addClass("dissapire");
    }

    if (!$(this).prop("checked")) {
        $("#selectAll").prop("checked", false);
    }
});

$("#deleteMultiplePost").on("show.bs.modal", function () {
    let getIdCheckbox = $(".clickBox:checked")
        .map(function () {
            return this.value;
        })
        .get();

    $("#addValue").val(getIdCheckbox);

    $("#btnDelSelected").attr("action", route("admin.post.multiple.destroy"));
});
