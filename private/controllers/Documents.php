<?php 
// Documents Controller

class Documents extends Controller{

    function index(){

        if(!isset($_GET['project'])){
            $this->redirect('home');
            exit();
        }
    
        $projectSlug = $_GET['project'];

        $document = new Document();
        $project = new Project();
        $projectID = $project->where('slug', $projectSlug)[0]->id;
        $errors = array();
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            if(isset($_POST['getfiles'])){
                $ajaxCards = "";

                if($_POST['category'] === 'all-category'){
                    $imagesQuery = $document->findAll(where:"fk_project_id = ".$projectID." AND type LIKE 'image%' ");
                    $ajaxCards .= $document->getImageCards($imagesQuery);

                    $documentsQuery = $document->findAll(where:"fk_project_id = ".$projectID." AND type NOT LIKE '%image%' ");
                    $ajaxCards .= $document->getDocumentCards($documentsQuery);
                }

                if($_POST['category'] === 'images'){
                    $imagesQuery = $document->findAll(where:"fk_project_id = ".$projectID." AND type LIKE '%image%' ");
                    $ajaxCards .= $document->getImageCards($imagesQuery);
                }
                
                if($_POST['category'] === 'documents'){
                    $documentsQuery = $document->findAll(where:"fk_project_id = ".$projectID." AND type NOT LIKE '%image%' ");
                    $ajaxCards .= $document->getDocumentCards($documentsQuery);
                }
                echo $ajaxCards;
                exit();
            }

            if(isset($_POST['add-file'])){

                $projectID = $project->where('slug', $_POST['project-slug'])[0]->id;
                if(strlen($_FILES['file_name']['tmp_name'])){
                    if (!file_exists('uploads/documents/documents')) {
                        // If not, create the directory
                        mkdir('uploads/documents/documents', 0777, true);
                    }
                    $fileName = $_FILES['file_name']['name'] . '-' . mt_rand(10000000, 99999999);
                    $fileType = $_FILES['file_name']['type'];
                    $path = 'uploads/documents/documents';
                    copy($_FILES['file_name']['tmp_name'], $path . DIRECTORY_SEPARATOR . $fileName);
                }
                if(strlen($_FILES['image_name']['tmp_name'])){
                    if (!file_exists('uploads/documents/images')) {
                        // If not, create the directory
                        mkdir('uploads/documents/images', 0777, true);
                    }
                    $path = 'uploads/documents/images';
                    $fileName = isset($_FILES['image_name']) ? add_webp_image($path,$_FILES['image_name']['name'], $_FILES['image_name']['tmp_name']):"";

                    $fileType = $_FILES['image_name']['type'];
                }

                if(isset($fileName)){
                    $_POST['name'] = $fileName;
                    $_POST['type'] = $fileType;
                    $_POST['path'] = $path;
                    $_POST['fk_project_id'] = $projectID;

                    if(count($document->insert($_POST))){
                        new Toast("The file could not be uploaded");
                        exit();
                    }
                    new Toast("File has been uploaded");
                }
            }
        }
        

        $this->view("documents", [
            'errors' => $errors
        ]);
    }
}