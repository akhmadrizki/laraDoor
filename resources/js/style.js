$(document).on("change", ".btn-file :file", function () {
    var input = $(this),
        numFiles = input.get(0).files ? input.get(0).files.length : 1,
        label = input.val().replace(/\\/g, "/").replace(/.*\//, "");

    input.trigger("fileselect", [numFiles, label]);
});

$(document).ready(function () {
    $(".btn-file :file").on("fileselect", function (event, numFiles, label) {
        var input = $(this).parents(".input-group").find(":text"),
            log = numFiles > 1 ? numFiles + " files selected" : label;

        if (input.length) {
            input.val(log);
        } else {
            if (log) alert(log);
        }
    });
});

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

$("#btnDelSelected").submit(function (event) {
    event.preventDefault();

    let getId = $(".clickBox:checked")
        .map(function () {
            return this.value;
        })
        .get();

    $.ajax({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },

        url: $(this).attr("action"),
        type: "DELETE",
        data: {
            ids: getId,
        },
        success: function (data) {
            window.location.reload();
            // console.log(data);
        },
        error: function (xhr, status, error) {
            window.location.reload();
            // console.log(error);
        },
    });

    // console.log(getId);
});
