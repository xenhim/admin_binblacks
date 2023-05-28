$(document).ready(function() {
    $('#users_table').DataTable( {
      responsive: true
    });

    $(document).on('click', 'button[data-role=edit]',function(){

      var id = $(this).data('id');

      var pfmId = $('#'+id).children('td[data-target=pfmId]').text();
      var username = $('#'+id).children('td[data-target=username]').text();
      var password = $('#'+id).children('td[data-target=password]').text();
      var email = $('#'+id).children('td[data-target=email]').text();
      var balance = $('#'+id).children('td[data-target=balance]').text();
      var moneySpent = $('#'+id).children('td[data-target=moneySpent]').text();
      var accountType = $('#'+id).children('td[data-target=accountType]').text();
      var accountStatus = $('#'+id).children('td[data-target=accountStatus]').text();
      var totalPurchase = $('#'+id).children('td[data-target=totalPurchase]').text();
      var recentLogon = $('#'+id).children('td[data-target=recentLogon]').text();
      var recentIpLogon = $('#'+id).children('td[data-target=recentIpLogon]').text();
      var userIp = $('#'+id).children('td[data-target=userIp]').text();
      var creationTime = $('#'+id).children('td[data-target=creationTime]').text();

      $('#pfmId').val(pfmId);
      $('#username').val(username);
      $('#password').val(password);
      $('#email').val(email);
      $('#balance').val(balance);
      $('#moneySpent').val(moneySpent);
      $('#accountType').val(accountType);
      $('#accountStatus').val(accountStatus);
      $('#totalPurchase').val(totalPurchase);
      $('#recentLogon').val(recentLogon);
      $('#recentIpLogon').val(recentIpLogon);
      $('#userIp').val(userIp);
      $('#creationTime').val(creationTime);
      $('#editId').val(id);
      $('#editModal').modal('toggle');
    });

    $('#editBtn').click(function(){

      var username = $('#username').val();
      var password = $('#password').val();
      var email = $('#email').val();
      var balance = $('#balance').val();
      var moneySpent = $('#moneySpent').val();
      var totalPurchase = $('#totalPurchase').val();
      var editId = $('#editId').val();

      $.ajax({
        url    : 'index.php?page=cp_users',
        method : 'POST',
        data   : {
                'username': username,
                'password': password,
                'email': email,
                'balance': balance,
                'moneySpent': moneySpent,
                'totalPurchase': totalPurchase,
                'editId': editId,
                'editAccount': 1
        },
        success : function(response) {
          if(response.match(/edit success/i)){
            $('#editModal').modal('hide');
            swal.fire("Success!", "User changes has been saved!", "success");
            setTimeout(function() {
                location.reload();
            }, 2000);
          } else{
            $('#purchaseModal').modal('hide');
            swal.fire("Failed!", "Failed to update. Refreshing browser!", "error");
            setTimeout(function() {
                location.reload();
            }, 2000);
          }
        }
      });

    });

    $(document).on('click', 'button[data-role=delete]',function(e){
      var id = $(this).data('id');
      $('#deleteId').val(id);
      var deleteId = $('#deleteId').val();
      swal.fire({
          title: 'Are you sure?',
          text: "You won't be able to revert this!",
          type: 'warning',
          showCancelButton: true,
          confirmButtonText: 'Yes, delete user!'
      }).then(function(result) {
          if (result.value) {
            $.ajax({
              url    : 'index.php?page=cp_users',
              method : 'POST',
              data   : {
                      'deleteId': deleteId,
                      'deleteUser': 1
              },
              success : function(response) {
                if(response.match(/delete success/i)){
                  swal.fire("Success!", "User records has been removed!", "success");
                  setTimeout(function() {
                      location.reload();
                  }, 2000);
                } else{
                  swal.fire("Failed!", "Failed to delete. Refreshing browser!", "error");
                  setTimeout(function() {
                      location.reload();
                  }, 2000);
                }
              }
            });
          }
      });
    });

    $(document).on('click', 'button[data-role=ban]',function(e){
      var id = $(this).data('id');
      $('#banId').val(id);
      var banId = $('#banId').val();
      swal.fire({
          title: 'Are you sure?',
          text: "You won't be able to revert this!",
          type: 'warning',
          showCancelButton: true,
          confirmButtonText: 'Yes, ban user!'
      }).then(function(result) {
          if (result.value) {
            $.ajax({
              url    : 'index.php?page=cp_users',
              method : 'POST',
              data   : {
                      'banId': banId,
                      'banUser': 1
              },
              success : function(response) {
                if(response.match(/ban success/i)){
                  swal.fire("Success!", "User account has been banned!", "success");
                  setTimeout(function() {
                      location.reload();
                  }, 2000);
                } else{
                  swal.fire("Failed!", "Failed to ban. Refreshing browser!", "error");
                  setTimeout(function() {
                      location.reload();
                  }, 2000);
                }
              }
            });
          }
      });
    });

    $(document).on('click', 'button[data-role=unban]',function(e){
      var id = $(this).data('id');
      $('#unbanId').val(id);
      var unbanId = $('#unbanId').val();
      swal.fire({
          title: 'Are you sure?',
          text: "You won't be able to revert this!",
          type: 'warning',
          showCancelButton: true,
          confirmButtonText: 'Yes, unban user!'
      }).then(function(result) {
          if (result.value) {
            $.ajax({
              url    : 'index.php?page=cp_users',
              method : 'POST',
              data   : {
                      'unbanId': unbanId,
                      'unbanUser': 1
              },
              success : function(response) {
                if(response.match(/unban success/i)){
                  swal.fire("Success!", "User account has been unbanned!", "success");
                  setTimeout(function() {
                      location.reload();
                  }, 2000);
                } else{
                  swal.fire("Failed!", "Failed to unban. Refreshing browser!", "error");
                  setTimeout(function() {
                      location.reload();
                  }, 2000);
                }
              }
            });
          }
      });
    });

    $(document).on('click', 'button[data-role=recover]',function(e){
      var id = $(this).data('id');
      $('#recoverId').val(id);
      var recoverId = $('#recoverId').val();
      swal.fire({
          title: 'Are you sure?',
          text: "You won't be able to revert this!",
          type: 'warning',
          showCancelButton: true,
          confirmButtonText: 'Yes, recover user!'
      }).then(function(result) {
          if (result.value) {
            $.ajax({
              url    : 'index.php?page=cp_users',
              method : 'POST',
              data   : {
                      'recoverId': recoverId,
                      'recoverUser': 1
              },
              success : function(response) {
                if(response.match(/recover success/i)){
                  swal.fire("Success!", "User account has been recovered!", "success");
                  setTimeout(function() {
                      location.reload();
                  }, 2000);
                } else{
                  swal.fire("Failed!", "Failed to recover. Refreshing browser!", "error");
                  setTimeout(function() {
                      location.reload();
                  }, 2000);
                }
              }
            });
          }
      });
    });

    $(document).on('click', 'button[data-role=upgrade]',function(e){
      var id = $(this).data('id');
      $('#upgradeId').val(id);
      var upgradeId = $('#upgradeId').val();
      swal.fire({
          title: 'Are you sure?',
          text: "You won't be able to revert this!",
          type: 'warning',
          showCancelButton: true,
          confirmButtonText: 'Yes, upgrade user!'
      }).then(function(result) {
          if (result.value) {
            $.ajax({
              url    : 'index.php?page=cp_users',
              method : 'POST',
              data   : {
                      'upgradeId': upgradeId,
                      'upgradeUser': 1
              },
              success : function(response) {
                if(response.match(/upgrade success/i)){
                  swal.fire("Success!", "User has been upgraded to vendor!", "success");
                  setTimeout(function() {
                      location.reload();
                  }, 2000);
                } else{
                  swal.fire("Failed!", "Failed to upgrade. Refreshing browser!", "error");
                  setTimeout(function() {
                      location.reload();
                  }, 2000);
                }
              }
            });
          }
      });
    });

    $(document).on('click', 'button[data-role=degrade]',function(e){
      var id = $(this).data('id');
      $('#degradeId').val(id);
      var degradeId = $('#degradeId').val();
      swal.fire({
          title: 'Are you sure?',
          text: "You won't be able to revert this!",
          type: 'warning',
          showCancelButton: true,
          confirmButtonText: 'Yes, degrade user!'
      }).then(function(result) {
          if (result.value) {
            $.ajax({
              url    : 'index.php?page=cp_users',
              method : 'POST',
              data   : {
                      'degradeId': degradeId,
                      'degradeUser': 1
              },
              success : function(response) {
                if(response.match(/degrade success/i)){
                  swal.fire("Success!", "User has been degraded to member!", "success");
                  setTimeout(function() {
                      location.reload();
                  }, 2000);
                } else{
                  swal.fire("Failed!", "Failed to degrade. Refreshing browser!", "error");
                  setTimeout(function() {
                      location.reload();
                  }, 2000);
                }
              }
            });
          }
      });
    });
});
