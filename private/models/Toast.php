<?php

class Toast
{

    function __construct($title ="", $subtitle="")
    {
        $_SESSION['toastTitle'] = $title;
        $_SESSION['toastSubtitle'] = $subtitle;
        $_SESSION['show-toast'] = true;
    }

    public static function setToast($title, $subtitle="")
    {
        $_SESSION['toastTitle'] = $title;
        $_SESSION['toastSubtitle'] = $subtitle;
        $_SESSION['show-toast'] = true;
    }

    // public static function getToast($title, $subtitle)
    // {
    //     $_SESSION['toastTitle'] = $title;
    //     $_SESSION['toastSubtitle'] = $subtitle;
    // }

    public static function show($class="")
    {
        if (isset($_SESSION['show-toast'])) {
            $_SESSION['toastTitle'];
            $_SESSION['toastSubtitle'];
            
            $return = <<<DELIMETER

                <div class="toast $class align-items-center text-bg-primary border-0" role="alert" aria-live="assertive" aria-atomic="true">
                    <div class="toast-body hstack align-items-start gap-6">
                        <i class="ti ti-alert-circle fs-6"></i>
                        <div>
                            <h5 class="text-white fs-3 mb-1">{$_SESSION['toastTitle']}</h5>
                            <h6 class="text-white fs-2 mb-0">{$_SESSION['toastSubtitle']}</h6>
                        </div>
                        <button type="button" class="btn-close btn-close-white fs-2 m-0 ms-auto shadow-none" data-bs-dismiss="toast" aria-label="Close"></button>
                    </div>
                </div>
DELIMETER;
            
        unset($_SESSION['toastTitle']);
        unset($_SESSION['toastSubtitle']);
        unset($_SESSION['show-toast']);
        return $return;
        }
    }
}
