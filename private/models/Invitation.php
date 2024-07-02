<?php

class Invitation extends Model{

    protected $allowedColumns = ["fk_company_id", "fk_project_id", "name", "email","phone", "token", "expires_at", "user_role", "used"];


    public function showInTeamTable(){

        $tableRows = "";
        $invitations = $this->where('used',0);
        // $invitations = array_map(function($obj){
        //     if($obj->expires_at > date('Y-m-d H:i:s'))
        //         return $obj;
        // }, $invitations);
        // $invitations = array_filter( $invitations);
        rsort($invitations);

        $actionBtns = "";
        if(strtolower(Auth::getRole()) === 'admin'){
            $actionBtns = <<<DELIMETER
                <div class="action-btn">
                    <a href="javascript:void(0)" class="text-dark delete ms-2">
                        <i class="ti ti-trash fs-5"></i>
                    </a>
                </div>
DELIMETER;
        }

        foreach ($invitations as $key => $value) {
            $avatar = 'user-'.rand(1,15).'.jpg';
            if($value->expires_at > date('Y-m-d H:i:s')){
                $confirmationText = 'Waiting for confirmation';
                $statusText = 'pending';
                $statusClass = '';
            }
            else{
                $confirmationText = 'Invitation expired';
                $statusText = 'expired';
                $statusClass = 'bg-danger text-white';
            }

            $tableRows .= <<<DELIMETER
                <tr class="search-items">
                    <td>
                        <div class="n-chk align-self-center text-center">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input team-member-chkbox primary" id="checkbox1" />
                                <label class="form-check-label" for="checkbox1"></label>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="d-flex align-items-center">
                            <img src="assets/images/profile/$avatar" alt="avatar" class="rounded-circle" width="35" />
                            <div class="ms-3">
                                <div class="user-meta-info d-flex flex-column">
                                    <h6 class="user-name mb-0" data-name="{$invitations[$key]->name}">{$invitations[$key]->name}</h6>
                                    <span class="text-danger">$confirmationText</span>
                                </div>
                            </div>
                        </div>
                    </td>
                    <td>
                      <span class="$statusClass badge text-bg-light text-dark fw-semibold fs-2 gap-1 d-inline-flex align-items-center">
                        <i class="ti ti-clock-hour-4 fs-3"></i>$statusText
                      </span>
                    </td>
                    <td>
                        <span class="usr-email-addr" data-email="{$invitations[$key]->email}"><a href="mailto:{$invitations[$key]->email}">{$invitations[$key]->email}</a></span>
                    </td>
                    <td>
                        <span class="usr-phone" data-phone="{$invitations[$key]->phone}"><a href="tel:{$invitations[$key]->phone}"> {$invitations[$key]->phone} </a></span>
                    </td>
                    <td>
                        $actionBtns
                    </td>
                </tr>
DELIMETER;
        }

    return $tableRows;
        
    }

}