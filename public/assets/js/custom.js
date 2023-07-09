/*
=========================================
|                                       |
|           Scroll To Top               |
|                                       |
=========================================
*/
$(".scrollTop").click(function() {
    $("html, body").animate({ scrollTop: 0 });
});

$(".navbar .dropdown.notification-dropdown > .dropdown-menu, .navbar .dropdown.message-dropdown > .dropdown-menu ").click(function(e) {
    e.stopPropagation();
});

/*
=========================================
|                                       |
|       Multi-Check checkbox            |
|                                       |
=========================================
*/

function checkall(clickchk, relChkbox) {
    var checker = $("#" + clickchk);
    var multichk = $("." + relChkbox);

    checker.click(function() {
        multichk.prop("checked", $(this).prop("checked"));
    });
}

/*
=========================================
|                                       |
|           MultiCheck                  |
|                                       |
=========================================
*/

/*
    This MultiCheck Function is recommanded for datatable
*/

function multiCheck(tb_var) {
    tb_var.on("change", ".chk-parent", function() {
            var e = $(this).closest("table").find("td:first-child .child-chk"),
                a = $(this).is(":checked");
            $(e).each(function() {
                a ? ($(this).prop("checked", !0), $(this).closest("tr").addClass("active")) : ($(this).prop("checked", !1), $(this).closest("tr").removeClass("active"));
            });
        }),
        tb_var.on("change", "tbody tr .new-control", function() {
            $(this).parents("tr").toggleClass("active");
        });
}

/*
=========================================
|                                       |
|           MultiCheck                  |
|                                       |
=========================================
*/

function checkall(clickchk, relChkbox) {
    var checker = $("#" + clickchk);
    var multichk = $("." + relChkbox);

    checker.click(function() {
        multichk.prop("checked", $(this).prop("checked"));
    });
}

/*
=========================================
|                                       |
|               Tooltips                |
|                                       |
=========================================
*/

// $(".bs-tooltip").tooltip();

/*
=========================================
|                                       |
|               Popovers                |
|                                       |
=========================================
*/

$(".bs-popover").popover();

/*
================================================
|                                              |
|               Rounded Tooltip                |
|                                              |
================================================
*/

$(".t-dot").tooltip({
    template: '<div class="tooltip status rounded-tooltip" role="tooltip"><div class="arrow"></div><div class="tooltip-inner"></div></div>',
});

/*
================================================
|            IE VERSION Dector                 |
================================================
*/

function GetIEVersion() {
    var sAgent = window.navigator.userAgent;
    var Idx = sAgent.indexOf("MSIE");

    // If IE, return version number.
    if (Idx > 0) return parseInt(sAgent.substring(Idx + 5, sAgent.indexOf(".", Idx)));
    // If IE 11 then look for Updated user agent string.
    else if (!!navigator.userAgent.match(/Trident\/7\./)) return 11;
    else return 0; //It is not IE
}

var images = [];

function imageSelect() {
    var image = document.getElementById("image").files;
    for (i = 0; i < image.length; i++) {
        // console.log(image[i]);
        images.push({
            name: image[i].name,
            url: URL.createObjectURL(image[i]),
            file: image[i],
        });
    }
    document.getElementById("form").reset();
    document.getElementById("img-preview").innerHTML = imageShow();
}

function imageShow() {
    var image = "";
    images.forEach((i) => {
        var extension = i.name.substr((i.name.lastIndexOf('.') + 1));
        console.log(extension);
        if (extension == 'jpg' || extension == 'JPG' || extension == 'jpeg' || extension == 'JPEG' || extension == 'png' || extension == 'PNG') {
            image +=
                ` <div class="image_container position-relative">
                    <img src="` +
                i.url +
                `" alt="` +
                i.name +
                `"> 
                <span class="position-absolute" onclick="delete_image(` +
                images.indexOf(i) +
                `)">X</span>
                </div>`;
        } else {
            image +=
                ` <div class="image_container position-relative">
                <i class='bx bxs-file' style="font-size:90"></i>
                <p>${i.name}</p>
            <span class="position-absolute" onclick="delete_image(` +
                images.indexOf(i) +
                `)">X</span>
            </div>`;
        }
    });
    return image;
}

function delete_image(e) {
    images.splice(e, 1);
    document.getElementById("img-preview").innerHTML = imageShow();
}