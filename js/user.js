function logout()
{
    Swal.fire({
        type: 'warning',
        title: 'Are you sure?',
        text: "Do you want logout ?",
        showCancelButton: false,
        background: "#000",
        backdrop: "rgba(0,0,0,0.2)",
        buttonsStyling: !1,
        padding: "3rem 3rem 2rem",
        customClass: {
            confirmButton: "btn btn-theme",
            title: "ca-title",
            container: "ca"
        },
        confirmButtonText: 'Yes, logout me!'
    }).then((result) => {
        if (result.value) {
            $.ajax({
                type: "GET",
                url: 'login?do=logout',
                success: function (msg) {
                    if (msg == 'ok') {
                        swal.fire({
                            type: 'success',
                            title: "Success!",
                            text: "You are logged out",
                            background: "#000",
                            backdrop: "rgba(0,0,0,0.2)",
                            buttonsStyling: !1,
                            padding: "3rem 3rem 2rem",
                            customClass: {
                                confirmButton: "btn btn-link",
                                title: "ca-title",
                                container: "ca"
                            }
                        })
                        setTimeout("window.location.reload();", 1000);
                    } else {
                        swal.fire({
                            type: 'error',
                            title: "Error!",
                            text: "We can't logout you.",
                            background: "#000",
                            backdrop: "rgba(0,0,0,0.2)",
                            buttonsStyling: !1,
                            padding: "3rem 3rem 2rem",
                            customClass: {
                                confirmButton: "btn btn-link",
                                title: "ca-title",
                                container: "ca"
                            }
                        })
                    }
                },
                error: function (msg) {
                    swal.fire({
                        type: 'error',
                        title: "Error!",
                        text: "Check your internet connection.",
                        background: "#000",
                        backdrop: "rgba(0,0,0,0.2)",
                        buttonsStyling: !1,
                        padding: "3rem 3rem 2rem",
                        customClass: {
                            confirmButton: "btn btn-link",
                            title: "ca-title",
                            container: "ca"
                        }
                    })
                }
            })
        }
    })
}
function delbuyedrdp()
{
    Swal.fire({
        type: 'question',
        title: 'Are you sure?',
        text: "Do you want delete all RDP ?",
        showCancelButton: true,
        background: "#000",
        backdrop: "rgba(0,0,0,0.2)",
        buttonsStyling: !1,
        padding: "3rem 3rem 2rem",
        customClass: {
            confirmButton: "btn btn-theme",
            cancelButton: "btn btn-theme ml-3",
            title: "ca-title",
            container: "ca"
        },
        confirmButtonText: 'Yes',
        cancelButtonText: "NO"
    }).then((result) => {
        if (result.value) {
            $.ajax({
                type: "GET",
                url: 'rdp?act=myrdp&alldel=1',
                success: function (msg) {
                    if (msg == 'ok') {
                        swal.fire({
                            type: 'success',
                            title: "Success!",
                            text: "All purchased RDP deleted",
                            background: "#000",
                            backdrop: "rgba(0,0,0,0.2)",
                            buttonsStyling: !1,
                            padding: "3rem 3rem 2rem",
                            customClass: {
                                confirmButton: "btn btn-link",
                                title: "ca-title",
                                container: "ca"
                            }
                        })
                        setTimeout("window.location.reload();", 1000);
                    } else {
                        swal.fire({
                            type: 'error',
                            title: "Error!",
                            text: "We can't delete your RDP",
                            background: "#000",
                            backdrop: "rgba(0,0,0,0.2)",
                            buttonsStyling: !1,
                            padding: "3rem 3rem 2rem",
                            customClass: {
                                confirmButton: "btn btn-link",
                                title: "ca-title",
                                container: "ca"
                            }
                        })
                    }
                },
                error: function (msg) {
                    swal.fire({
                        type: 'error',
                        title: "Error!",
                        text: "Check your internet connection.",
                        background: "#000",
                        backdrop: "rgba(0,0,0,0.2)",
                        buttonsStyling: !1,
                        padding: "3rem 3rem 2rem",
                        customClass: {
                            confirmButton: "btn btn-link",
                            title: "ca-title",
                            container: "ca"
                        }
                    })
                }
            })
        }
    })
}
function swalshow(type, msg, reset = false) {
    if (type == 'success') {
        swal.fire({
            type: 'success',
            title: "Success!",
            text: msg,
            background: "#000",
            timer: 1000,
            backdrop: "rgba(0,0,0,0.2)",
            buttonsStyling: !1,
            showConfirmButton: false,
            padding: "3rem 3rem 2rem",
            customClass: {
                confirmButton: "btn btn-link",
                title: "ca-title",
                container: "ca"
            }
        })
        if (reset) {
            setTimeout("window.location.reload();", 1000);
        }
    } else if (type == 'error') {
        swal.fire({
            type: 'error',
            title: "Error!",
            text: msg,
            background: "#000",
            backdrop: "rgba(0,0,0,0.2)",
            buttonsStyling: !1,
            padding: "3rem 3rem 2rem",
            customClass: {
                confirmButton: "btn btn-link",
                title: "ca-title",
                container: "ca"
            }
        })
        if (reset) {
            setTimeout("window.location.reload();", 1000);
        }
}
}
$('#user-modal').on('show.bs.modal', function (e) {
    $('#user-modal').addClass('fade');
    var button = $(e.relatedTarget);
    var modal = $(this);
    $(this).load(button.data("remote"));
});
$('body').on('hidden.bs.modal', '#user-modal', function () {
    $(this).empty();
});
$('#ajax-modal').on('show.bs.modal', function (e) {
    $('#ajax-modal').addClass('fade');
    var button = $(e.relatedTarget);
    var modal = $(this);
    $(this).load(button.data("remote"));
});
$('body').on('hidden.bs.modal', '#ajax-modal', function () {
    $(this).empty();
});
function open(link) {
    $('.content').hide();
    loading();
    setTimeout("document.location.href='" + link + "'", 0);
}

function cardsort() {
    var cat = document.getElementById('catid').options[document.getElementById('catid').selectedIndex].value;
    var cardbin = getSelectValues($('#cardbin').select2('data'));
    var cardcountry = document.getElementById('cardcountry').options[document.getElementById('cardcountry').selectedIndex].value;
    var cardstate = document.getElementById('cardstate').options[document.getElementById('cardstate').selectedIndex].value;
    var cardcity = document.getElementById('cardcity').options[document.getElementById('cardcity').selectedIndex].value;
    var cardzip = document.getElementById('cardzip').value;
    var cardPerPage = document.getElementById('cardPerPage').options[document.getElementById('cardPerPage').selectedIndex].value;
    var cardtype = document.getElementById('cardtype').options[document.getElementById('cardtype').selectedIndex].value;
    var level = document.getElementById('cardlevel').options[document.getElementById('cardlevel').selectedIndex].value;
    var cardclass = document.getElementById('cardclass').options[document.getElementById('cardclass').selectedIndex].value;
    var bank = document.getElementById('cardbank').options[document.getElementById('cardbank').selectedIndex].value;
    if ($('#vendor')[0]) {
        var vendor = '&vendor=' + document.getElementById('vendor').options[document.getElementById('vendor').selectedIndex].value;
    } else {
        var vendor = '';
    }
    if ($('#pricerange')[0]) {
        var pricerange = '&pricerange=' + $("#pricerange").slider("value");
    } else {
        var pricerange = '';
    }
    if ($('#pricesort')[0]) {
        var pricesort = '&pricesort=' + document.getElementById('pricesort').value;
    } else {
        var pricesort = '';
    }
    if ($('#ssn')[0]) {
        var ssn = document.getElementById('ssn').options[document.getElementById('ssn').selectedIndex].value;
    }
    if ($('#dob')[0]) {
        var dob = document.getElementById('dob').options[document.getElementById('dob').selectedIndex].value;
    }
    if ($('#vbv')[0]) {
        var vbv = document.getElementById('vbv').options[document.getElementById('vbv').selectedIndex].value;
    }
    if ($('#dl')[0]) {
        var dl = document.getElementById('dl').options[document.getElementById('dl').selectedIndex].value;
    }
    if ($('#mmn')[0]) {
        var mmn = document.getElementById('mmn').options[document.getElementById('mmn').selectedIndex].value;
    }
    open('/card?cat=' + cat + '&bin=' + cardbin + '&country=' + cardcountry + '&state=' + cardstate + '&city=' + cardcity + '&zip=' + cardzip + '&page=1&perpage=' + cardPerPage + '&type=' + cardtype + '&level=' + level + '&class=' + cardclass + '&bank=' + bank + '&ssn=' + ssn + '&dob=' + dob + '&vbv=' + vbv + '&dl=' + dl + '&mmn=' + mmn + vendor + pricesort + pricerange);
}
function cardpricesort(i) {
    if (i.className == 'sorting_asc') {
        $('#pricesort').val('asc');
    } else {
        $('#pricesort').val('desc');
    }
    cardsort();
}
function dumppricesort(i) {
    if (i.className == 'sorting_asc') {
        $('#pricesort').val('asc');
    } else {
        $('#pricesort').val('desc');
    }
    dumpsort();
}
function rdppricesort(i) {
    if (i.className == 'sorting_asc') {
        $('#pricesort').val('asc');
    } else {
        $('#pricesort').val('desc');
    }
    rdpsort();
}

function sshpricesort(i) {
    if (i.className == 'sorting_asc') {
        $('#pricesort').val('asc');
    } else {
        $('#pricesort').val('desc');
    }
    sshsort();
}
function logspricesort(i) {
    if (i.className == 'sorting_asc') {
        $('#pricesort').val('asc');
    } else {
        $('#pricesort').val('desc');
    }
    logsort();
}
function rdpsort() {
    var mask = document.getElementById('mask').value;
    var country = document.getElementById('country').options[document.getElementById('country').selectedIndex].value;
    var state = document.getElementById('state').options[document.getElementById('state').selectedIndex].value;
    var city = document.getElementById('city').options[document.getElementById('city').selectedIndex].value;
    var isp = escape(document.getElementById('isp').value);
    var os = document.getElementById('os').options[document.getElementById('os').selectedIndex].value;
    var nat = document.getElementById('nat').options[document.getElementById('nat').selectedIndex].value;
    var ram = document.getElementById('ram').options[document.getElementById('ram').selectedIndex].value;
    var inspeed = document.getElementById('inspeed').options[document.getElementById('inspeed').selectedIndex].value;
    var outspeed = document.getElementById('outspeed').options[document.getElementById('outspeed').selectedIndex].value;
    if ($('#pricerange')[0]) {
        var pricerange = '&pricerange=' + $("#pricerange").slider("value");
    } else {
        var pricerange = '';
    }
    if ($('#pricesort')[0]) {
        var pricesort = '&pricesort=' + document.getElementById('pricesort').value;
    } else {
        var pricesort = '';
    }
    if ($('#vendor')[0]) {
        var vendor = '&vendor=' + document.getElementById('vendor').options[document.getElementById('vendor').selectedIndex].value;
    } else {
        var vendor = '';
    }
    var admin = document.getElementById('admin').options[document.getElementById('admin').selectedIndex].value;
    var paypal = document.getElementById('paypal').options[document.getElementById('paypal').selectedIndex].value;
    var PerPage = document.getElementById('PerPage').options[document.getElementById('PerPage').selectedIndex].value;
    open('/rdp?mask=' + mask + '&country=' + country + '&state=' + state + '&city=' + city + '&os=' + os + '&nat=' + nat + '&page=1&perpage=' + PerPage + '&ram=' + ram + '&inspeed=' + inspeed + '&outspeed=' + outspeed + '&admin=' + admin + '&paypal=' + paypal + '&isp=' + isp + pricesort + pricerange + vendor);
}

function sshsort() {
    var mask = document.getElementById('mask').value;
    var country = document.getElementById('country').options[document.getElementById('country').selectedIndex].value;
    var state = document.getElementById('state').options[document.getElementById('state').selectedIndex].value;
    var city = document.getElementById('city').options[document.getElementById('city').selectedIndex].value;
    var zip = document.getElementById('zip').value;
    if ($('#inspeed')[0]) {
        var inspeed = document.getElementById('inspeed').options[document.getElementById('inspeed').selectedIndex].value;
    }
    if ($('#outspeed')[0]) {
        var outspeed = document.getElementById('outspeed').options[document.getElementById('outspeed').selectedIndex].value;
    }
    if ($('#pricerange')[0]) {
        var pricerange = '&pricerange=' + $("#pricerange").slider("value");
    } else {
        var pricerange = '';
    }
    if ($('#pricesort')[0]) {
        var pricesort = '&pricesort=' + document.getElementById('pricesort').value;
    } else {
        var pricesort = '';
    }
    if ($('#vendor')[0]) {
        var vendor = '&vendor=' + document.getElementById('vendor').options[document.getElementById('vendor').selectedIndex].value;
    } else {
        var vendor = '';
    }
    if ($('#ping')[0]) {
        var ping = document.getElementById('ping').options[document.getElementById('ping').selectedIndex].value;
    }
    var PerPage = document.getElementById('PerPage').options[document.getElementById('PerPage').selectedIndex].value;
    open('/ssh?mask=' + mask + '&country=' + country + '&state=' + state + '&city=' + city + '&zip=' + zip + '&ping=' + ping + '&page=1&perpage=' + PerPage + '&inspeed=' + inspeed + '&outspeed=' + outspeed + pricesort + pricerange + vendor);
}

function dumpsort() {
    var cat = document.getElementById('catid').options[document.getElementById('catid').selectedIndex].value;
    var cardbin = getSelectValues($('#cardbin').select2('data'));
    var last4 = document.getElementById('last4').value;
    var zip = document.getElementById('zip').value;
    var type = document.getElementById('type').options[document.getElementById('type').selectedIndex].value;
    var code = document.getElementById('code').options[document.getElementById('code').selectedIndex].value;
    var level = document.getElementById('level').options[document.getElementById('level').selectedIndex].value;
    var dumpclass = document.getElementById('class').options[document.getElementById('class').selectedIndex].value;
    var cardcountry = document.getElementById('cardcountry').options[document.getElementById('cardcountry').selectedIndex].value;
    var cardstate = document.getElementById('cardstate').options[document.getElementById('cardstate').selectedIndex].value;
    var cardPerPage = document.getElementById('cardPerPage').options[document.getElementById('cardPerPage').selectedIndex].value;
    if ($('#pricerange')[0]) {
        var pricerange = '&pricerange=' + $("#pricerange").slider("value");
    } else {
        var pricerange = '';
    }
    if ($('#pricesort')[0]) {
        var pricesort = '&pricesort=' + document.getElementById('pricesort').value;
    } else {
        var pricesort = '';
    }
    if ($('#tr1')[0]) {
        var tr1 = document.getElementById('tr1').options[document.getElementById('tr1').selectedIndex].value;
    }
    if ($('#pin')[0]) {
        var pin = document.getElementById('pin').options[document.getElementById('pin').selectedIndex].value;
    }
    if ($('#vendor')[0]) {
        var vendor = '&vendor=' + document.getElementById('vendor').options[document.getElementById('vendor').selectedIndex].value;
    } else {
        var vendor = '';
    }
    var bank = document.getElementById('bank').options[document.getElementById('bank').selectedIndex].value;
    open('/dumps?cat=' + cat + '&bin=' + cardbin + '&last4=' + last4 + '&type=' + type + '&code=' + code + '&level=' + level + '&class=' + dumpclass + '&country=' + cardcountry + '&bank=' + bank + '&page=1&perpage=' + cardPerPage + '&pin=' + pin + '&tr1=' + tr1 + '&state=' + cardstate + '&zip=' + zip + pricesort + pricerange + vendor);
}

function ppsort() {
    var type = document.getElementById('type').options[document.getElementById('type').selectedIndex].value;
    var maildomain = document.getElementById('maildomain').value;
    var status = document.getElementById('status').options[document.getElementById('status').selectedIndex].value;
    var mailaccess = document.getElementById('mailaccess').options[document.getElementById('mailaccess').selectedIndex].value;
    var cookie = document.getElementById('cookie').options[document.getElementById('cookie').selectedIndex].value;
    var zip = document.getElementById('zip').value;
    var creditcard = document.getElementById('creditcard').options[document.getElementById('creditcard').selectedIndex].value;
    var bank = document.getElementById('bank').options[document.getElementById('bank').selectedIndex].value;
    var country = document.getElementById('country').options[document.getElementById('country').selectedIndex].value;
    var state = document.getElementById('state').options[document.getElementById('state').selectedIndex].value;
    var balance_type = document.getElementById('balance_type').options[document.getElementById('balance_type').selectedIndex].value;
    var balance_min = document.getElementById('balance_min').value;
    var balance_max = document.getElementById('balance_max').value;
    var checked_min = document.getElementById('checked_min').value;
    var checked_max = document.getElementById('checked_max').value;
    var last_transaction_min = document.getElementById('last_transaction_min').value;
    var last_transaction_max = document.getElementById('last_transaction_max').value;
    if (document.querySelector('#mailconfirm').checked) {
        var mailconfirm = '1';
    }
    if (document.querySelector('#ccnoexp').checked) {
        var ccnoexp = '1';
    }
    open('/paypal?type=' + type + '&status=' + status + '&mailaccess=' + mailaccess + '&cookie=' + cookie + '&creditcard=' + creditcard + '&ccnoexp=' + ccnoexp + '&page=1&maildomain=' + maildomain + '&mailconfirm=' + mailconfirm + '&bank=' + bank + '&country=' + country + '&state=' + state + '&zip=' + zip + '&balance_min=' + balance_min + '&balance_max=' + balance_max + '&checked_min=' + checked_min + '&checked_max=' + checked_max + '&last_transaction_min=' + last_transaction_min + '&last_transaction_max=' + last_transaction_max + '&balance_type=' + balance_type);
}
function searchbymask() {
    $('#btnlinkserch').show();
    $('#btnmaskserch').hide();
    $('.maskpanel').show();
    $('.linkspanel').hide();
    $('#linkslabel').html('Mask:');
}
function searchbylinks() {
    $('#btnlinkserch').hide();
    $('#btnmaskserch').show();
    $('.maskpanel').hide();
    $('.linkspanel').show();
    $('#linkslabel').html('Links:');
}
function logsort() {
    var stealer = document.getElementById('stealer').options[document.getElementById('stealer').selectedIndex].value;
    var system = document.getElementById('system').options[document.getElementById('system').selectedIndex].value;
    var cardcountry = document.getElementById('cardcountry').options[document.getElementById('cardcountry').selectedIndex].value;
    var cardstate = document.getElementById('cardstate').options[document.getElementById('cardstate').selectedIndex].value;
    var city = document.getElementById('city').options[document.getElementById('city').selectedIndex].value;
    var zip = document.getElementById('zip').value;
    if ($('#vendor')[0]) {
        var vendor = '&vendor=' + document.getElementById('vendor').options[document.getElementById('vendor').selectedIndex].value;
    } else {
        var vendor = '';
    }
    if ($('#pricerange')[0]) {
        var pricerange = '&pricerange=' + $("#pricerange").slider("value");
    } else {
        var pricerange = '';
    }
    if ($('#pricesort')[0]) {
        var pricesort = '&pricesort=' + document.getElementById('pricesort').value;
    } else {
        var pricesort = '';
    }
    var isp = document.getElementById('isp').value;
    var outlook = document.getElementById('outlook').value;
    var links = getSelectValues($('#links').select2('data'));
    if ($('#mask')[0]) {
        var mask = '&mask=' + getSelectValues($('#mask').select2('data'));
        ;
    } else {
        var mask = '';
    }
    var cardPerPage = document.getElementById('cardPerPage').options[document.getElementById('cardPerPage').selectedIndex].value;
    if (document.querySelector('#withcookies').checked) {
        var withcookies = '1';
    } else {
        var withcookies = '0';
    }
    open('/logs?stealer=' + stealer + '&system=' + system + '&country=' + cardcountry + '&state=' + cardstate + '&city=' + city + '&zip=' + zip + '&page=1&perpage=' + cardPerPage + '&isp=' + isp + '&outlook=' + outlook + '&links=' + links + '&withcookies=' + withcookies + pricesort + pricerange + vendor + mask);
}

function blackcheckanimate(Id) {
    $("#blackResult" + Id).html('<button type="button" class="btn btn-outline-theme"><i class="fa fa-spinner fa-pulse" style="font-size: 1.2rem !important;margin-top: 3px;cursor: progress"></i></button>').show();
}

function buybuttonanimate(divid) {
    $(divid).html('<button type="button" class="btn btn-outline-theme"><i class="fa fa-spinner fa-pulse" style="font-size: 1.2rem !important;margin-top: 3px;cursor: progress"></i></button>').show();
}
function checkingbtn(id) {
    $(id).html('<i class="fa fa-spinner fa-pulse" style="font-size: 1.2rem !important;margin-top: 3px;cursor: progress"></i>');
    $(id).attr('disabled', true);
}
function blacklist(Id)
{
    $.ajax({
        type: "GET",
        url: "./rdp?act=blacklist&id=" + Id,
        beforeSend: blackcheckanimate(Id),
        success: function (msg) {
            $("#blackResult" + Id).hide();
            $("#blackResult" + Id).html(msg).show();
        },
        error: function (msg) {
            ajaxerror();
        }
    });
}

function sshblacklist(Id)
{
    $.ajax({
        type: "GET",
        url: "./ssh?act=blacklist&id=" + Id,
        beforeSend: blackcheckanimate(Id),
        success: function (msg) {
            $("#blackResult" + Id).hide();
            $("#blackResult" + Id).html(msg).show();
        },
        error: function (msg) {
            ajaxerror();
        }
    });
}

function all_add_to_cart() {
    $('.cardcart').each(function () {
        if ($(".cardcart").is(":checked")) {
            add_to_cart($(this).attr('item_id'));
        } else {
            remove_from_cart($(this).attr('item_id'));
        }
    }
    );
}
function dump_all_add_to_cart() {
    $('.dump').each(function () {
        if ($(".dumpallcart").is(":checked")) {
            dump_add_to_cart($(this).attr('item_id'));
        } else {
            dump_remove_from_cart($(this).attr('item_id'));
        }
    }
    );
}
function dump_cart_select(card_id) {
    $('#card-' + card_id).each(function () {
        if ($('#card-' + card_id).is(":checked")) {
            dump_add_to_cart($(this).attr('item_id'));
        } else {
            dump_remove_from_cart($(this).attr('item_id'));
        }
    });
}
function dump_add_to_cart(card_id)
{
    $.ajax({
        type: "POST",
        url: "dumpcart?act=add",
        async: false,
        data: "card_id=" + card_id,
    });
    success: cartupdate();
}
function cart_select(card_id) {
    $('#card-' + card_id).each(function () {
        if ($('#card-' + card_id).is(":checked")) {
            add_to_cart($(this).attr('item_id'));
        } else {
            remove_from_cart($(this).attr('item_id'));
        }
    });
}

function add_to_cart(card_id)
{
    $.ajax({
        type: "POST",
        url: "cart?act=add",
        async: false,
        data: "card_id=" + card_id,
    });
    success: cartupdate();
}
function remove_from_cart(card_id)
{
    $.ajax({
        type: "POST",
        url: "cart?act=remove",
        async: false,
        data: "card_id=" + card_id,
    });
    success: cartupdate();
}
function dump_remove_from_cart(card_id)
{
    $.ajax({
        type: "POST",
        url: "dumpcart?act=remove",
        async: false,
        data: "card_id=" + card_id,
    });
    success: cartupdate();
}
function acc_remove_from_cart(card_id)
{
    $.ajax({
        type: "POST",
        url: "acccart?act=remove",
        async: false,
        data: "card_id=" + card_id,
    });
    success: cartupdate();
}
function acc_add_to_cart(card_id)
{
    $.ajax({
        type: "POST",
        url: "acccart?act=add",
        async: false,
        data: "card_id=" + card_id,
    });
    success: cartupdate();
    $("#accResult" + card_id).hide();
    $("#accResult" + card_id).html('<button type="button" class="btn btn-theme" style="padding: 4px 7px;"><i style="font-size: 2rem;" class="zwicon-checkmark"></i></button>').show();
}
function acclist_add_to_cart(list, hash) {
    var count = document.getElementById('count' + hash).value;
    $.ajax({
        type: "POST",
        url: "accounts?act=addlist",
        data: list + "&count=" + count,
        success: function (msg) {
            if (msg == 'ok') {
                $("#accResult" + hash).hide();
                $("#accResult" + hash).html('<button type="button" class="btn btn-theme">' + count + ' Added</button>').show();
                success: cartupdate();
            } else {
                $("#accResult" + hash).append('<script type="text/javascript">swalshow("error","Available only ' + msg + ' items");<\/script>').show();
                success: cartupdate();
            }
        },
        error: function (msg) {
            ajaxerror();
        }
    });
}
function cartupdate() {
    $.ajax({
        type: "GET",
        url: "ajax?act=cartupdate",
        success: function (msg) {
            msg = JSON.parse(msg);
            if (msg.total > 0) {
                $('#shoppingcart').addClass("top-nav__notify");
            } else {
                $('#shoppingcart').removeClass("top-nav__notify")
            }
            $("#cvvcartinfo").html(msg.cards + ' CVV [$ ' + msg.cardscost + ']');
            $("#dumpcartinfo").html(msg.dumps + ' Dumps [$ ' + msg.dumpscost + ']');
            $("#acccartinfo").html(msg.accounts + ' Accs [$ ' + msg.accountscost + ']');
            if ($("#cvvcarttotalcards").length) {
                $("#cvvcarttotalcards").html('Total Cards: ' + msg.cards);
            }
            if ($("#cvvcarttotalprice").length) {
                $("#cvvcarttotalprice").html('Total Price: $' + msg.cardscost);
            }
            if ($("#dumpcarttotalcards").length) {
                $("#dumpcarttotalcards").html('Total Dumps: ' + msg.dumps);
            }
            if ($("#dumpcarttotalprice").length) {
                $("#dumpcarttotalprice").html('Total Price: $' + msg.dumpscost);
            }
            if ($("#acccarttotalcards").length) {
                $("#acccarttotalcards").html('Total: ' + msg.accounts);
            }
            if ($("#acccarttotalprice").length) {
                $("#acccarttotalprice").html('Total Price: $' + msg.accountscost);
            }
        }
    });
}
function clear_all_cc() {
    if ($(".buycard").length > 0) {
        $('.buycard').each(function () {
            remove_from_cart($(this).attr('item_id'));
        }).promise().done(function () {
            showpage('cart?act=order');
        });
    }
}

function clear_all_acc() {
    if ($(".buycard").length > 0) {
        $('.buycard').each(function () {
            acc_remove_from_cart($(this).attr('item_id'));
        }).promise().done(function () {
            showpage('acccart?act=order');
        });
    }
}
function clear_all_dump() {
    if ($(".dump").length > 0) {
        $('.dump').each(function () {
            dump_remove_from_cart($(this).attr('item_id'));
        }).promise().done(function () {
            showpage('dumpcart?act=order');
        });
    }
}
function loading() {
    $('.page-loader').show();
}
function hideloading() {
    $('.page-loader').hide();
}

function ajaxerror() {
    swal.fire({
        type: 'error',
        title: "Loading error!",
        text: 'Please try again.',
        background: "#000",
        backdrop: "rgba(0,0,0,0.2)",
        buttonsStyling: !1,
        padding: "3rem 3rem 2rem",
        showConfirmButton: false,
        timer: 1500,
        customClass: {
            confirmButton: "btn btn-link",
            title: "ca-title",
            container: "ca"
        }
    })
}
function errormsg(msg) {
    swal.fire({
        type: 'error',
        title: "Error!",
        text: msg,
        background: "#000",
        backdrop: "rgba(0,0,0,0.2)",
        buttonsStyling: !1,
        padding: "3rem 3rem 2rem",
        showConfirmButton: true,
        customClass: {
            confirmButton: "btn btn-link",
            title: "ca-title",
            container: "ca"
        }
    })
}

function showpage(link)
{
    $.ajax({
        type: "GET",
        url: link,
        beforeSend: loading(),
        success: function (msg) {
            $("#main").hide();
            $("#main").html(msg).show();
            hideloading()
        },
        error: function (msg) {
            hideloading();
            ajaxerror();
        }
    });
}
function getCard(cardId)
{
    $.ajax({
        type: "GET",
        url: "./card?act=get&cardid=" + cardId,
        beforeSend: loading(),
        success: function (msg) {
            $("#cardResult" + cardId).hide();
            $("#cardResult" + cardId).closest('tr').css({'opacity': '0.2'});
            $("#cardResult" + cardId).html(msg).show();
            hideloading(), balance();
        },
        error: function (msg) {
            ajaxerror();
            hideloading();
        }
    });
}
function clearallnotifications() {
    $.ajax({
        type: "GET",
        url: "./ajax?act=notificationsclean",
        success: function () {
            return true;
        },
        error: function () {
            return false;
        }
    });
}

function getDump(cardId)
{
    $.ajax({
        type: "GET",
        url: "./dumps?act=get&cardid=" + cardId,
        beforeSend: loading(),
        success: function (msg) {
            $("#cardResult" + cardId).hide();
            $("#cardResult" + cardId).closest('tr').css({'opacity': '0.2'});
            $("#cardResult" + cardId).html(msg).show();
            hideloading(), balance();
        },
        error: function (msg) {
            ajaxerror();
            hideloading();
        }
    });
}
function bulkdumps(id)
{
    $.ajax({
        type: "GET",
        url: "./bulkdumps?id=" + id,
        beforeSend: loading(),
        success: function (msg) {
            $("#bulkdumps").hide();
            $("#bulkdumps").html(msg).show();
            hideloading();
        },
        error: function (msg) {
            ajaxerror();
            hideloading();
        }
    });
}
function bulkbtnload(id) {
    $(id).html('<i class="fa fa-spinner fa-pulse" style="font-size: 1.2rem !important;margin-top: 3px;cursor: progress;width: 22px;"></i>');
    $(id).attr('disabled', true);
}
function bulkbtnstop(id) {
    $(id).html('Buy');
    $(id).attr('disabled', false);
}
function buybulkdumps(id, count, divid)
{
    $.ajax({
        type: "GET",
        url: "./bulkdumps?act=buy&id=" + id + '&count=' + count,
        beforeSend: bulkbtnload(divid),
        success: function (msg) {
            $(divid).hide();
            $(divid).prev().html(msg).show();
        },
        error: function (msg) {
            ajaxerror();
            bulkbtnstop(divid);
        }
    });
}
function getRdp(Id)
{
    $.ajax({
        type: "GET",
        url: "./rdp?act=get&id=" + Id,
        beforeSend: buybuttonanimate("#rdpResult" + Id),
        success: function (msg) {
            $("#rdpResult" + Id).hide();
            $("#rdpResult" + Id).closest('tr').css({'opacity': '0.7'});
            $("#rdpResult" + Id).html(msg).show();
            hideloading(), balance();
        },
        error: function (msg) {
            ajaxerror();
            hideloading();
        }
    });
}

function getPack(Id) {
    $.ajax({
        type: "GET",
        url: "./packs?act=get&id=" + Id,
        beforeSend: buybuttonanimate("#packResult" + Id),
        success: function (msg) {
            $("#packResult" + Id).hide();
            $("#packResult" + Id).closest('tr').css({'opacity': '0.7'});
            $("#packResult" + Id).html(msg).show();
            hideloading(), balance();
        },
        error: function (msg) {
            ajaxerror();
            hideloading();
        }
    });
}
function getCvvPack(Id) {
    $.ajax({
        type: "GET",
        url: "./cvvpacks?act=get&id=" + Id,
        beforeSend: buybuttonanimate("#packResult" + Id),
        success: function (msg) {
            $("#packResult" + Id).hide();
            $("#packResult" + Id).closest('tr').css({'opacity': '0.7'});
            $("#packResult" + Id).html(msg).show();
            hideloading(), balance();
        },
        error: function (msg) {
            ajaxerror();
            hideloading();
        }
    });
}
function getSsh(Id)
{
    $.ajax({
        type: "GET",
        url: "./ssh?act=get&id=" + Id,
        beforeSend: buybuttonanimate("#rdpResult" + Id),
        success: function (msg) {
            $("#rdpResult" + Id).hide();
            $("#rdpResult" + Id).closest('tr').css({'opacity': '0.7'});
            $("#rdpResult" + Id).html(msg).show();
            hideloading(), balance();
        },
        error: function (msg) {
            ajaxerror();
            hideloading();
        }
    });
}
function getPP(hash, id)
{
    $.ajax({
        type: "GET",
        url: "./paypal?act=get&hash=" + hash + "&id=" + id,
        beforeSend: buybuttonanimate("#cardResult" + id),
        success: function (msg) {
            $("#cardResult" + id).hide();
            $("#cardResult" + id).closest('tr').css({'opacity': '0.7'});
            $("#cardResult" + id).html(msg).show();
            hideloading(), balance();
        },
        error: function (msg) {
            ajaxerror();
            hideloading();
        }
    });
}
function accountcat() {
    var cat = document.getElementById('catid').options[document.getElementById('catid').selectedIndex].value;
    open('./accounts?cat=' + cat + '&page=1&perpage=10');
}
function getLog(Id)
{
    $.ajax({
        type: "GET",
        url: "./logs?act=get&id=" + Id,
        beforeSend: buybuttonanimate("#logResult" + Id),
        success: function (msg) {
            $("#logResult" + Id).hide();
            $("#logResult" + Id).closest('tr').css({'opacity': '0.7'});
            $("#logResult" + Id).html(msg).show();
            hideloading(), balance();
        },
        error: function (msg) {
            ajaxerror();
            hideloading();
        }
    });
}
function getSelectValues(select) {
    var result = [];
    var options = select;
    var opt;

    for (var i = 0, iLen = options.length; i < iLen; i++) {
        opt = options[i];
        result += opt.text;
        if (i < options.length - 1) {
            result += ',';
        }
    }
    return result;
}
function balance()
{
    $.ajax({
        type: "GET",
        url: "ajax?act=balance",
        success: function (msg) {
            $("#balance").hide();
            $("#balance").html(msg).show();
        }
    });
}
function checkcc()
{
    var cclist = $('#cclist').val();
    var dup = $('#dup').is(':checked');
    var date = $('#date').is(':checked');
    var typec = $('#type').is(':checked');
    var bin_info = $('#bin_info').is(':checked');
    if (cclist != '') {
        $.ajax({
            type: "POST",
            url: "ccexp",
            data: "cclist=" + cclist + "&dup=" + dup + "&date=" + date + "&type=" + typec + "&bin_info=" + bin_info,
            beforeSend: checkingbtn("#checkbtn"),
            success: function (msg) {
                $("#checkresult").hide();
                $("#checkresult").html(msg).show();
                $("#checkbtn").attr('disabled', false);
                $("#checkbtn").html('Check Now');
                $("#cclist").val('');
                balance();
            },
            error: function (msg) {
                ajaxerror();
                $("#checkbtn").attr('disabled', false);
                $("#checkbtn").html('Check Now');
            }
        });
    } else {
        return true;
    }
}
function checkdump() {
    var cclist = $('#cclist').val();
    var dup = $('#dup').is(':checked');
    var date = $('#date').is(':checked');
    var typec = $('#type').is(':checked');
    var bin_info = $('#bin_info').is(':checked');
    if (cclist != '') {
        $.ajax({
            type: "POST",
            url: "dumpexp",
            data: "cclist=" + cclist + "&dup=" + dup + "&date=" + date + "&type=" + typec + "&bin_info=" + bin_info,
            beforeSend: checkingbtn("#checkbtn"),
            success: function (msg) {
                $("#checkresult").hide();
                $("#checkresult").html(msg).show();
                $("#checkbtn").attr('disabled', false);
                $("#checkbtn").html('Check Now');
                $("#cclist").val('');
                balance();
            },
            error: function (msg) {
                ajaxerror();
                $("#checkbtn").attr('disabled', false);
                $("#checkbtn").html('Check Now');
            }
        });
    } else {
        return true;
    }
}
function bincheck()
{
    var listcc = $('#listcc').val()
    if (listcc != '') {
        $.ajax({
            type: "POST",
            url: "checkbin",
            data: "listcc=" + listcc,
            beforeSend: loading(),
            success: function (msg) {
                $("#main").hide();
                $("#main").html(msg).show();
                hideloading();
            },
            error: function (msg) {
                ajaxerror();
                hideloading();
            }
        });
    } else {
        return true;
    }
}
function masscheck() {
    if ($(".checkcc").length > 0) {
        $('.checkcc').each(function () {
            checki($(this).attr('item_id'));
        });
    }
}

function checki(cardId)
{
    $.ajax({
        type: "GET",
        url: "./card?act=checki&cardid=" + cardId,
        beforeSend: function () {
            $("#cardResult" + cardId).html('<button type="button" class="btn btn-theme btn-sm"><i class="fa fa-spinner fa-pulse" style="font-size: 0.8rem !important;margin-right: 3px;"></i>Checking...</button>').show()
        },
        success: function (msg) {
            $("#cardResult" + cardId).hide();
            $("#cardResult" + cardId).html(msg).show();
        },
        error: function (msg) {
            ajaxerror();
        }
    });
}

function massdumpcheck() {
    if ($(".checkdump").length > 0) {
        $('.checkdump').each(function () {
            dumpchecki($(this).attr('item_id'));
        });
    }
}
function masspackcheck() {
    if ($(".checkdump").length > 0) {
        $('.checkdump').each(function () {
            packchecki($(this).attr('item_id'));
        });
    }
}
function masscvvpackcheck() {
    if ($(".checkcvv").length > 0) {
        $('.checkcvv').each(function () {
            cvvpackchecki($(this).attr('item_id'));
        });
    }
}

function loadresult(link)
{
    $.ajax({
        type: "GET",
        url: link,
        success: function (msg) {
            $("#result").hide();
            $("#result").html(msg).show();
        },
        error: function (msg) {
            ajaxerror();
        }
    });
}

function dumpchecki(cardId)
{
    $.ajax({
        type: "GET",
        url: "./dumps?act=checki&cardid=" + cardId,
        beforeSend: function () {
            $("#cardResult" + cardId).html('<button type="button" class="btn btn-theme btn-sm"><i class="fa fa-spinner fa-pulse" style="font-size: 0.8rem !important;margin-right: 3px;"></i>Checking...</button>').show()
        },
        success: function (msg) {
            $("#cardResult" + cardId).hide();
            $("#cardResult" + cardId).html(msg).show();
        },
        error: function (msg) {
            ajaxerror();
        }
    });
}

function packchecki(cardId)
{
    $.ajax({
        type: "GET",
        url: "./packs?act=checki&cardid=" + cardId,
        beforeSend: function () {
            $("#cardResult" + cardId).html('<button type="button" class="btn btn-theme btn-sm"><i class="fa fa-spinner fa-pulse" style="font-size: 0.8rem !important;margin-right: 3px;"></i>Checking...</button>').show()
        },
        success: function (msg) {
            $("#cardResult" + cardId).hide();
            $("#cardResult" + cardId).html(msg).show();
        },
        error: function (msg) {
            ajaxerror();
        }
    });
}

function cvvpackchecki(cardId)
{
    $.ajax({
        type: "GET",
        url: "./cvvpacks?act=checki&cardid=" + cardId,
        beforeSend: function () {
            $("#cardResult" + cardId).html('<button type="button" class="btn btn-theme btn-sm"><i class="fa fa-spinner fa-pulse" style="font-size: 0.8rem !important;margin-right: 3px;"></i>Checking...</button>').show()
        },
        success: function (msg) {
            $("#cardResult" + cardId).hide();
            $("#cardResult" + cardId).html(msg).show();
        },
        error: function (msg) {
            ajaxerror();
        }
    });
}

function refunddump(id) {
    $.ajax({
        type: "GET",
        url: 'dumps?act=refund&id=' + id,
        beforeSend: loading(),
        success: function (msg) {
            $("#refund").hide();
            $("#refund").html(msg).show();
            hideloading();
        },
        error: function (msg) {
            ajaxerror();
            hideloading();
        }
    });
}
function refundrdp(id) {
    $.ajax({
        type: "GET",
        url: 'rdp?act=refund&id=' + id,
        beforeSend: loading(),
        success: function (msg) {
            $("#refund").hide();
            $("#refund").html(msg).show();
            hideloading();
        },
        error: function (msg) {
            ajaxerror();
            hideloading();
        }
    });
}
function refundssh(id) {
    $.ajax({
        type: "GET",
        url: 'ssh?act=refund&id=' + id,
        beforeSend: loading(),
        success: function (msg) {
            $("#refund").hide();
            $("#refund").html(msg).show();
            hideloading();
        },
        error: function (msg) {
            ajaxerror();
            hideloading();
        }
    });
}
function refundlog(id) {
    $.ajax({
        type: "GET",
        url: 'logs?act=refund&id=' + id,
        beforeSend: loading(),
        success: function (msg) {
            $("#refund").hide();
            $("#refund").html(msg).show();
            hideloading();
        },
        error: function (msg) {
            ajaxerror();
            hideloading();
        }
    });
}
function refundpp(id) {
    $.ajax({
        type: "GET",
        url: 'paypal?act=refund&id=' + id,
        beforeSend: loading(),
        success: function (msg) {
            $("#refund").hide();
            $("#refund").html(msg).show();
            hideloading();
        },
        error: function (msg) {
            ajaxerror();
            hideloading();
        }
    });
}
function nonshowload(link)
{
    $.ajax({
        type: "GET",
        url: link,
        success: function (msg) {
            return true;
        },
        error: function (msg) {
            return false;
        }
    });
}
function refundacc(id) {
    $.ajax({
        type: "GET",
        url: 'accounts?act=refund&id=' + id,
        beforeSend: loading(),
        success: function (msg) {
            $("#refund").hide();
            $("#refund").html(msg).show();
            hideloading();
        },
        error: function (msg) {
            ajaxerror();
            hideloading();
        }
    });
}
function ipaid(type) {
    $.ajax({
        type: "GET",
        url: 'buy?act=paid&type=' + type,
        success: function (msg) {
            if (msg == 'ok') {
                $('#paid' + type).html('Please wait <i class="fa fa-spinner fa-pulse" style="font-size: 1rem !important;margin-top: 3px;"></i>');
                $('#paid' + type).css({'cursor': 'progress'});
                $('#paid' + type).prop("onclick", null);
            } else {
                errormsg(msg);
            }
        },
        error: function (msg) {
            ajaxerror();
        }
    });
}
function feedback(id, type) {
    if (type == 'message') {
        $("#feedback" + id).popover({
            html: true,
            placement: 'top',
            content: function () {
                return $('#popover-content' + id).clone();
            }
        });
        $("#feedback" + id).on("click", function () {
            var temp = $("#feedback" + id).rateYo("option", "rating");
            $(".popover-body #clonerating" + id).rateYo({
                rating: temp,
                starWidth: "20px",
                normalFill: "rgba(255,255,255,0.3)",
                ratedFill: "#ffc107",
                fullStar: true
            })
            $(".popover-body #clonerating" + id).on("rateyo.set", function (e, data) {
                var rating = data.rating;
                $.each($('#rating' + id + '[name="rating"]'), function () {
                    $(this).val(rating);
                });
            });
        });
        $("#feedback" + id).on("rateyo.set", function (e, data) {
            var rating = data.rating;
            $(".popover-body #clonerating" + id).rateYo("option", "rating", rating);
            $.each($('#rating' + id + '[name="rating"]'), function () {
                $(this).val(rating);
            });
        });

    }
    if (type == 'rating') {
        $("#feedback" + id).popover({
            html: true,
            placement: 'right',
            content: function () {
                return $('#popover-content' + id).clone();
            }
        });
        $("#feedback" + id).on("rateyo.set", function (e, data) {
            var rating = data.rating;
            $.each($('#rating' + id + '[name="rating"]'), function () {
                $(this).val(rating);
            });
        });
    }
    $('#feedback' + id).rateYo({
        rating: 0,
        starWidth: "20px",
        normalFill: "rgba(255,255,255,0.3)",
        ratedFill: "#ffc107",
        fullStar: true
    })
}
function havefeedback(id, rating) {
    $('#feedback' + id).rateYo({
        rating: rating,
        starWidth: "20px",
        normalFill: "rgba(255,255,255,0.3)",
        ratedFill: "#ffc107",
        readOnly: true
    })
    $('#feedback' + id).css({'opacity': '0.35'});
}