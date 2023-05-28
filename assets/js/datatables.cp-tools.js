$(document).ready(function() {
    $('#tools_table').DataTable( {
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
      var etPreview = $('#'+id).children('td[data-target=etPreview]').text();

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
      var etPreview = $('#etPreview').val();

      $.ajax({
        url    : 'index.php?page=cp_tools',
        method : 'POST',
        data   : {
                'etPrice': etPrice,
                'etInfo': etInfo,
                'etLink': etLink,
                'etPreview': etPreview,
                'editId': editId,
                'editTool': 1
        },
        success : function(response) {
          if(response.match(/edit success/i)){
            $('#editModal').modal('hide');
            swal.fire("Success!", "Tools changes has been saved!", "success");
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
          confirmButtonText: 'Yes, delete tool!'
      }).then(function(result) {
          if (result.value) {
            $.ajax({
              url    : 'index.php?page=cp_tools',
              method : 'POST',
              data   : {
                      'deleteId': deleteId,
                      'deleteTool': 1
              },
              success : function(response) {
                if(response.match(/delete success/i)){
                  swal.fire("Success!", "Tool has been removed!", "success");
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
        url    : 'index.php?page=cp_tools',
        method : 'POST',
        data   : toolsData,
        success : function(response) {
          if(response.match(/generate success/i)){
            swal.fire("Success!", "Tool been generated!", "success");
            setTimeout(function() {
                location.reload();
            }, 2000);
          } else{
            swal.fire("Failed!", "Failed to generate. Refreshing browser!", "error");
            setTimeout(function() {
                location.reload();
            }, 2000);
          }
        }
      });
    });
});
