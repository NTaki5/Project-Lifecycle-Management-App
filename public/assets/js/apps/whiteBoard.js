$("[name = delete-board]").each(function(index){
    $(this).click(function () {
        $cardToDelete = $(this).closest('.entire-card');
        Swal.fire({
          title: "Are you sure?",
          text: "You won't be able to revert this!",
          type: "warning",
          showCancelButton: true,
          confirmButtonColor: "#3085d6",
          cancelButtonColor: "#d33",
          confirmButtonText: "Yes, delete it!",
        }).then((result) => {
          if (result.value) {
              let boardID = $(this).data("boardid");
              $.ajax({
                url: "whiteBoards",
                type: "POST",
                data: {
                  "delete-board": true,
                  "boardID": boardID
                },
                success: function (response) {
                  console.log(response);
                  if(!response.length)
                  {  
                    $cardToDelete.remove();
                    Swal.fire("Deleted!", "Your board has been deleted.", "success");
                  }else
                    Swal.fire("Error!", "Your board has not been deleted.", "fail");
                  
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    Swal.fire("Error!", "Your board has not been deleted.", "fail");
                },
              });
          }
        });
      });
});



