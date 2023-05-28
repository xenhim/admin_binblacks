$(document).ready(function() {
    $('#tutorials_table').DataTable( {
      responsive: true
    });

    $('#showForm').click(function(){
      $('#liShow').fadeOut();
      $('#liHide').fadeIn();
      $('#liAdd').fadeIn();
      $('#liGenerate').fadeIn();
      $('.group').fadeIn(500);
    });

    $('.formGroup').multifield({
        section: '.group',
        btnAdd:'#add',
        btnRemove:'.btnRemove',
    });

    $('#hideForm').click(function(){
      $('#liShow').fadeIn();
      $('#liHide').fadeOut();
      $('#liAdd').fadeOut();
      $('#liGenerate').fadeOut();
      $('.group').fadeOut(500);
    });

    $(document).on('click', 'button[data-role=edit]',function(){
      var id = $(this).data('id');
      var etStatus = $('#'+id).children('td[data-target=etStatus]').text();
      var etPrice = $('#'+id).children('td[data-target=etPrice]').text();
      var etInfo = $('#'+id).children('td[data-target=etInfo]').text();
      var etLink = $('#'+id).children('td[data-target=etLink]').text();

      $('#etId').val(id);
      $('#etStatus').val(etStatus);
      $('#etPrice').val(etPrice);
      $('#etInfo').val(etInfo);
      $('#etLink').val(etLink);
      $('#etPreview').val(etPreview);
      $('#editModal').modal('toggle');
    });

    $('#editBtn').click(function(){

      var editId = $('#etId').val();
      var etPrice = $('#etPrice').val();
      var etInfo = $('#etInfo').val();
      var etLink = $('#etLink').val();

      $.ajax({
        url    : 'index.php?page=cp_tutorials',
        method : 'POST',
        data   : {
                'etPrice': etPrice,
                'etInfo': etInfo,
                'etLink': etLink,
                'editId': editId,
                'editTutorial': 1
        },
        success : function(response) {
          if(response.match(/edit success/i)){
            $('#editModal').modal('hide');
            swal.fire("Success!", "Tutorials changes has been saved!", "success");
            setTimeout(function() {
                location.reload();
            }, 1700);
          } else{
            $('#editModal').modal('hide');
            swal.fire("Failed!", "Failed to update. Refreshing browser!", "error");
            setTimeout(function() {
                location.reload();
            }, 1700);
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
          confirmButtonText: 'Yes, delete tutorial!'
      }).then(function(result) {
          if (result.value) {
            $.ajax({
              url    : 'index.php?page=cp_tutorials',
              method : 'POST',
              data   : {
                      'deleteId': deleteId,
                      'deleteTutorial': 1
              },
              success : function(response) {
                if(response.match(/delete success/i)){
                  swal.fire("Success!", "Tutorial has been removed!", "success");
                  setTimeout(function() {
                      location.reload();
                  }, 1700);
                } else{
                  swal.fire("Failed!", "Failed to delete. Refreshing browser!", "error");
                  setTimeout(function() {
                      location.reload();
                  }, 1700);
                }
              }
            });
          }
      });
    });

    $(document).on('click', '#generate',function(e){
      var toolsData = $('.formGroup').serialize();
      $.ajax({
        url    : 'index.php?page=cp_tutorials',
        method : 'POST',
        data   : toolsData,
        success : function(response) {
          if(response.match(/generate success/i)){
            swal.fire("Success!", "Tutorial has been generated!", "success");
            setTimeout(function() {
                location.reload();
            }, 1700);
          } else{
            swal.fire("Failed!", "Failed to generate. Refreshing browser!", "error");
            setTimeout(function() {
                location.reload();
            }, 1700);
          }
        }
      });
    });
});
