$(function () {
  // Form dependencies

  var refProject = document.getElementById("projectSelect");
  var refTeam = document.getElementById("teamSelect");
  var projectBool = false;

  $('[data-btn-action="addTask"]').prop("disabled", true);

async function membersFromProject(projectID, returnMembers = false){
        // get Team Members from the project
        const response = await $.ajax({
          url: "tasks",
          type: "POST",
          data: {
            "get-members-fromProject": true,
            projectID: projectID,
          }
        });

        if (response !== undefined) {

          if(returnMembers)
            return JSON.parse(response);

          refTeam.innerHTML = "";
          var newOption = document.createElement("option");
          newOption.value = "";
          newOption.text = "Choose...";
          refTeam.appendChild(newOption);
          JSON.parse(response).forEach((element) => {
            var newOption = document.createElement("option");
            newOption.value = element["userId"];
            newOption.text =
              element["userName"] +
              (element["userRole"] == "client" ? "(client)" : "");
            refTeam.appendChild(newOption);
          });
        }
}
  
if(refProject){
  refProject.addEventListener("change", function (event) {
    if (event.target.value.length) {
      projectBool = true;
      refTeam.removeAttribute("disabled");
      membersFromProject(event.target.value);
    } else {
      $('[data-btn-action="addTask"]').prop("disabled", true);
      refTeam.setAttribute("disabled", "");
      projectBool = false;
    }
    if (projectBool) $('[data-btn-action="addTask"]').removeAttr("disabled");
  });
}
  // END form dependencies

  // ----------------------------------------------------------------------
  // draggble item
  // ----------------------------------------------------------------------
  function kanbanSortable() {
    $('[data-sortable="true"]').sortable({
      connectWith: ".connect-sorting-content",
      items: ".card",
      cursor: "move",
      placeholder: "ui-state-highlight",
      refreshPosition: true,
      stop: function (event, ui) {},
      update: function (event, ui) {
        var fk_category_id = ui.item
          .closest(".task-list-container")
          .attr("data-taskCategory-id");
        console.log(fk_category_id);
        console.log(ui);
        console.log(ui.item);

        var taskID = ui.item[0].firstElementChild.getAttribute("data-task-id");

        $.ajax({
          url: "tasks",
          type: "POST",
          data: {
            "update-status": true,
            taskID: taskID,
            fk_category_id: fk_category_id,
          },
          success: function (response) {
            if (response !== undefined) {
            }
          },
          error: function (jqXHR, textStatus, errorThrown) {
            if (jqXHR.status === 400) {
              // Parse the JSON response
              var response = JSON.parse(jqXHR.responseText);
              if (response.code === 999 && response.value !== undefined) {
                console.log(response);
                // document.location.reload();
              }
            }
          },
        });
      },
    });
  }

  // ----------------------------------------------------------------------
  // clear all task on click
  // ----------------------------------------------------------------------
  function clearItem() {
    $(".list-clear-all")
      .off("click")
      .on("click", function (event) {
        event.preventDefault();
        $(this)
          .parents('[data-action="sorting"]')
          .find(".connect-sorting-content .card")
          .remove();
      });
  }

  // ----------------------------------------------------------------------
  // add task and open modal
  // ----------------------------------------------------------------------
  function addKanbanItem() {
    $(".addTask").on("click", function (event) {
      event.preventDefault();

      document.getElementById("kanban-title").value = "";
      document.getElementById("kanban-text").value = "";
      document.getElementById("projectSelect").selectedIndex = 0;
      document.getElementById("teamSelect").selectedIndex = -1;

      taskCategoryID = $(this)
      .parents('[data-action="sorting"]')
      .attr("data-taskcategory-id");
      getParentElement = $(this)
        .parents('[data-action="sorting"]')
        .attr("data-item");
      $(".edit-task-title").hide();
      $(".add-task-title").show();
      $('[data-btn-action="addTask"]').show();
      $('[data-btn-action="editTask"]').hide();
      $("#addItemModal").modal("show");
      kanban_add(getParentElement,taskCategoryID);
    });
  }

  // ----------------------------------------------------------------------
  //   add default item
  // ----------------------------------------------------------------------
  function kanban_add(getParent, taskCategoryID) {
    $('[data-btn-action="addTask"]')
      .off("click")
      .on("click", function (event) {
        // getAddBtnClass = $(this).attr("class").split(" ")[1];

        var today = new Date();
        var dd = String(today.getDate()).padStart(2, "0");
        var mm = String(today.getMonth());
        var yy = String(today.getFullYear());

        var monthNames = [
          "Jan",
          "Feb",
          "Mar",
          "Apr",
          "May",
          "Jun",
          "Jul",
          "Aug",
          "Sep",
          "Oct",
          "Nov",
          "Dec",
        ];

        today = dd + " " + monthNames[mm] + " " + yy;

        var $_getParent = getParent;

        var itemTitle = document.getElementById("kanban-title").value;
        var itemText = document.getElementById("kanban-text").value;
        var itemProject = document.getElementById("projectSelect").value;
        var itemTeam = Array.from(
          document.getElementById("teamSelect").selectedOptions
        );
        var teamMembers = itemTeam.map(function (option) {
          return option.value;
        });

        $.ajax({
          url: "tasks",
          type: "POST",
          data: {
            "create-task": true,
            title: itemTitle,
            description: itemText,
            fk_project_id: itemProject,
            fk_category_id: taskCategoryID,
            teamMembers: teamMembers,
          },
          success: function (response) {
            console.log(response);
            if (response !== undefined) {
              insertedTaskId = JSON.parse(response)["insertedTaskId"];
              projectName = JSON.parse(response)["projectName"];
              projectColor = JSON.parse(response)["projectColor"];
              toast = JSON.parse(response)["toast"];
              item_html =
                '<div data-draggable="true" class="card task-text-progress" style="">' +
                '<div data-task-id="' +
                insertedTaskId +
                '" class="d-none"></div>' +
                '<div class="card-body">' +
                '<div class="task-header">' +
                '<div class="">' +
                '<h4 class="" data-item-title="' +
                itemTitle +
                '">' +
                itemTitle +
                "</h4>" +
                "</div>" +
                '<div class="">' +
                '<div class="dropdown">' +
                '<a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink-4" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="true">' +
                '<i class="ti ti-dots-vertical text-dark"></i>' +
                "</a>" +
                '<div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuLink-4">' +
                '<a class="dropdown-item kanban-item-edit cursor-pointer d-flex align-items-center gap-1" href="javascript:void(0);"><i class="ti ti-pencil fs-5"></i>Edit</a>' +
                '<a class="dropdown-item kanban-item-delete cursor-pointer d-flex align-items-center gap-1" href="javascript:void(0);"><i class="ti ti-trash fs-5"></i>Delete</a>' +
                "</div>" +
                "</div>" +
                "</div>" +
                "</div>" +
                '<div class="task-body">' +
                '<div class="task-content">' +
                '<p class="mb-0" data-item-text="' +
                itemText +
                '">' +
                itemText +
                "</p>" +
                "</div>" +
                '<div class="task-bottom">' +
                '<div class="tb-section-1">' +
                '<span class="hstack gap-2 fs-2" data-item-date="' +
                today +
                '"><i class="ti ti-calendar fs-5"></i> ' +
                today +
                "</span>" +
                "</div>" +
                '<div class="tb-section-2">' +
                '<span class="badge fs-1" style="background-color:' +
                projectColor +
                '">' +
                projectName +
                "</span>" +
                "</div>" +
                "</div>" +
                "</div>" +
                "</div>" +
                "</div>";

              $(
                "[data-item='" + $_getParent + "'] .connect-sorting-content"
              ).append(item_html);

              $("#addItemModal").modal("hide");

              document.body.insertAdjacentHTML("afterbegin", toast);
              hideElement(".toast.show");
              kanbanEdit();
              kanbanDelete();
            }
          },
          error: function (jqXHR, textStatus, errorThrown) {
            if (jqXHR.status === 400) {
              console.log(response);
              // Parse the JSON response
              var response = JSON.parse(jqXHR.responseText);
              if (response.code === 999 && response.value !== undefined) {
                // document.location.reload();
              }
            }
          },
        });
      });
  }

  // ----------------------------------------------------------------------
  //   add item
  // ----------------------------------------------------------------------
  $("#add-list")
    .off("click")
    .on("click", function (event) {
      event.preventDefault();

      $(".add-list").show();
      $(".edit-list").hide();
      $(".edit-list-title").hide();
      $(".add-list-title").show();
      $("#addListModal").modal("show");
    });

  // ----------------------------------------------------------------------
  //   add list
  // ----------------------------------------------------------------------
  $(".add-list")
    .off("click")
    .on("click", function (event) { 

      var itemTitle = document.getElementById("item-name").value;

      var itemNameLowercase = itemTitle.toLowerCase();
      var itemNameRemoveWhiteSpace = itemNameLowercase.split(" ").join("_");
      var itemDataAttr = itemNameRemoveWhiteSpace;

      item_html =
        '<div data-item="item-' +
        itemDataAttr +
        '" data-taskCategory-id = "'+
        taskCategoryID+
        '" class="task-list-container  mb-4 " data-action="sorting">' +
        '<div class="connect-sorting">' +
        '<div class="task-container-header">' +
        '<h6 class="item-head mb-0 fs-4 fw-semibold" data-item-title="' +
        itemTitle +
        '">' +
        itemTitle +
        "</h6>" +
        '<div class="hstack gap-2">' +
        '<div class="dropdown">' +
        '<a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink-4" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="true">' +
        '<i class="ti ti-dots-vertical text-dark"></i>' +
        "</a>" +
        '<div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuLink-4">' +
        '<a class="dropdown-item list-edit" href="javascript:void(0);">Edit</a>' +
        '<a class="dropdown-item list-delete" href="javascript:void(0);">Delete</a>' +
        '<a class="dropdown-item list-clear-all" href="javascript:void(0);">Clear All</a>' +
        "</div>" +
        "</div>" +
        "</div>" +
        "</div>" +
        '<div class="connect-sorting-content" data-sortable="true">' +
        "</div>" +
        "</div>" +
        "</div>";

      $(".task-list-section").append(item_html);
      $("#addListModal").modal("hide");
      $("#item-name").val("");
      kanbanSortable();
      editItem();
      deleteItem();
      clearItem();
      addKanbanItem();
      kanbanEdit();
      kanbanDelete();

      // --------------------
      // Tooltip
      // --------------------
      var tooltipTriggerList = [].slice.call(
        document.querySelectorAll('[data-bs-toggle="tooltip"]')
      );
      var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
      });
    });

  // ----------------------------------------------------------------------
  // edit list
  // ----------------------------------------------------------------------
  function editItem() {
    $(".list-edit")
      .off("click")
      .on("click", function (event) {
        event.preventDefault();

        var parentItem = $(this);

        $(".add-list").hide();
        $(".edit-list").show();

        $(".add-list-title").hide();
        $(".edit-list-title").show();

        $.ajax({
          url: "tasks",
          type: "POST",
          data: {
          },
          success: function (response) {
            if (response !== undefined) {
              console.log(response);
              item_html =
                '<div data-draggable="true" class="card task-text-progress" style="">' +
                '<div class="card-body">' +
                '<div class="task-header">' +
                '<div class="">' +
                '<h4 class="" data-item-title="' +
                itemTitle +
                '">' +
                itemTitle +
                "</h4>" +
                "</div>" +
                '<div class="">' +
                '<div class="dropdown">' +
                '<a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink-4" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="true">' +
                '<i class="ti ti-dots-vertical text-dark"></i>' +
                "</a>" +
                '<div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuLink-4">' +
                '<a class="dropdown-item kanban-item-edit cursor-pointer d-flex align-items-center gap-1" href="javascript:void(0);"><i class="ti ti-pencil fs-5"></i>Edit</a>' +
                '<a class="dropdown-item kanban-item-delete cursor-pointer d-flex align-items-center gap-1" href="javascript:void(0);"><i class="ti ti-trash fs-5"></i>Delete</a>' +
                "</div>" +
                "</div>" +
                "</div>" +
                "</div>" +
                '<div class="task-body">' +
                '<div class="task-content">' +
                '<p class="mb-0" data-item-text="' +
                itemText +
                '">' +
                itemText +
                "</p>" +
                "</div>" +
                '<div class="task-bottom">' +
                '<div class="tb-section-1">' +
                '<span class="hstack gap-2 fs-2" data-item-date="' +
                today +
                '"><i class="ti ti-calendar fs-5"></i> ' +
                today +
                "</span>" +
                "</div>" +
                '<div class="tb-section-2">' +
                '<span class="badge text-bg-success fs-1">Design</span>' +
                "</div>" +
                "</div>" +
                "</div>" +
                "</div>" +
                "</div>";

              $(
                "[data-item='" + $_getParent + "'] .connect-sorting-content"
              ).append(item_html);

              $("#addItemModal").modal("hide");
              kanbanEdit();
              kanbanDelete();
            }
          },
          error: function (jqXHR, textStatus, errorThrown) {
            if (jqXHR.status === 400) {
              // Parse the JSON response
              var response = JSON.parse(jqXHR.responseText);
              if (response.code === 999 && response.value !== undefined) {
                console.log(response);
                // document.location.reload();
              }
            }
          },
        });

        var itemTitle = parentItem
          .parents('[data-action="sorting"]')
          .find(".item-head")
          .attr("data-item-title");
        $("#item-name").val(itemTitle);

        $(".edit-list")
          .off("click")
          .on("click", function (event) {
            var $_innerThis = $(this);
            var $_getListTitle = document.getElementById("item-name").value;

            var $_editedListTitle = parentItem
              .parents('[data-action="sorting"]')
              .find(".item-head")
              .html($_getListTitle);
            var $_editedListTitleDataAttr = parentItem
              .parents('[data-action="sorting"]')
              .find(".item-head")
              .attr("data-item-title", $_getListTitle);

            $("#addListModal").modal("hide");
            $("#item-name").val("");
          });
        $("#addListModal").modal("show");
        $("#addListModal").on("hidden.bs.modal", function (e) {
          $("#item-name").val("");
        });
      });
  }

  // ----------------------------------------------------------------------
  // all list delete
  // ----------------------------------------------------------------------
  function deleteItem() {
    $(".list-delete")
      .off("click")
      .on("click", function (event) {
        event.preventDefault();
        $(this).parents("[data-action]").remove();
      });
  }

  // ----------------------------------------------------------------------
  // Delete item on click
  // ----------------------------------------------------------------------
  function kanbanDelete() {
    $(".card .kanban-item-delete")
      .off("click")
      .on("click", function (event) {
        event.preventDefault();
        get_card_parent = $(this).closest(".card");

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
            var taskID = get_card_parent.find("div").attr("data-task-id");

            $.ajax({
              url: "tasks",
              type: "POST",
              data: {
                "delete-task": true,
                taskID: taskID,
              },
              success: function (response) {
                console.log(response);
                if (!response.length) {
                  get_card_parent.remove();
                  console.log(taskID);

                  Swal.fire(
                    "Deleted!",
                    "Your task has been deleted.",
                    "success"
                  );
                } else
                  Swal.fire(
                    "Error!",
                    "Your task has not been deleted.",
                    "fail"
                  );
              },
              error: function (jqXHR, textStatus, errorThrown) {
                Swal.fire("Error!", "Your task has not been deleted.", "fail");
              },
            });
          }
        });
      });
    // $(".card .kanban-item-delete")
    //   .off("click")
    //   .on("click", function (event) {
    //     event.preventDefault();

    //     get_card_parent = $(this).parents(".card");

    //     $("#deleteConformation").modal("show");

    //     $('[data-remove="task"]').on("click", function (event) {
    //       event.preventDefault();
    //       /* Act on the event */
    //       get_card_parent.remove();
    //       $("#deleteConformation").modal("hide");
    //     });
    //   });
  }

  // ----------------------------------------------------------------------
  // Edit item on click
  // ----------------------------------------------------------------------
  function kanbanEdit() {
    $(".card .kanban-item-edit")
      .off("click")
      .on("click", function (event) {
        event.preventDefault();

        var parentItem = $(this);
        var itemTitle = parentItem
          .parents(".card")
          .find("h4")
          .attr("data-item-title");
        var get_kanban_title = $(".task-text-progress #kanban-title").val(
          itemTitle
        );

        var itemText = parentItem
          .parents(".card")
          .find("div.task-content > div")
          .attr("data-item-text");
        var get_kanban_text = $(".task-text-progress #kanban-text").val(
          itemText
        );

        var taskID = parentItem
          .parents(".card")
          .find("div")
          .attr("data-task-id");

        $(".add-task-title").hide();
        $(".edit-task-title").show();

        $('[data-btn-action="addTask"]').hide();
        $('[data-btn-action="editTask"]').show();

        $projectsFromCompany = "";
        $.ajax({
          url: "tasks",
          type: "POST",
          data: {
            "get-projects-fromCompany": true,
          },
          success: function (response) {
            if (response !== undefined) {
              $projectsFromCompany = JSON.parse(response);
            }

            // GET THE MEMBERS WHO working on tasks
            $.ajax({
              url: "tasks",
              type: "POST",
              data: {
                "get-membersAndProject-associated-with-Task": true,
                taskID: taskID,
              },
              success: function (response) {
                if (response !== undefined) {
                  $selectedMembers = JSON.parse(response)[0];
                  $selectedProjectID = JSON.parse(response)[1][0];
                  refProject.innerHTML = "";
                  var newOption = document.createElement("option");
                  newOption.value = "";
                  newOption.text = "Choose...";
                  refProject.appendChild(newOption);
                  
                  $projectsFromCompany.forEach((project) => {
                    var newOption = document.createElement("option");
                    newOption.value = project["id"];
                    newOption.text = project["title"];

                    if ($selectedProjectID  == project["id"]) {
                      newOption.setAttribute("selected", "");
                    }
                    refProject.appendChild(newOption);
                  });

                  refTeam.innerHTML = "";
                  var newOption = document.createElement("option");
                  newOption.value = "";
                  newOption.text = "Choose...";
                  refTeam.appendChild(newOption);

                  (async () => {
                    const projectMembers = await membersFromProject($selectedProjectID, true);
                    
                    projectMembers.forEach((member) => {
                        var newOption = document.createElement("option");
                        newOption.value = member["userId"];
                        newOption.text =
                          member["userName"] +
                          (member["userRole"] == "client" ? "(client)" : "");

                          $selectedMembers.forEach((element) => {
                            if (element['userId'] == (member['userId'])) {
                              newOption.setAttribute("selected", "");
                            }
                          });
                          
                          

                          
  
                        refTeam.appendChild(newOption);
                    });
                  })();
                  
                }
              },
              error: function (jqXHR, textStatus, errorThrown) {
                console.log(response);
              },
            });
          },
          error: function (jqXHR, textStatus, errorThrown) {
            console.log(response);
          },
        });


        $('[data-btn-action="editTask"]')
          .off("click")
          .on("click", function (event) {
            // ON PRESS THE SAVE BUTTON

            itemTitle = get_kanban_title[0].value;
            itemText = get_kanban_text[0].value;
            var itemProject = document.getElementById("projectSelect").value;
            var itemTeam = Array.from(
              document.getElementById("teamSelect").selectedOptions
            );
            var itemTeam = itemTeam.map(function (option) {
              return option.value;
            });
            console.log(itemTeam);
            $.ajax({
              url: "tasks",
              type: "POST",
              data: {
                "edit-task": true,
                title: itemTitle,
                description: itemText,
                fk_project_id: itemProject,
                teamMembers: itemTeam,
                taskID: taskID,
              },
              success: function (response) {
                if (response !== undefined) {
                  console.log(response);

                  toast = JSON.parse(response)["toast"];

                  document.body.insertAdjacentHTML("afterbegin", toast);
                  hideElement(".toast.show");
                }
              },
              error: function (jqXHR, textStatus, errorThrown) {
                if (jqXHR.status === 400) {
                  // Parse the JSON response
                  var response = JSON.parse(jqXHR.responseText);
                  if (response.code === 999 && response.value !== undefined) {
                    console.log(response);
                    // document.location.reload();
                  }
                }
              },
            });

            var kanbanValueTitle =
              document.getElementById("kanban-title").value;
            var kanbanValueText = document.getElementById("kanban-text").value;

            var itemDataAttr = parentItem
              .parents(".card")
              .find("h4")
              .attr("data-item-title", kanbanValueTitle);
            var itemTitle = parentItem
              .parents(".card")
              .find("h4")
              .html(kanbanValueTitle);
            var itemTextDataAttr = parentItem
              .parents(".card")
              .find(".task-content div")
              .attr("data-item-text", kanbanValueText);

            parentItem
              .parents(".card")
              .find(".task-content div")
              .html(kanbanValueText);

            var itemText = parentItem
              .parents(".card")
              .find('p:not(".progress-count")')
              .html(kanbanValueText);

            $("#addItemModal").modal("hide");
            var setDate = $(".taskDate").html("");
            $(".taskDate").hide();
          });
        $("#addItemModal").modal("show");
      });
  }

  editItem();
  deleteItem();
  clearItem();
  addKanbanItem();
  kanbanEdit();
  kanbanDelete();
  kanbanSortable();
});
