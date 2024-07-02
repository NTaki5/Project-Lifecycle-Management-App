$(function () {
  
    $("#input-search").on("keyup", function () {
      var rex = new RegExp($(this).val(), "i");
      $(".search-table .search-items:not(.header-item)").hide();
      $(".search-table .search-items:not(.header-item)")
        .filter(function () {
          return rex.test($(this).text());
        })
        .show();
    });
  
    $("#btn-add-project-status").on("click", function (event) {
      $("#addStatusModal #btn-add").show();
      $("#addStatusModal #btn-edit").hide();
      $("#addStatusModal").modal("show");
    });
  
    function deleteStatus() {
      $(".delete").on("click", function (event) {
        event.preventDefault();
        // Get Parents
        var getParentItem = $(this).parents(".search-items");
        var $_color = getParentItem.find(".status-color");
        var $_phone = getParentItem.find(".usr-phone");
        var $_statusid = getParentItem.find("#statusid");
        var $statusid = $_statusid.val();
  
        var $_colorAttrValue = $_color.attr("data-color");
        var $_phoneAttrValue = $_phone.attr("data-phone");
        let row = $(this).parents(".search-items");
        /* Act on the event */
        $.ajax({
          url: "project",
          type: "POST",
          data: {
            "delete-user": true,
            color:$_colorAttrValue,
            phone:$_phoneAttrValue,
            statusId: $statusid
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
  
    function addStatus() {
      $("#btn-add").click(function () {
        var getParent = $(this).parents(".modal-content");
  
        var $_name = getParent.find("#c-name");
        var $_color = getParent.find("#c-color");
        var $_priority = getParent.find("#c-priority");
        var $_active = getParent.find("#c-active");
        var $_active = getParent.find("#c-active");
  
        var $_getValidationField =
          document.getElementsByClassName("validation-text");
  
        var $_statusNameValue = $_name.val();
        var $_statusColorValue = $_color.val();
        $_statusColorValueInput = '<input type="color" name="color" value="'+$_statusColorValue+'" disabled/>';
        var $_statusPriorityValue = $_priority.val();
        
        var $_statusActiveValue = $_active.is(':checked') ? 1 : 0;
        var $_statusActiveValueString = $_active.is(':checked') ? "Yes" : "No";
  
        if ($_statusNameValue == "") {
          $_getValidationField[0].innerHTML = "Status name must be filled out";
          $_getValidationField[0].style.display = "block";
        } else {
          $_getValidationField[0].style.display = "none";
        }

        if ((!$.isNumeric($_statusPriorityValue) || (parseInt($_statusPriorityValue) <= 0) || ($_statusPriorityValue == ""))) {
            $_getValidationField[2].innerHTML = "Must be greater than 0";
            $_getValidationField[2].style.display = "block";
            return false;
          } else {
            $_getValidationField[2].style.display = "none";
          }
  


        $.ajax({
          url: "projects/statuses",
          type: "POST",
          data: {
            "add": true,
            name: $_statusNameValue,
            color: $_statusColorValue,
            priority: $_statusPriorityValue,
            active: $_statusActiveValue,
          },
          success: function (response) {
            $html =
            '<tr class="search-items">' +
            "<td>" +
            '<div class="user-meta-info">' +
            '<h6 class="user-name mb-0" data-name=' +
            $_statusNameValue +
            ">" +
            $_statusNameValue +
            "</h6>" +
            "</div>" +
            "</td>" +
            "<td>" +
            '<span class="status-color" data-color=' +
            $_statusColorValue +
            ">" +
            $_statusColorValueInput +
            "</span>" +
            "</td>" +
            "<td>" +
            '<span class="status-priority" data-priority=' +
            $_statusPriorityValue +
            ">" +
            $_statusPriorityValue +
            "</span>" +
            "</td>" +
            "<td>" +
            '<span class="status-active" data-active=' +
            $_statusActiveValueString +
            ">" +
            $_statusActiveValueString +
            "</span>" +
            "</td>" +
            "<td>" +
            '<div class="action-btn">' +
            '<a href="javascript:void(0)" class="text-primary edit"><i class="ti ti-eye fs-5"></i></a>'+
            '<a href="javascript:void(0)" class="text-dark delete ms-2"><i class="ti ti-trash fs-5"></i></a>' +
            "</div>" +
            "</td>" +
            "</tr>";
  
            
            if(response !== undefined)
              {  
                $(".search-table > tbody").prepend($html);
                response = JSON.parse(response);
                document.body.insertAdjacentHTML("afterbegin", response.value);
                editStatus();
                deleteStatus();
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
        $("#addStatusModal").modal("hide");
  
        $_name.val("");
        $_color.val("");
        $_priority.val("");
        $_active.attr("");
      });
    }
  
    $("#addStatusModal").on("hidden.bs.modal", function (e) {
      var $_name = document.getElementById("c-name");
      var $_color = document.getElementById("c-color");
      var $_priority = document.getElementById("c-priority");
      var $_active = document.getElementById("c-active");
      var $_getValidationField =
        document.getElementsByClassName("validation-text");
  
      $_name.value = "";
      $_color.value = "";
      $_priority.value = "";
  
      for (var i = 0; i < $_getValidationField.length; i++) {
        e.preventDefault();
        $_getValidationField[i].style.display = "none";
      }
    });
  
    function editStatus() {
        // Remove any previously attached event handlers
        $(".edit").off("click");
      $(".edit").on("click", function (event) {
        $("#addStatusModal #btn-add").hide();
        $("#addStatusModal #btn-edit").show();
  
        // Get Parents
        var getParentItem = $(this).parents(".search-items");
        var getModal = $("#addStatusModal");
  
        // Get List Item Fields
        var $_name = getParentItem.find(".user-name");
        var $_color = getParentItem.find(".status-color");
        var $_priority = getParentItem.find(".status-priority");
        var $_active = getParentItem.find(".status-active");
        var $_statusid = getParentItem.find("#statusid");
        var $statusid = $_statusid.val();
  
        // Get Attributes
        var $_nameAttrValue = $_name.attr("data-name");
        var $_colorAttrValue = $_color.attr("data-color");
        var $_priorityAttrValue = $_priority.attr("data-priority");
        var $_activeAttrValue = $_active.attr("data-active") == "No" ? false : true;
        console.log($_activeAttrValue);
        // Get Modal Attributes
        var $_getModalNameInput = getModal.find("#c-name");
        var $_getModalColorInput = getModal.find("#c-color");
        var $_getModalPriorityInput = getModal.find("#c-priority");
        var $_getModalActiveInput = getModal.find("#c-active");
  
        // Set Modal Field's Value
        $_getModalNameInput.val($_nameAttrValue);
        $_getModalColorInput.val($_colorAttrValue);
        $_getModalPriorityInput.val($_priorityAttrValue);
        $_getModalActiveInput.attr('checked' , $_activeAttrValue);
        $_getModalActiveInput.replaceWith($_getModalActiveInput);
  
        $("#addStatusModal").modal("show");
  
        $("#btn-edit").off("click");
        $("#btn-edit").on('click', function () {
            
          var getParent = $(this).parents(".modal-content");
  
          var $_getInputName = getParent.find("#c-name");
          var $_getInputColor = getParent.find("#c-color");
          var $_getInputPriority = getParent.find("#c-priority");
          var $_getInputActive = getParent.find("#c-active");
  
          var $_statusNameValue = $_getInputName.val();
          var $_statusColorValue = $_getInputColor.val();
          var $_statusPriorityValue = $_getInputPriority.val();
          var $_statusActiveValue = $_getInputActive.is(':checked') ? 1 : 0;
          var $_statusActiveValueString = $_getInputActive.is(':checked') ? "Yes" : "No";
        
          $("#addStatusModal").modal("hide");
  
          $.ajax({
            url: "projects/statuses",
            type: "POST",
            data: {
              edit: true,
              name: $_statusNameValue,
              color: $_statusColorValue,
              priority: $_statusPriorityValue,
              active: $_statusActiveValue,
              statusId: $statusid
            },
            success: function (response) {
            if(response !== undefined)
              {  
  
                $_name.text($_statusNameValue);
                $_name.attr("data-name", $_statusNameValue);
                $_color.attr("data-color", $_statusColorValue);
                $_color.children('input').attr("value", $_statusColorValue);
                $_priority.text($_statusPriorityValue);
                $_priority.attr("data-priority", $_statusPriorityValue);
                $_active.text($_statusActiveValueString);
                $_active.attr("data-active", $_statusActiveValueString);
                console.log(response);
                response = JSON.parse(response);
                console.log(response);
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
  
    deleteStatus();
    addStatus();
    editStatus();
  });
  
  // Validation Process
  
  var $_getValidationField = document.getElementsByClassName("validation-text");
  var reg = /^.+@[^\.].*\.[a-z]{2,}$/;
  
  getStatusNameInput = document.getElementById("c-name");
  
  if(getStatusNameInput){
    getStatusNameInput.addEventListener("input", function () {
      getStatusNameInputValue = this.value;
    
      if (getStatusNameInputValue == "") {
        $_getValidationField[0].innerHTML = "Name Required";
        $_getValidationField[0].style.display = "block";
      } else {
        $_getValidationField[0].style.display = "none";
      }
    });
  }
  