<?php

class Document extends Model{

    protected $allowedColumns = ["fk_project_id", "fk_feed_id", "fk_comment_id", "document_name", "type", "name", "path"];

    public function getDocumentCards($files){
        $returnCards = "";

        foreach ($files as $key => $value) {
            
            $date = getFormattedDate($value->date);
            $path = ROOT . '/' . $value->path . '/' . $value->name;

            $returnCards .= <<<DELIMETER
            <div class="col-sm-6 col-md-4 col-lg-3 single-note-item position-relative">
                <div class="d-flex align-items-center position-absolute end-0 top-0 me-3 z-index-5">
                    <a href="javascript:void(0)" class="link text-danger mt-3 me-3">
                        <i class="ti ti-trash fs-4 remove-note"></i>
                    </a>
                </div>
                <a href="$path" target="_blank">
                    <div class="card card-body">
                        <span class="side-stick"></span>
                        <h6 class="note-title text-truncate w-75 mb-0" data-noteHeading="{$value->name}"> {$value->name} </h6>
                        <p class="note-date fs-2">$date</p>
                    </div>
                </a>
            </div>
DELIMETER;
        }

        return $returnCards;

    }

    public function getImageCards($files){
        $returnCards ="";
//         $returnCards = <<<DELIMETER
//         <div class="container-fluid">
//             <div class="row el-element-overlay">
// DELIMETER;

        foreach ($files as $key => $value) {
            
            $date = getFormattedDate($value->date);
            $path = ROOT . '/' . $value->path . '/' . $value->name;

            $returnCards .= <<<DELIMETER
                        <div class="col-sm-6 col-md-4 col-lg-3  single-note-item position-relative">
                        <div class="d-flex align-items-center position-absolute end-0 top-0 me-3 z-index-5">
                            <a href="javascript:void(0)" class="link text-danger mt-3 me-3">
                                <i class="ti ti-trash fs-4 remove-note"></i>
                            </a>
                        </div>
                            <div class="card overflow-hidden position-relative">
                                <div class="el-card-item pb-3">
                                    <div class="
                                        el-card-avatar
                                        mb-3
                                        el-overlay-1
                                        w-100
                                        overflow-hidden
                                        text-center
                                        ">
                                        <img src="$path" class="d-block  w-100" alt="$date" />
                                        <div class="el-overlay w-100 h-100 overflow-hidden">
                                            <a href="$path" target="_blank" class="position-absolute start-0 end-0 top-0 bottom-0 h-100 w-100">
                                                <!-- <ul class="
                                                    list-style-none
                                                    el-info
                                                    text-white text-uppercase
                                                    d-inline-block
                                                    p-0
                                                    ">
                                                        <li class="el-item d-inline-block my-0 mx-1">
                                                            <span class="
                                                                btn
                                                                default
                                                                btn-outline
                                                                image-popup-vertical-fit
                                                                el-link
                                                                text-white
                                                                border-white
                                                                " href="$path" target="_blank">
                                                                <i class="ti ti-camera"></i>
                                                            </span>
                                                        </li>
                                                </ul> -->
                                            </a>
                                        </div>
                                    </div>
                                    <div class="el-card-content text-center">
                                        <h6 class="note-title mb-0" data-noteHeading="{$value->name}"> {$value->name} </h6>
                                        <p class="note-date fs-2">$date</p>
                                    </div>
                                </div>
                            </div>
                        </div>
DELIMETER;
        }
//         $returnCards .= <<<DELIMETER
//             </div>
//         </div>
// DELIMETER;
        return $returnCards;

    }

}