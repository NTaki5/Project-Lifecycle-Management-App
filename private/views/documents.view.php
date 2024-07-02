<?php
$this->view("/includes/header");
?>

<div class="container-fluid">
    <div class="card card-body py-3">
        <div class="row align-items-center">
            <div class="col-12">
                <div class="d-flex align-items-center flex-wrap gap-2 gap-md-5">
                    <div class="d-flex gap-1 gap-md-3 align-items-center flex-wrap">
                        <div class="position-relative">
                            <input type="text" class="form-control notes-search ps-5" id="input-search" placeholder="Search files...">
                            <i class="ti ti-search position-absolute top-50 start-0 translate-middle-y fs-6 text-dark ms-3"></i>
                        </div>
                    </div>
                    <nav aria-label="breadcrumb" class="ms-auto d-none d-sm-block">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item d-flex align-items-center">
                                <a class="text-muted text-decoration-none d-flex" href="../main/index.html">
                                    <iconify-icon icon="solar:home-2-line-duotone" class="fs-6"></iconify-icon>
                                </a>
                            </li>
                            <li class="breadcrumb-item" aria-current="page">
                                <span class="badge fw-medium fs-2 bg-primary-subtle text-primary">
                                    Documents
                                </span>
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <ul class="nav nav-pills p-3 mb-3 rounded align-items-center card flex-row gap-2">
        <li class="nav-item">
            <a href="javascript:void(0)" class="
                      nav-link
                     gap-6
                      note-link
                      d-flex
                      align-items-center
                      justify-content-center
                      active
                      px-3 px-md-3
                      me-0 me-md-2 fs-11
                    " id="all-category">
                <i class="ti ti-list fill-white"></i>
                <span class="d-none d-md-block fw-medium">All Files</span>
            </a>
        </li>
        <li class="nav-item">
            <a href="javascript:void(0)" class="
                      nav-link
                     gap-6
                      note-link
                      d-flex
                      align-items-center
                      justify-content-center
                      active
                      px-3 px-md-3
                      me-0 me-md-2 fs-11
                    " id="images">
                <i class="ti ti-camera fill-white"></i>
                <span class="d-none d-md-block fw-medium">Images</span>
            </a>
        </li>
        <li class="nav-item">
            <a href="javascript:void(0)" class="
                      nav-link
                     gap-6
                      note-link
                      d-flex
                      align-items-center
                      justify-content-center
                      active
                      px-3 px-md-3
                      me-0 me-md-2 fs-11
                    " id="documents">
                <i class="ti ti-file fill-white"></i>
                <span class="d-none d-md-block fw-medium">Documents</span>
            </a>
        </li>
        <li class="nav-item ms-lg-auto flex-grow-1 flex-md-grow-0">
            
            <form method="POST" enctype="multipart/form-data" class="d-flex gap-1 gap-md-3" id="file-upload-form">
                <div class="flex-grow-1">
                    <a onclick="$('#file-upload').trigger('click')" class="btn btn-secondary d-flex align-items-center px-3 gap-6">
                        <i class="ti ti-file fs-4"></i>
                        <span class="d-none d-md-block fw-medium fs-3">Upload Documents</span>
                    </a>
                    <input type="file" id="file-upload" name="file_name" accept=".docx,.xlsx,.txt,application/pdf" onchange="$('#file-upload-form').trigger('submit')" hidden></input>
                </div>
                <div class="flex-grow-1">
                    <a onclick="$('#image-upload').trigger('click')" class="btn btn-secondary d-flex align-items-center px-3 gap-6">
                        <i class="ti ti-camera fs-4"></i>
                        <span class="d-none d-md-block fw-medium fs-3">Upload Images</span>
                    </a>
                    <input type="file" id="image-upload" name="image_name" accept="images/*" onchange="$('#file-upload-form').trigger('submit')" hidden></input>
                </div>
                <input type="text" name="add-file" hidden/>
                <input type="text" name="project-slug" value="<?=$_GET['project']?>" hidden/>
            </form>
        </li>
    </ul>
    <div class="tab-content">
        <div id="note-full-container" class="note-has-grid row">

        <!-- HERE the content are coming from AJAX request from page bottom -->

        </div>
    </div>

</div>

<?php
$this->view("/includes/footer");
?>

<script defer>
        document.getElementById('input-search').addEventListener('keyup', function() {
        var searchValue = this.value.toLowerCase();
        var notes = document.querySelectorAll('.single-note-item');

        notes.forEach(function(note) {
            var title = note.querySelector('.note-title').textContent.toLowerCase();
            var date = note.querySelector('.note-date').textContent.toLowerCase();
            
            if (title.includes(searchValue) || date.includes(searchValue)) {
                note.style.display = '';
            } else {
                note.style.display = 'none';
            }
        });
    });
</script>

<script>
    $(document).ready(function() {
        var $btns = $(".note-link").click(function() {
            var categoryId = this.id;
            loadCategoryItems(categoryId);
            $btns.removeClass("active");
            $(this).addClass("active");
        });

        function loadCategoryItems(categoryId) {
            $.ajax({
                url: 'documents?project=<?=$_GET['project']?>',
                method: 'POST',
                data: { 
                    getfiles: true,
                    category: categoryId },
                beforeSend: function() {
                    $("#note-full-container").html('<div class="loading">Loading...</div>'); // Show loading indicator
                },
                success: function(response) {
                    $("#note-full-container").html(response);
                },
                error: function() {
                    $("#note-full-container").html('<div class="error">Failed to load items.</div>');
                }
            });
        }

        // Load all items initially
        loadCategoryItems('all-category');
    });
</script>