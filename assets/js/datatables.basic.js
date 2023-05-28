$(document).ready(function() {
    $('#kt_table_1').DataTable( {
      responsive: true
    });
    $('#kt_table_2').DataTable( {
      responsive: true
    });
    $('#kt_table_3').DataTable( {
      responsive: true
    });
    $('#kt_table_4').DataTable( {
      responsive: true
    });
    $('#kt_table_5').DataTable( {
      responsive: true
    });


    $(document).on('click', 'button[data-role=bankView]',function(){

      var id = $(this).data('id');
      var aboutFrm = $('#'+id).children('td[data-target=aboutFrm]').text();
      var priceFrm = $('#'+id).children('td[data-target=priceFrm]').text();
      var accountTypeFrm = $('#'+id).children('td[data-target=accountTypeFrm]').text();
      var firstNameFrm = $('#'+id).children('td[data-target=firstNameFrm]').text();
      var dobFrm = $('#'+id).children('td[data-target=dobFrm]').text();
      var screenshotFrm = $('#'+id).children('td[data-target=screenshotFrm]').text();
      var telepinFrm = $('#'+id).children('td[data-target=telepinFrm]').text();
      var noteLinkFrm = $('#'+id).children('td[data-target=noteLinkFrm]').text();

      $('#aboutFrm').val(aboutFrm);
      $('#priceFrm').val(priceFrm);
      $('#accountTypeFrm').val(accountTypeFrm);
      $('#firstNameFrm').val(firstNameFrm);
      $('#dobFrm').val(dobFrm);
      $('#screenshotFrm').val(screenshotFrm);
      $('#telepinFrm').val(telepinFrm);
      $('#noteLinkFrm').val(noteLinkFrm);
      $('#bankModal').modal('toggle');
    });

    $(document).on('click', 'button[data-role=accountView]',function(){

      var id = $(this).data('id');
      var webPriceFrm = $('#'+id).children('td[data-target=webPriceFrm]').text();
      var webUsernameFrm = $('#'+id).children('td[data-target=webUsernameFrm]').text();
      var webPasswordFrm = $('#'+id).children('td[data-target=webPasswordFrm]').text();
      var webInfoFrm = $('#'+id).children('td[data-target=webInfoFrm]').text();
      var webTypeFrm = $('#'+id).children('td[data-target=webTypeFrm]').text();

      $('#webTypeFrm').val(webTypeFrm);
      $('#webInfoFrm').val(webInfoFrm);
      $('#webPasswordFrm').val(webPasswordFrm);
      $('#webUsernameFrm').val(webUsernameFrm);
      $('#webPriceFrm').val(webPriceFrm);
      $('#accountModal').modal('toggle');
    });

    $(document).on('click', 'button[data-role=fullzView]',function(){

      var id = $(this).data('id');
      var flPrice = $('#'+id).children('td[data-target=flPrice]').text();
      var flCategory = $('#'+id).children('td[data-target=flCategory]').text();
      var flFirstName = $('#'+id).children('td[data-target=flFirstName]').text();
      var flLastName = $('#'+id).children('td[data-target=flLastName]').text();
      var flMmn = $('#'+id).children('td[data-target=flMmn]').text();
      var flDob = $('#'+id).children('td[data-target=flDob]').text();
      var flTelephone = $('#'+id).children('td[data-target=flTelephone]').text();
      var flAddress = $('#'+id).children('td[data-target=flAddress]').text();
      var flPostcode = $('#'+id).children('td[data-target=flPostcode]').text();
      var flCardHolder = $('#'+id).children('td[data-target=flCardHolder]').text();
      var flCardNumber = $('#'+id).children('td[data-target=flCardNumber]').text();
      var flCardBin = $('#'+id).children('td[data-target=flCardBin]').text();
      var flCardExp = $('#'+id).children('td[data-target=flCardExp]').text();
      var flCcv = $('#'+id).children('td[data-target=flCcv]').text();
      var flAccountNo = $('#'+id).children('td[data-target=flAccountNo]').text();
      var flUsername = $('#'+id).children('td[data-target=flUsername]').text();
      var flPassword = $('#'+id).children('td[data-target=flPassword]').text();
      var flTypeAcc = $('#'+id).children('td[data-target=flTypeAcc]').text();
      var flUserAgent = $('#'+id).children('td[data-target=flUserAgent]').text();
      var flEmail = $('#'+id).children('td[data-target=flEmail]').text();
      var flSortcode = $('#'+id).children('td[data-target=flSortcode]').text();
      var flVictimIp = $('#'+id).children('td[data-target=flVictimIp]').text();

      $('#flPrice').val(flPrice);
      $('#flCategory').val(flCategory);
      $('#flFirstName').val(flFirstName);
      $('#flLastName').val(flLastName);
      $('#flMmn').val(flMmn);
      $('#flDob').val(flDob);
      $('#flTelephone').val(flTelephone);
      $('#flAddress').val(flAddress);
      $('#flPostcode').val(flPostcode);
      $('#flCardHolder').val(flCardHolder);
      $('#flCardNumber').val(flCardNumber);
      $('#flCardBin').val(flCardBin);
      $('#flCardExp').val(flCardExp);
      $('#flCcv').val(flCcv);
      $('#flAccountNo').val(flAccountNo);
      $('#flUsername').val(flUsername);
      $('#flPassword').val(flPassword);
      $('#flTypeAcc').val(flTypeAcc);
      $('#flUserAgent').val(flUserAgent);
      $('#flEmail').val(flEmail);
      $('#flSortcode').val(flSortcode);
      $('#flVictimIp').val(flVictimIp);
      $('#fullzModal').modal('toggle');
    });

    $(document).on('click', 'button[data-role=toolView]',function(){
      var id = $(this).data('id');
      var toolPrice = $('#'+id).children('td[data-target=toolPrice]').text();
      var toolInfo = $('#'+id).children('td[data-target=toolInfo]').text();
      var toolPreview = $('#'+id).children('td[data-target=toolPreview]').text();
      var toolLink = $('#'+id).children('td[data-target=toolLink]').text();

      $('#toolPrice').val(toolPrice);
      $('#toolInfo').val(toolInfo);
      $('#toolPreview').val(toolPreview);
      $('#toolLink').val(toolLink);
      $('#toolModal').modal('toggle');

    });

    $(document).on('click', 'button[data-role=tutorialView]',function(){
      var id = $(this).data('id');
      var tutorialPrice = $('#'+id).children('td[data-target=tutorialPrice]').text();
      var tutorialInfo = $('#'+id).children('td[data-target=tutorialInfo]').text();
      var tutorialLink = $('#'+id).children('td[data-target=tutorialLink]').text();

      $('#tutorialPrice').val(tutorialPrice);
      $('#tutorialInfo').val(tutorialInfo);
      $('#tutorialLink').val(tutorialLink);
      $('#tutorialModal').modal('toggle');

    });


});
