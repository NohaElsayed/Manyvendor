/*this is all custom script*/
"use strict"
$(document).ready(function () {
    $(".textarea").summernote({
        height: 300,
        // codeviewFilter: true,
        // codeviewIframeFilter: true,
        // toolbar: [
        //     ['style', ['bold', 'italic', 'underline', 'clear']],
        //     ['font', ['strikethrough', 'superscript', 'subscript']],
        //     ['fontsize', ['fontsize']],
        //     ['color', ['color']],
        //     ['para', ['ul', 'ol', 'paragraph']],
        //     ['height', ['height']]
        // ]
    });

    $(".select2").select2({
        placeholder: "Choose option",
        allowClear: true,
    });
    $(".lang").select2({
        placeholder: "Choose option",
        templateResult: formatState,
        templateSelection: formatState,
    });

    $(".colorVariant").select2({
        placeholder: "Choose option",
        templateResult: formatStateVariant,
        templateSelection: formatStateVariant,
    });

    //published the all
    $('input[type="checkbox"]').change(function () {
        var url = this.dataset.url;
        var id = this.dataset.id;

        if (url != null && id != null) {
            $.ajax({
                url: url,
                data: { id: id },
                method: "get",
                success: function (result) {
                    toastr.success(result.message, toastr.options = {
                        "closeButton": false,
                        "debug": false,
                        "newestOnTop": false,
                        "progressBar": false,
                        "positionClass": "toast-top-right",
                        "preventDuplicates": false,
                        "onclick": null,
                        "showDuration": "30000",
                        "hideDuration": "1000",
                        "timeOut": "5000",
                        "extendedTimeOut": "1000",
                        "showEasing": "swing",
                        "hideEasing": "linear",
                        "showMethod": "fadeIn",
                        "hideMethod": "fadeOut"
                    });
                },
            });
        }
    });

    //hide the alert
    setTimeout(alertClose, 3000);
});

//this is for hide alert
function alertClose() {
    $("#gone").alert("close");
}

//show the modal in this function
function forModal(url, message) {
    $("#show-modal").modal("show");
    // $("#show-modal").dialog("open");
    $("#title").text(   message);
    $("#show-form").load(url);
    $("body").on("shown.bs.modal", ".modal", function () {
        $(this)
            .find("select")
            .each(function () {
                var dropdownParent = $(document.body);
                if ($(this).parents(".modal.in:first").length !== 0)
                    dropdownParent = $(this).parents(".modal.in:first");
                $(this).select2({
                    dropdownParent: dropdownParent,
                    templateResult: formatState,
                    templateSelection: formatState,
                });

            });
    });
}

//this function for show dropdown image
function formatState(opt) {
    if (!opt.id) {
        return opt.text.toUpperCase();
    }
    var optimage = $(opt.element).attr("data-image");
    console.log(optimage);
    if (!optimage) {
        return opt.text.toUpperCase();
    } else {
        var $opt = $(
            '<span><img src="' +
            optimage +
            '" width="32px" height="auto"/> ' +
            opt.text.toUpperCase() +
            "</span>"
        );
        return $opt;
    }
}

//this function for show dropdown image
function formatStateVariant(opt) {
    if (!opt.id) {
        return opt.text.toUpperCase();
    }
    var color = $(opt.element).attr("data-color");
    var name = $(opt.element).attr("data-name");
    if (!color) {
        return opt.text.toUpperCase();
    } else {
        var $opt = $(
            '<span><i class="fas fa-square" style="color: ' +
            color +
            '"><strong class="mx-2">' +
            name +
            "</strong></span>"
        );
        return $opt;
    }
}

//translate in one click
function copy() {
    $("#tranlation-table > tbody  > tr").each(function (index, tr) {
        $(tr).find(".value").val($(tr).find(".key").text());
    });
}

// avatar preview
function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            $("#imagePreview").css(
                "background-image",
                "url(" + e.target.result + ")"
            );
            $("#imagePreview").hide();
            $("#imagePreview").fadeIn(650);
        };
        reader.readAsDataURL(input.files[0]);
    }
}

$("#imageUpload").change(function () {
    readURL(this);
});

function imageUploadFIcon(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            $("#imagePreview_f_icon").css(
                "background-image",
                "url(" + e.target.result + ")"
            );
            $("#imagePreview_f_icon").hide();
            $("#imagePreview_f_icon").fadeIn(350);
        };
        reader.readAsDataURL(input.files[0]);
    }
}

$("#imageUpload_f_icon").change(function () {
    imageUploadFIcon(this);
});

function imageUploadFLogo(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            $("#imagePreview_f_logo").css(
                "background-image",
                "url(" + e.target.result + ")"
            );
            $("#imagePreview_f_logo").hide();
            $("#imagePreview_f_logo").fadeIn(650);
        };
        reader.readAsDataURL(input.files[0]);
    }
}

$("#imageUpload_f_logo").change(function () {
    imageUploadFLogo(this);
});


function imageUploadPlaystore(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            $("#imagePreview_Playstore").css(
                "background-image",
                "url(" + e.target.result + ")"
            );
            $("#imagePreview_Playstore").hide();
            $("#imagePreview_Playstore").fadeIn(350);
        };
        reader.readAsDataURL(input.files[0]);
    }
}

$("#imageUpload_Playstore").change(function () {
    imageUploadPlaystore(this);
});

function imageUploadAppstore(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            $("#imagePreview_Appstore").css(
                "background-image",
                "url(" + e.target.result + ")"
            );
            $("#imagePreview_Appstore").hide();
            $("#imagePreview_Appstore").fadeIn(350);
        };
        reader.readAsDataURL(input.files[0]);
    }
}

$("#imageUpload_Appstore").change(function () {
    imageUploadAppstore(this);
});

/*parent category select two use*/
$("select.parent-cat").on("change", function () {
    var selectCat = $(this).children("option:selected").val();

    var url = $(".childUrl").val();
    /*ajax get value*/
    if (url == null) {
        location.reload();
    } else {
        $.ajax({
            url: url,
            method: "GET",
            data: { id: selectCat },
            success: function (result) {
                $(".childCatShow").empty();
                var html = "";
                if (result.data.length > 0) {
                    result.data.forEach(function (item, index) {
                        html +=
                            '<option value="">Select category</option><option value="' +
                            item.id +
                            '">' +
                            item.name +''+ item.commission+"</option>";
                    });
                } else {
                    html = '<option value="">No data found</option>';
                }
                $(".childCatShow").append(html);
            },
        });
    }
});

/*parent category select two use*/
$("select.childCatShow").on("change", function () {
    var selectProduct = $(this).children("option:selected").val();

    var url = $(".productUrl").val();
    /*ajax get value*/
    if (url == null) {
        // location.reload()
    } else {
        $.ajax({
            url: url,
            method: "GET",
            data: { id: selectProduct },
            success: function (result) {
                $(".productShow").html(result);
            },
        });
    }
});

/*parent category select two use*/
$("select.productShow").on("change", function () {
    var chooseProduct = $(this).children("option:selected").val();

    var url = $(".productdetailsUrl").val();
    /*ajax get value*/
    if (url == null) {
        location.reload();
    } else {
        $.ajax({
            url: url,
            method: "GET",
            data: { id: chooseProduct },
            success: function (result) {
                $("#productDetails").html(result);
                // $('.select2').select2();
            },
        });
    }
});

/*division select*/
$("select.division").on("change", function () {
    var chooseDivision = $(this).children("option:selected").val();

    var url = $(".getDivisionArea").val();
    /*ajax get value*/
    if (url == null) {
        location.reload();
    } else {
        $.ajax({
            url: url,
            method: "GET",
            data: { id: chooseDivision },
            success: function (result) {
                $(".area").html(result);
            },
        });
    }
});

/*discount price show*/
$("#is_discount").on("change", function () {
    var data = $(this).val();

    if ($(this).prop("checked") == true) {
        $("#discount_price").removeClass("d-none");
    } else {
        $("#discount_price").addClass("d-none");
    }
});

/*variant show*/
$(".checkVariant").on("change", function () {
    var data = $(this).val();
    if ($(this).prop("checked") == true) {
        $("." + data).removeClass("d-none");
    } else {
        $("." + data).addClass("d-none");
    }
});

/*variant section show */
$(".add-variant").on("change", function () {
    if ($(this).prop("checked") == true) {
        $(".sr-variant").removeClass("d-none");
    } else {
        $(".sr-variant").addClass("d-none");
    }
});

/*delete imageRemove*/
function removeImage(url) {
    if (url != null) {
        $.ajax({
            url: url,
            method: "GET",
            success: function (result) {
                $(".remove-" + result.id).addClass("d-none");
                toastr.info(result.message, toastr.options = {
                    "closeButton": false,
                    "debug": false,
                    "newestOnTop": false,
                    "progressBar": false,
                    "positionClass": "toast-top-right",
                    "preventDuplicates": false,
                    "onclick": null,
                    "showDuration": "30000",
                    "hideDuration": "1000",
                    "timeOut": "5000",
                    "extendedTimeOut": "1000",
                    "showEasing": "swing",
                    "hideEasing": "linear",
                    "showMethod": "fadeIn",
                    "hideMethod": "fadeOut"
                });
            },
        });
    } else {
        location.reload();
    }
}
/*unit show in admin product create*/

var sampol = [];
$("#units").change(function () {
    var unit = $(this).val();
    $.each(sampol, function (i, v) {
        $("." + v).addClass("d-none");
    });
    $.each(unit, function (index, value) {
        $("." + value).removeClass("d-none");
        sampol.push(value);
    });
});

/*rumon*/
var count=0;
function incrementVariant() {
    count++;
    var $clone = $(".variant-table tbody tr:first").clone();
    $clone.attr({
        id: "emlRow_" + count
    });
    $clone.find(".remove").each(function(){
        $(this).attr({
            id: $(this).attr("id") + count,
        });
    });
    $(".variant-table tbody").append($clone);
}





function deleteTr(id) {
    $('#emlRow_'+id).remove();
}

/**Add To Campaign */
function addToCampaign(vendor_product_id, campaign_id) {
    var url = $(".add-to-campaign-url").val();
    if (vendor_product_id != null && url != null && campaign_id != null) {
        $.ajax({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            url: url,
            method: "POST",
            data: {
                vendor_product_id: vendor_product_id,
                campaign_id: campaign_id,
            },
            success: function (result) {
                $(".campaign-add-btn-" + vendor_product_id).empty();
                var footer = "";
                footer +=
                    '<a href="#!" class="btn btn-danger px-3 campaign-add-btn-{{$product->id}}" onclick="removeFromCampaign(' +
                    vendor_product_id +
                    "," +
                    campaign_id +
                    ')">' +
                    result.btn_rmv +
                    "</a>";
                $(".campaign-add-btn-" + vendor_product_id).append(footer);
                //notification
                toastr.success(
                    result.message,
                    (toastr.options = {
                        closeButton: false,
                        debug: false,
                        newestOnTop: false,
                        progressBar: false,
                        positionClass: "toast-top-right",
                        preventDuplicates: false,
                        onclick: null,
                        showDuration: "30000",
                        hideDuration: "1000",
                        timeOut: "5000",
                        extendedTimeOut: "1000",
                        showEasing: "swing",
                        hideEasing: "linear",
                        showMethod: "fadeIn",
                        hideMethod: "fadeOut",
                    })
                );
            },
        });
    } else {
        location.reload();
    }
}
//end add to campaign products

//Campaign remove product
function removeFromCampaign(vendor_product_id, campaign_id) {
    var url = $(".remove-from-campaign-url").val();
    if (vendor_product_id != null && url != null && campaign_id != null) {
        $.ajax({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            url: url,
            method: "POST",
            data: {
                vendor_product_id: vendor_product_id,
                campaign_id: campaign_id,
            },
            success: function (result) {
                $(".campaign-add-btn-" + vendor_product_id).empty();
                var footer = "";
                footer +=
                    '<a href="#!" class="btn btn-success px-3 campaign-add-btn-{{$product->id}}" onclick="addToCampaign(' +
                    vendor_product_id +
                    "," +
                    campaign_id +
                    ')">' +
                    result.btn_add +
                    "</a>";
                $(".campaign-add-btn-" + vendor_product_id).append(footer);
                //notification
                toastr.error(
                    result.message,
                    (toastr.options = {
                        closeButton: false,
                        debug: false,
                        newestOnTop: false,
                        progressBar: false,
                        positionClass: "toast-top-right",
                        preventDuplicates: false,
                        onclick: null,
                        showDuration: "30000",
                        hideDuration: "1000",
                        timeOut: "5000",
                        extendedTimeOut: "1000",
                        showEasing: "swing",
                        hideEasing: "linear",
                        showMethod: "fadeIn",
                        hideMethod: "fadeOut",
                    })
                );
            },
        });
    } else {
        location.reload();
    }
}


/**Add To E-commerce Campaign */
function addToEcomCampaign(product_id, campaign_id) {
    var url = $(".add-to-campaign-url").val();
    if (product_id != null && url != null && campaign_id != null) {
        $.ajax({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            url: url,
            method: "POST",
            data: {
                product_id: product_id,
                campaign_id: campaign_id,
            },
            success: function (result) {
                $(".ecom-campaign-add-btn-" + product_id).empty();
                var footer = "";
                footer +=
                    '<a href="#!" class="btn btn-danger px-3 ecom-campaign-add-btn-{{$product->id}}" onclick="removeFromEcomCampaign(' +
                    product_id +
                    "," +
                    campaign_id +
                    ')">' +
                    result.btn_rmv +
                    "</a>";
                $(".ecom-campaign-add-btn-" + product_id).append(footer);
                //notification
                toastr.success(
                    result.message,
                    (toastr.options = {
                        closeButton: false,
                        debug: false,
                        newestOnTop: false,
                        progressBar: false,
                        positionClass: "toast-top-right",
                        preventDuplicates: false,
                        onclick: null,
                        showDuration: "30000",
                        hideDuration: "1000",
                        timeOut: "5000",
                        extendedTimeOut: "1000",
                        showEasing: "swing",
                        hideEasing: "linear",
                        showMethod: "fadeIn",
                        hideMethod: "fadeOut",
                    })
                );
            },
        });
    } else {
        location.reload();
    }
}
//end add to E-commerce campaign products

//E-commerce Campaign remove product
function removeFromEcomCampaign(product_id, campaign_id) {
    var url = $(".remove-from-campaign-url").val();
    if (product_id != null && url != null && campaign_id != null) {
        $.ajax({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            url: url,
            method: "POST",
            data: {
                product_id:  product_id,
                campaign_id: campaign_id,
            },
            success: function (result) {
                $(".ecom-campaign-add-btn-" + product_id).empty();
                var footer = "";
                footer +=
                    '<a href="#!" class="btn btn-success px-3 ecom-campaign-add-btn-{{$product->id}}" onclick="addToEcomCampaign(' +
                    product_id +
                    "," +
                    campaign_id +
                    ')">' +
                    result.btn_add +
                    "</a>";
                $(".ecom-campaign-add-btn-" + product_id).append(footer);
                //notification
                toastr.error(
                    result.message,
                    (toastr.options = {
                        closeButton: false,
                        debug: false,
                        newestOnTop: false,
                        progressBar: false,
                        positionClass: "toast-top-right",
                        preventDuplicates: false,
                        onclick: null,
                        showDuration: "30000",
                        hideDuration: "1000",
                        timeOut: "5000",
                        extendedTimeOut: "1000",
                        showEasing: "swing",
                        hideEasing: "linear",
                        showMethod: "fadeIn",
                        hideMethod: "fadeOut",
                    })
                );
            },
        });
    } else {
        location.reload();
    }
}

// Logistics area activation
$(".is_active").on("change", function () {
    var url = this.dataset.url;
    var id = this.dataset.id;

    if (url != null && id != null) {
        $.ajax({
            url: url,
            data: { id: id },
            method: "get",
            success: function (result) {
                //notification
                toastr.error(
                    result.message,
                    (toastr.options = {
                        closeButton: false,
                        debug: false,
                        newestOnTop: false,
                        progressBar: false,
                        positionClass: "toast-top-right",
                        preventDuplicates: false,
                        onclick: null,
                        showDuration: "30000",
                        hideDuration: "1000",
                        timeOut: "5000",
                        extendedTimeOut: "1000",
                        showEasing: "swing",
                        hideEasing: "linear",
                        showMethod: "fadeIn",
                        hideMethod: "fadeOut",
                    })
                );
            },
        });
    }
});

// Logistics activation
$(".logistic_activation").on("change", function () {
    var url = this.dataset.url;
    var id = this.dataset.id;

    if (url != null && id != null) {
        $.ajax({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            url: url,
            data: { id: id },
            method: "POST",
            success: function (result) {
                //notification
                toastr.success(
                    result.message,
                    (toastr.options = {
                        closeButton: false,
                        debug: false,
                        newestOnTop: false,
                        progressBar: false,
                        positionClass: "toast-top-right",
                        preventDuplicates: false,
                        onclick: null,
                        showDuration: "30000",
                        hideDuration: "1000",
                        timeOut: "5000",
                        extendedTimeOut: "1000",
                        showEasing: "swing",
                        hideEasing: "linear",
                        showMethod: "fadeIn",
                        hideMethod: "fadeOut",
                    })
                );
            },
        });
    }
});

// Coupon activation
$(".coupon_activation").on("change", function () {
    var url = this.dataset.url;
    var id = this.dataset.id;

    if (url != null && id != null) {
        $.ajax({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            url: url,
            data: { id: id },
            method: "POST",
            success: function (result) {
                //notification
                toastr.success(
                    result.message,
                    (toastr.options = {
                        closeButton: false,
                        debug: false,
                        newestOnTop: false,
                        progressBar: false,
                        positionClass: "toast-top-right",
                        preventDuplicates: false,
                        onclick: null,
                        showDuration: "30000",
                        hideDuration: "1000",
                        timeOut: "5000",
                        extendedTimeOut: "1000",
                        showEasing: "swing",
                        hideEasing: "linear",
                        showMethod: "fadeIn",
                        hideMethod: "fadeOut",
                    })
                );
            },
        });
    }
});


// Promotion activation
$(".is_published").on("change", function () {
    var url = this.dataset.url;
    var id = this.dataset.id;

    if (url != null && id != null) {
        $.ajax({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            url: url,
            data: { id: id },
            method: "POST",
            success: function (result) {
                //notification
                toastr.success(
                    result.message,
                    (toastr.options = {
                        closeButton: false,
                        debug: false,
                        newestOnTop: false,
                        progressBar: false,
                        positionClass: "toast-top-right",
                        preventDuplicates: false,
                        onclick: null,
                        showDuration: "30000",
                        hideDuration: "1000",
                        timeOut: "5000",
                        extendedTimeOut: "1000",
                        showEasing: "swing",
                        hideEasing: "linear",
                        showMethod: "fadeIn",
                        hideMethod: "fadeOut",
                    })
                );
            },
        });
    }
});
//end remove campaign product

//tax of product show
$(".add-tax").on("change", function () {
    if ($(this).prop("checked") == true) {
        $(".tax-input").removeClass("d-none");
        $(".tax-input-val").val($(".tax-value-for-update").val());
    } else {
        $(".tax-input").addClass("d-none");
        $(".tax-input-val").val(0);
    }
});
//tax of product show ends


$('#instructorSelect').change(function () {
    $('#ins_search').submit();
});


// Live text search|| All shop
$(document).ready(function () {
    $("#searchStore").on("keyup", function () {
        var value = $(this).val().toLowerCase();
        $("tbody tr").filter(function () {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
    });
});


$('a').tooltip();

var dropzone = false; //is dropzone used? True or false. Default - false. True if used.
var total_bytes_uploaded = 0;
var limit_size = 1024000; // 1000 KB * 1024 byte/KB = 512000 bytes.



// DROP ZONE
function handleFileSelect2(evt) {
    //total_bytes_uploaded = 0;
    evt.stopPropagation();
    evt.preventDefault();
    dropzone = true;
    handleFileSelect3(evt, dropzone);
    dropzone = false;
}

function handleDragOver(evt) {
    evt.stopPropagation();
    evt.preventDefault();
    evt.dataTransfer.dropEffect = 'copy'; // Explicitly show this is a copy.
}

// Setup the Drag n' Drop listeners.
var dropZone = document.getElementById('drop_zone');
dropZone.addEventListener('dragover', handleDragOver, false);
dropZone.addEventListener('drop', handleFileSelect2, false);





// PROGRESS BAR
var reader;
var progress = document.querySelector('.percent');

function updateProgress(evt) {
    // evt is a ProgressEvent.
    if (evt.lengthComputable) {
        var percentLoaded = Math.round((evt.loaded / evt.total) * 100);
        // Increase the progress bar length.
        if (percentLoaded < 100) {
            progress.style.width = percentLoaded + '%';
            progress.textContent = percentLoaded + '%';
        }
    }
}

function abortRead() {
    reader.abort();
}

function errorHandler(evt) {
    switch (evt.target.error.code) {
        case evt.target.error.NOT_FOUND_ERR:
            alert('File Not Found!');
            break;
        case evt.target.error.NOT_READABLE_ERR:
            alert('File is not readable');
            break;
        case evt.target.error.ABORT_ERR:
            break; // noop
        default:
            alert('An error occurred reading this file.');
    }
}

function handleFileSelect3(evt, dropzone) {
    total_bytes_uploaded = 0; //reset total bytes counting
    if (dropzone == true) {
        var dropbox_files = evt.dataTransfer.files; //evt.dataTransfer.files not available inside reader.onload, so store this here.
    }
    // Reset progress indicator on new file selection.
    progress.style.width = '0%';
    progress.textContent = '0%';
    reader = new FileReader();
    reader.onerror = errorHandler;
    reader.onprogress = updateProgress;
    reader.onabort = function (e) {
        alert('File read cancelled');
    };
    reader.onloadstart = function (e) {
        document.getElementById('progress_bar').className = 'loading';
    };
    reader.onload = function (e) {
        // Ensure that the progress bar displays 100% at the end.
        progress.style.width = '100%';
        progress.textContent = '100%';
        setTimeout("document.getElementById('progress_bar').className='';", 2000);

        //fill result file-list for 3-rd example
        //___BEGIN___
        var files = (dropzone == true) ? dropbox_files : evt.target.files; // FileList object

        // files is a FileList of File objects. List some properties.
        var output = [];
        for (var i = 0, f; f = files[i]; i++) {
            total_bytes_uploaded = total_bytes_uploaded + f.size;
            output.push('<li><strong>', escape(f.name), '</strong> (', f.type || 'n/a', ') - ',
                f.size, ' bytes, last modified: ',
                f.lastModifiedDate ? f.lastModifiedDate.toLocaleDateString() : 'n/a',
                '</li>');
        }
        //filelist generated...

        if (total_bytes_uploaded > limit_size) {
            //add oversize notification...
            output.push('<li><strong><font color="red">total_size (', total_bytes_uploaded, ' bytes) > limit_size (', limit_size, ' bytes)</font></string></li>');
        }
        document.getElementById('file_list3').innerHTML = '<ul>' + output.join('') + '</ul>';
        //___END___
    };

    // Read in the file as a binary string.
    if (dropzone != true && typeof evt.target.files[0] == 'undefined') {} //if not dropzone, but no any files, maybe selected empty file... Do nothing in this case...
    else { //else, try to read
        reader.readAsBinaryString(
            (dropzone == true) //if files uploaded using dropzone
            ?
            evt.dataTransfer.files[0] //read this
            :
            evt.target.files[0] //if by selecting files - read this.
        );
    }
}

document.getElementById('files1').addEventListener('change', handleFileSelect3, false);





