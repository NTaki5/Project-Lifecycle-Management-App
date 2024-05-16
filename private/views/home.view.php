<?php
    $this->view("/includes/header");
?>

<h2 class="w-100">Home Page</h2>

<?php
echo '<pre>';
    print_r($data);
    $this->view("/includes/footer");
?>