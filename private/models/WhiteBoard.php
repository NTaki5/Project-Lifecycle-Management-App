<?php

class WhiteBoard extends Model
{

    public $allowedColumns = ["fk_user_id", "fk_board_code", "board_name"];
    protected $table = "white_boards";

    public function validate($data)
    {
        $this->errors = array();
        $return = true;
        if (empty($data["title"]) || !preg_match("/^[a-z. A-Z0-9]+$/", $data["title"]) || strlen($data['title']) > 60) {
            $this->errors["title"] = "Only letters and numbers allowed in task name. Max. length is 60 cahracters.";
            $return = false;
        }

        return $return;
    }

    public function getHTMLBoards($dataArr)
    {

        $returnString = "";
        foreach ($dataArr as $key => $value) {

            $createdDate = $this->convertToRomanianFormat($value->CreatedDate);
            // $modifiedDate = $this->convertToRomanianFormat($value->LastChange);

            $returnString .= <<<DELIMETER
                <div class="col-md-6 col-lg-4 entire-card">
                    <div class="card shadow">
                        <a href="whiteBoards/single/{$value->Id}">
                            <div class="bg-color-primary rounded-3 rounded-bottom-0 p-2 backgr">
                            </div>
                        </a>
                        <div class="card-body position-relative">
                            <a href="whiteBoards/single/{$value->Id}">
                                <h4 class="card-title">
                                    {$value->Name}
                                </h4>
                            </a>

                            <div class="d-flex align-items-center my-3">
                                <div class="row">
                                    <div class="col-12">
                                        <span class="d-flex align-items-center col-12">
                                            <i class="ti ti-calendar me-1 fs-5"></i>
                                            Created:{$createdDate}
                                            </a>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <form method="POST" class="d-flex position-absolute bottom-0 end-0 m-2">
                                <a class="btn bg-danger-subtle" name="delete-board" data-boardID="{$value->Id}">
                                    <iconify-icon  class="ms-auto" icon="mdi:delete-outline"></iconify-icon>
                                </a>
                            </form>
                        </div>
                    </div>
                </div>
DELIMETER;
        }
        return $returnString;
    }

    private function convertToRomanianFormat($dateString)
    {
        // Parse the date string into a DateTime object
        $dateTime = new DateTime($dateString, new DateTimeZone('UTC'));

        // Set the timezone to Romania
        $dateTime->setTimezone(new DateTimeZone('Europe/Bucharest'));

        // Format the date and time in Romanian format
        $romanianDate = $dateTime->format('d.m.Y H:i:s');

        return $romanianDate;
    }
}
