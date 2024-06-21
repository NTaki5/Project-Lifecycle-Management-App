$(function () {
  var $_slug = document.querySelector("#project-slug");
  /////////////////////////////////
  // INVITE CLIENT TO THE PROJECT
  /////////////////////////////////
  $("#invite-client").off('click').on("click", function (event) {
    $("#inviteClient #btn-invite-client").show();
    $("#inviteClient").modal("show");
  });

  function inviteClient() {
    $("#btn-invite-client").click(function () {
      var getParent = $(this).parents(".modal-content");

      var $_email = getParent.find("#c-email");

      var $_getValidationField = document.getElementsByClassName(
        "invite-validation-text"
      )[0];
      var reg = /^.+@[^\.].*\.[a-z]{2,}$/;

      var $_slugValue = $_slug.getAttribute("value");
      var $_emailValue = $_email.val();

      if ($_emailValue == "") {
        $_getValidationField.innerHTML = "Email Id must be filled out";
        $_getValidationField.style.display = "block";
      } else if (reg.test($_emailValue) == false) {
        $_getValidationField.innerHTML = "Invalid Email";
        $_getValidationField.style.display = "block";
      } else {
        $_getValidationField.style.display = "none";
      }

      if ($_emailValue == "" || reg.test($_emailValue) == false) {
        return false;
      }

      $.ajax({
        url: "projects/single/" + $_slugValue,
        type: "POST",
        data: {
          "send-invitation": true,
          email: $_emailValue,
        },
        success: function (response) {
          if (response !== undefined) {
            document.location.reload();
          }
        },
        error: function (jqXHR, textStatus, errorThrown) {
          if (jqXHR.status === 400) {
            var response = JSON.parse(jqXHR.responseText);
            if (response.code === 999 && response.value !== undefined) {
              document.location.reload();
            }
          }
        },
      });

      hideElement(".toast.show");
      $("#inviteClient").modal("hide");
      $_email.val("");
    });
  }

  $("#inviteClient").on("hidden.bs.modal", function (e) {
    var $_email = document.getElementById("c-email");
    var $_getValidationField =
      document.getElementsByClassName("validation-text");

    var $_setEmailValueEmpty = ($_email.value = "");

    for (var i = 0; i < $_getValidationField.length; i++) {
      e.preventDefault();
      $_getValidationField[i].style.display = "none";
    }
  });
  inviteClient();

  /////////////////////////////////
  // ADD TEAM MEMBER TO THE PROJECT
  /////////////////////////////////

  $("#btn-add-team").off('click').on("click", function (event) {
    $("#addTeamModal #btn-add").show();
    $("#addTeamModal #btn-edit").hide();
    $("#addTeamModal").modal("show");
  });

  function addTeam() {
    $("#btn-add").click(function () {
      var getParent = $(this).parents(".modal-content");

      var $_teamMembers = getParent.find("#team_members");

      var $_slugValue = $_slug.getAttribute("value");
      var $_teamMembersValue = $_teamMembers.val();
      $.ajax({
        url: "projects/single/" + $_slugValue,
        type: "POST",
        data: {
          "update-members": true,
          teamMembersArr: $_teamMembersValue,
        },
        success: function (response) {
          if (response !== undefined) {
            console.log(response);
            document.location.reload();
          }
        },
        error: function (jqXHR, textStatus, errorThrown) {
          if (jqXHR.status === 400) {
            // Parse the JSON response
            var response = JSON.parse(jqXHR.responseText);
            if (response.code === 999 && response.value !== undefined) {
              console.log(response);
              document.location.reload();
            }
          }
        },
      });

      hideElement(".toast.show");
      $("#addTeamModal").modal("hide");
    });
  }

  addTeam();

  document.addEventListener("DOMContentLoaded", function () {
    var tooltipTriggerList = [].slice.call(
      document.querySelectorAll('[data-bs-toggle="tooltip"]')
    );
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
      return new bootstrap.Tooltip(tooltipTriggerEl);
    });
  });

  $(document).ready(function () {
    $(".comment-reply").off('click').on("click", function () {
      console.log(this.getAttribute("data-commentID"));
      let commentID = this.getAttribute("data-commentID");
      let feedID = this.getAttribute("data-feedID");
      var formHtml =
        '<form method="POST" class="d-flex align-items-center gap-6 flex-wrap p-3 flex-lg-nowrap mt-3">' +
        '<input value="' +
        feedID +
        '" name="fk_feed_id" type="text" hidden>' +
        '<input value="' +
        commentID +
        '" name="fk_parent_id" type="text" hidden>' +
        '<input type="text" class="form-control py-8" id="commentText" name="commentText" aria-describedby="textHelp" placeholder="Comment">' +
        '<a class="btn btn-primary" id="add-comment">Comment</a>' +
        "</form>";

      var parentElement = this.closest(".replyBox");
      if (!parentElement.querySelector("#add-comment")){
        parentElement.insertAdjacentHTML("beforeend", formHtml);
      }else{
        parentElement.querySelector("form").remove();
      }

      $("#add-comment").off('click').on("click", function () {
        var getParent = $(this).parents("form");
        var $_slugValue = $_slug.getAttribute("value");

        var $_feedID = getParent.find("[name='fk_feed_id']");
        var $_parentID = getParent.find("[name='fk_parent_id']");
        var $_commentText = getParent.find("[name='commentText']");

        var $_feedIDValue = $_feedID.val();
        var $_parentIDValue = $_parentID.val();
        var $_commentTextValue = $_commentText.val();

        $.ajax({
          url: "projects/single/" + $_slugValue,
          type: "POST",
          data: {
            "add-comment": true,
            returnForAjaxRequest: true,
            fk_feed_id: $_feedIDValue,
            fk_parent_id: $_parentIDValue,
            commentText: $_commentTextValue,
          },
          success: function (response) {
            if (response !== undefined) {
              console.log(response);
              response = JSON.parse(response);
              var appendNewComment = getParent.closest(".replyBox");
              getParent.remove();

              let newCommentHtml =
                '<div class="p-4 rounded-2 text-bg-light mb-3 ms-7">' +
                '<div class="d-flex align-items-center gap-6 flex-wrap">' +
                '<img src="' +
                response["userImage"] +
                '" alt="matdash-img" class="rounded-circle" width="33" height="33">' +
                '<h6 class="mb-0">' +
                response["userName"] +
                "</h6>" +
                '<span class="fs-2">' +
                ' <span class="p-1 text-bg-muted rounded-circle d-inline-block"></span> just now </span>' +
                "</div>" +
                '<p class="my-3">' +
                $_commentTextValue +
                "</p>" +
                '<div class="d-flex align-items-center">' +
                '<div class="d-flex align-items-center gap-2">' +
                '<a class="round-32 rounded-circle btn btn-primary p-0 hstack justify-content-center" href="javascript:void(0)" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Like">' +
                '<i class="ti ti-thumb-up"></i>' +
                "</a>" +
                '<span class="text-dark fw-semibold"> 0 </span>' +
                "</div>" +
                "</div>" +
                "</div>";

              appendNewComment.after(newCommentHtml);
              // document.location.reload();
            }
          },
          error: function (jqXHR, textStatus, errorThrown) {
            if (jqXHR.status === 400) {
              // Parse the JSON response
              var response = JSON.parse(jqXHR.responseText);
              if (response.code === 999 && response.value !== undefined) {
                console.log(response);
                document.location.reload();
              }
            }
          },
        });
      });
    });

    $(".comment-like").off("click").on("click", function () {
      $_parent = $(this);
      var $_slugValue = $_slug.getAttribute("value");

      var likesNumber = this.nextElementSibling;
      var $_commentID = $_parent.attr("data-commentID");
      // console.log($_parent);

      $.ajax({
        url: "projects/single/" + $_slugValue,
        type: "POST",
        data: {
          "update-comment-likes": true,
          returnForAjaxRequest: true,
          // likes: Number(likesNumber.innerText),
          fk_comment_id: $_commentID,
        },
        success: function (response) {
          if (response !== undefined) {
            // console.log($_parent);
            response = JSON.parse(response);
            likesNumber.innerText = response["likesNumber"];
            $_parent.removeClass("opacity-50");
            if (response["increaseLikes"]) {
              $_parent.addClass("opacity-50");
            }
          }
        },
        error: function (jqXHR, textStatus, errorThrown) {
          if (jqXHR.status === 400) {
            // Parse the JSON response
            var response = JSON.parse(jqXHR.responseText);
            if (response.code === 999 && response.value !== undefined) {
              console.log(response);
              document.location.reload();
            }
          }
        },
      });
    });

    $(".feed-like").off("click").on("click", function () {
      $_parent = $(this);
      var $_slugValue = $_slug.getAttribute("value");

      var likesNumber = this.nextElementSibling;
      var $_feedID = $_parent.attr("data-feedID");
      console.log("here");
      console.log($_parent);

      $.ajax({
        url: "projects/single/" + $_slugValue,
        type: "POST",
        data: {
          "update-feed-likes": true,
          returnForAjaxRequest: true,
          // likes: Number(likesNumber.innerText),
          fk_feed_id: $_feedID,
        },
        success: function (response) {  
          if (response !== undefined) {
            console.log(response);
            response = JSON.parse(response);
            likesNumber.innerText = response["likesNumber"];
            $_parent.removeClass("opacity-50");
            if (response["increaseLikes"]) {
              $_parent.addClass("opacity-50");
            }
          }
        },
        error: function (jqXHR, textStatus, errorThrown) {
          if (jqXHR.status === 400) {
            // Parse the JSON response
            var response = JSON.parse(jqXHR.responseText);
            if (response.code === 999 && response.value !== undefined) {
              console.log(response);
              document.location.reload();
            }
          }
        },
      });
    });
  });

  // ON PROJECT DELETE
  $("[name = delete-project]").each(function (index) {
    console.log($(this));
    $(this).click(function () {
      $cardToDelete = $(this).closest(".entire-card");
      // console.log($cardToDelete.length);
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
          let projectID = $(this).data("projectid");
          $.ajax({
            url: "projects",
            type: "POST",
            data: {
              "delete-project": true,
              projectID: projectID,
            },
            success: function (response) {
              console.log(response);
              if (!response.length) {
                if ($cardToDelete.length) $cardToDelete.remove();
                else {
                  Swal.fire(
                    "Deleted!",
                    "Your project has been deleted.",
                    "success"
                  );
                  setTimeout(function () {
                    document.location = "projects";
                  }, 3000);
                }
              } else
                Swal.fire("Error!", "Your project has not been deleted.", "fail");
            },
            error: function (jqXHR, textStatus, errorThrown) {
              Swal.fire("Error!", "Your project has not been deleted.", "fail");
            },
          });
        }
      });
    });
  });
});
