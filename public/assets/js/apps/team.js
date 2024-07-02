$(function () {

  function checkall(clickchk, relChkbox) {
    var checker = $("#" + clickchk);
    var multichk = $("." + relChkbox);

    checker.click(function () {
      multichk.prop("checked", $(this).prop("checked"));
      $(".show-btn").toggle();
    });
  }

  checkall("team-member-check-all", "team-member-chkbox");

  $("#input-search").on("keyup", function () {
    var rex = new RegExp($(this).val(), "i");
    $(".search-table .search-items:not(.header-item)").hide();
    $(".search-table .search-items:not(.header-item)")
      .filter(function () {
        return rex.test($(this).text());
      })
      .show();
  });

  $("#btn-add-team").on("click", function (event) {
    $("#addTeamModal #btn-add").show();
    $("#addTeamModal #btn-edit").hide();
    $("#addTeamModal").modal("show");
  });

  function deleteTeam() {
    $(".delete").off("click");
    $(".delete").on("click", function (event) {
      event.preventDefault();
      // Get Parents
      var getParentItem = $(this).parents(".search-items");
      var $_email = getParentItem.find(".usr-email-addr");
      var $_phone = getParentItem.find(".usr-phone");
      var $_userid = getParentItem.find("#userid");
      var $userid = $_userid.val();

      var $_emailAttrValue = $_email.attr("data-email");
      var $_phoneAttrValue = $_phone.attr("data-phone");
      let row = $(this).parents(".search-items");
      /* Act on the event */
      $.ajax({
        url: "team",
        type: "POST",
        data: {
          "delete-user": true,
          email:$_emailAttrValue,
          phone:$_phoneAttrValue,
          userId: $userid
        },
        success: function (response) {
          if(response !== undefined)
          {  
            row.remove();
            document.body.insertAdjacentHTML("afterbegin", response.value);
            hideElement(".toast.show");
          }
          
        },
        error: function (jqXHR, textStatus, errorThrown) {
          if (jqXHR.status === 400) {
            // Parse the JSON response
            var response = JSON.parse(jqXHR.responseText);
            if (response.code === 999 && response.value !== undefined) {
               document.body.insertAdjacentHTML("afterbegin", response.value);
               hideElement(".toast.show");
            }
          }
        },
      });
    });
  }

  function addTeam() {
    $("#btn-add").off("click");
    $("#btn-add").click(function () {
      var getParent = $(this).parents(".modal-content");

      var $_name = getParent.find("#c-name");
      var $_email = getParent.find("#c-email");
      var $_getInputPhone = getParent.find("#c-phone");


      var $_getValidationField =
        document.getElementsByClassName("validation-text");
      var reg = /^.+@[^\.].*\.[a-z]{2,}$/;

      var $_nameValue = $_name.val();
      var $_emailValue = $_email.val();
      var $_phoneValue = $_getInputPhone.val();

      if ($_emailValue == "") {
        $_getValidationField[1].innerHTML = "Email Id must be filled out";
        $_getValidationField[1].style.display = "block";
      } else if (reg.test($_emailValue) == false) {
        $_getValidationField[1].innerHTML = "Invalid Email";
        $_getValidationField[1].style.display = "block";
      } else {
        $_getValidationField[1].style.display = "none";
      }

      if ($_emailValue == "" || reg.test($_emailValue) == false) {
        return false;
      }

      $.ajax({
        url: "team",
        type: "POST",
        data: {
          "send-email": true,
          name: $_nameValue,
          email: $_emailValue,
          phone:$_phoneValue
        },
        success: function (response) {
          console.log(response);
          var today = new Date();
          var dd = String(today.getDate()).padStart(2, "0");
          var mm = String(today.getMonth()); //January is 0!
          var time = String(today.getTime());
          var cdate = dd + mm + time;

        $html =
          '<tr class="search-items">' +
          "<td>" +
          '<div class="n-chk align-self-center text-center">' +
          '<div class="form-check">' +
          '<input type="checkbox" class="form-check-input team-member-chkbox primary" id="' +
          cdate +
          '">' +
          '<label class="form-check-label" for="' +
          cdate +
          '"></label>' +
          "</div>" +
          "</div>" +
          "</td>" +
          "<td>" +
          '<div class="d-flex align-items-center">' +
          '<img src="assets/images/profile/user-' +
          (Math.floor(Math.random() * 15) + 1) +
          '.jpg" alt="avatar" class="rounded-circle" width="35">' +
          '<div class="ms-3">' +
          '<div class="user-meta-info">' +
          '<h6 class="user-name mb-0" data-name=' +
          $_nameValue +
          ">" +
          $_nameValue +
          "</h6>" +
          '<span class="text-danger">Waiting for confirmation</span>' +
          "</div>" +
          "</div>" +
          "</div>" +
          "</td>" +

          "<td>"+
              '<span class="badge bg-success-subtle text-danger fw-semibold fs-2 gap-1 d-inline-flex align-items-center">'+
                  '<i class="ti ti-circle fs-3"></i>offline'+
              '</span>'+
          '</td>'+

          "<td>" +
          '<span class="usr-email-addr" data-email=' +
          $_emailValue +
          ">" +
          $_emailValue +
          "</span>" +
          "</td>" +
          "<td>"+
          '<span class="usr-phone" data-phone='+
          $_phoneValue+
          '><a href="tel:'+
          $_phoneValue+
          '"> '+
          $_phoneValue +
          '</a></span>'+
          "</td>"+
          "<td>" +
          '<div class="action-btn">' +
          '<a href="javascript:void(0)" class="text-dark delete ms-2"><i class="ti ti-trash fs-5"></i></a>' +
          "</div>" +
          "</td>" +
          "</tr>";

          
          if(response !== undefined)
            {  
              $(".search-table > tbody >tr:first").before($html);
              document.body.insertAdjacentHTML("afterbegin", response.value);
              deleteTeam();
            }
        },
        error: function (jqXHR, textStatus, errorThrown) {
          if (jqXHR.status === 400) {
            // Parse the JSON response
            var response = JSON.parse(jqXHR.responseText);
            if (response.code === 999 && response.value !== undefined) {
               document.body.insertAdjacentHTML("afterbegin", response.value);
            }
          }
        },
      });

      hideElement(".toast.show");
      $("#addTeamModal").modal("hide");

      // deleteTeam();

      var $_setNameValueEmpty = $_name.val("");
      var $_setEmailValueEmpty = $_email.val("");
      checkall("team-member-check-all", "team-member-chkbox");
    });
  }

  $("#addTeamModal").on("hidden.bs.modal", function (e) {
    var $_name = document.getElementById("c-name");
    var $_email = document.getElementById("c-email");
    var $_getValidationField =
      document.getElementsByClassName("validation-text");

    var $_setNameValueEmpty = ($_name.value = "");
    var $_setEmailValueEmpty = ($_email.value = "");

    for (var i = 0; i < $_getValidationField.length; i++) {
      e.preventDefault();
      $_getValidationField[i].style.display = "none";
    }
  });

  function editTeam() {
    // Remove any previously attached event handlers
  $(".edit").off("click");
    $(".edit").on("click", function (event) {
      $("#addTeamModal #btn-add").hide();
      $("#addTeamModal #btn-edit").show();

      // Get Parents
      var getParentItem = $(this).parents(".search-items");
      var getModal = $("#addTeamModal");

      // Get List Item Fields
      var $_name = getParentItem.find(".user-name");
      var $_email = getParentItem.find(".usr-email-addr");
      var $_phone = getParentItem.find(".usr-phone");
      var $_userid = getParentItem.find("#userid");
      var $userid = $_userid.val();

      // Get Attributes
      var $_nameAttrValue = $_name.attr("data-name");
      var $_emailAttrValue = $_email.attr("data-email");
      var $_phoneAttrValue = $_phone.attr("data-phone");

      // Get Modal Attributes
      var $_getModalNameInput = getModal.find("#c-name");
      var $_getModalEmailInput = getModal.find("#c-email");
      var $_getModalPhoneInput = getModal.find("#c-phone");

      // Set Modal Field's Value
      var $_setModalNameValue = $_getModalNameInput.val($_nameAttrValue);
      var $_setModalEmailValue = $_getModalEmailInput.val($_emailAttrValue);
      var $_setModalPhoneValue = $_getModalPhoneInput.val($_phoneAttrValue);

      $("#addTeamModal").modal("show");

      $("#btn-edit").off("click");
      $("#btn-edit").click(function () {
        var getParent = $(this).parents(".modal-content");

        var $_getInputName = getParent.find("#c-name");
        var $_getInputNmail = getParent.find("#c-email");
        var $_getInputPhone = getParent.find("#c-phone");

        var $_nameValue = $_getInputName.val();
        var $_emailValue = $_getInputNmail.val();
        var $_phoneValue = $_getInputPhone.val();
      
        $("#addTeamModal").modal("hide");

        $.ajax({
          url: "team",
          type: "POST",
          data: {
            "edit-user": true,
            name: $_nameValue,
            email: $_emailValue,
            phone: $_phoneValue,
            userId: $userid
          },
          success: function (response) {
          if(response !== undefined)
            {  

              $_name.text($_nameValue);
              $_email.find('a').text($_emailValue);
              $_phone.find('a').text($_phoneValue);
      
              $_name.attr("data-name", $_nameValue);
              $_email.attr("data-email", $_emailValue);
              $_phone.attr("data-phone", $_phoneValue);
      
              $_email.find('a').attr("href", "mailto:"+$_emailValue);
              $_phone.find('a').attr("href", "tel:"+$_phoneValue);

              document.body.insertAdjacentHTML("afterbegin", response.value);
              hideElement(".toast.show");
            }
          },
          error: function (jqXHR, textStatus, errorThrown) {
            if (jqXHR.status === 400) {
              // Parse the JSON response
              var response = JSON.parse(jqXHR.responseText);
              if (response.code === 999 && response.value !== undefined) {
                 document.body.insertAdjacentHTML("afterbegin", response.value);
                 hideElement(".toast.show");
              }
            }
          },
        });

      });
    });
  }

  $(".delete-multiple").on("click", function () {
    var inboxCheckboxParents = $(".team-member-chkbox:checked").parents(
      ".search-items"
    );
    inboxCheckboxParents.remove();
  });

  deleteTeam();
  addTeam();
  editTeam();
});

// Validation Process

var $_getValidationField = document.getElementsByClassName("validation-text");
var reg = /^.+@[^\.].*\.[a-z]{2,}$/;

getEmailInput = document.getElementById("c-email");

if(getEmailInput){
  getEmailInput.addEventListener("input", function () {
    getEmailInputValue = this.value;
  
    if (getEmailInputValue == "") {
      $_getValidationField[1].innerHTML = "Email Required";
      $_getValidationField[1].style.display = "block";
    } else if (reg.test(getEmailInputValue) == false) {
      $_getValidationField[1].innerHTML = "Invalid Email";
      $_getValidationField[1].style.display = "block";
    } else {
      $_getValidationField[1].style.display = "none";
    }
  });
}
