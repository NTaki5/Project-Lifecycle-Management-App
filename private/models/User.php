<?php

class User extends Model
{

    protected $allowedColumns = ["username","online", "email", "phone", "facebook", "instagram", "youtube", "password", "name", "birthday", "companyName", "companyCUI", "companyAddress", "companyType", "date", "role","occupation",  "fk_company_id", "image", "avatar"];

    // functions before insert the data in DB
    protected $beforeInsert = ["hash_password"];

    public function validate($data)
    {

        $this->errors = array();
        $return = true;
        $user = new User();
        if (empty($data["username"])) {
            $this->errors["username"] = "You must give us the username";
            $return = false;
        }
        else 
            if(Auth::is_logged_in()){
                if(count($usernameUserID = $user->where('username', $data["username"]))) {
                    if($usernameUserID[0]->id != Auth::getId() && $usernameUserID[0]->fk_company_id == Auth::getFk_company_id()){
                        $this->errors["username"] = "This username already exists";
                        $return = false;
                    }
                }
            }else{
                if(!$user->uniqueValue('username', $data["username"])) {
                    $this->errors["username"] = "This username already exists";
                    $return = false;
                }
            }


        if (isset($data["occupation"]) && empty($data["occupation"])) {
            $this->errors["occupation"] = "You must give us the occupation";
            $return = false;
        }

        if (strlen($data["username"]) < 6) {
            $this->errors["username"] = "The username must be at least 6 characters";
            $return = false;
        }

        if (empty($data["name"]) || !preg_match("/^[\p{L} ]+$/u", $data["name"])) {
            $this->errors["name"] = "You must give us the name without any symbol";
            $return = false;
        }

        if (empty($data["birthday"])) {
            $this->errors["birthday"] = "You must give us your birthday";
            $return = false;
        }

        // Regular expression for validating an email
        $pattern = '/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/';
        if (empty($data["email"]) || ($data["email"] != filter_var($data["email"], FILTER_SANITIZE_EMAIL)) || !preg_match($pattern,$data["email"])) {
            $this->errors["email"] = "Email is not valid";
            $return = false;
        }
        else
            if(Auth::is_logged_in()){
                if(count($emailUserID = $user->where('email', $data["email"]))) {
                    if($emailUserID[0]->id != Auth::getId() && $emailUserID[0]->fk_company_id == Auth::getFk_company_id()){
                        $this->errors["email"] = "This email already exists";
                        $return = false;
                    }
                }
            }else{
                if($user->uniqueValue('email', $data["email"])) {
                    $this->errors["email"] = "This email already exists";
                    $return = false;
                }
            }
        // if(!$user->uniqueValue('email', $data["email"])) {
        //     $this->errors["email"] = "This email already exists";
        //     $return = false;
        // }

        if (empty($data["phone"]) || !preg_match('/^\+?[0-9]\d{10,14}$/', $data["phone"])) {
            $this->errors["phone"] = "Phone is not valid";
            $return = false;
        }

        // Regex for validating Facebook URL
        $pattern = '/^(https?:\/\/)?(www\.)?facebook\.com\/[a-zA-Z0-9\.]+$/';
        if (!empty($data["facebook"]) && !preg_match($pattern, $data["facebook"])) {
            $this->errors["facebook"] = "Facebook profile link is not valid";
            $return = false;
        }

        // Regex for validating Instagram URL
        $pattern = '/^(https?:\/\/)?(www\.)?instagram\.com\/[a-zA-Z0-9._]+\/?$/';
        if (!empty($data["instagram"]) && !preg_match($pattern, $data["instagram"])) {
            $this->errors["instagram"] = "Instagram profile link is not valid";
            $return = false;
        }

        // Regex for validating YouTube URL
        $pattern = '/^(https?:\/\/)?(www\.)?youtube\.com\/(channel\/|user\/|c\/|@)?[a-zA-Z0-9_-]+$/';
        if (!empty($data["youtube"]) && !preg_match($pattern, $data["youtube"])) {
            $this->errors["youtube"] = "YouTube profile link is not valid";
            $return = false;
        }

        if (isset($data["password"]) && (empty($data["password"]) || strcmp($data["password"], $data["password2"]))) {
            $this->errors["password"] = "Paswords do not match";
            $return = false;
        }
        return $return;
    }


    public function passwordResetValidate($data)
    {

        $this->errors = array();
        $return = true;

        // echo Auth::getPassword(); die();
        if (empty($data["old_password"]) || !password_verify($data["old_password"], Auth::getPassword())) {
            $this->errors["old_password"] = "Not match with your current password";
            $return = false;
        }

        if (empty($data["password"]) || strcmp($data["password"], $data["password_confirm"])) {
            $this->errors["password"] = "Paswords do not match";
            $return = false;
        }

        return $return;
    }

    public function showInTeamTable(){

        $tableRows = "";
        $users = $this->findAll('fk_company_id = '.Auth::getFk_company_id(), orderby: 'online DESC, name ASC');
        // rsort($users);

        $actionBtns = "";
        if(strtolower(Auth::getRole()) === 'admin'){
            $actionBtns = <<<DELIMETER
            <div class="action-btn">
                <a href="javascript:void(0)" class="text-primary edit">
                    <i class="ti ti-eye fs-5"></i>
                </a>
                <a href="javascript:void(0)" class="text-dark delete ms-2">
                    <i class="ti ti-trash fs-5"></i>
                </a>
            </div>
DELIMETER;
        }

        foreach ($users as $key => $value) {
            
            $status =  "offline";
            $textColorClass = "text-danger";

            if($value->online){
                $status =  "online";
                $textColorClass = "text-success";
            }
            

            $image = 
            (strlen($users[$key]->image) && file_exists('uploads/users/' . $users[$key]->image)) ?
            'uploads/users/' . $users[$key]->image :
            'assets/images/profile/'.$users[$key]->avatar;
            $userId = $users[$key]->id;

            $userRole = strtolower($users[$key]->role) === 'admin' ? ucfirst($users[$key]->role) : ucfirst($users[$key]->occupation);
            $userRole .= $users[$key]->id === Auth::getId() ? "( Me )" : "";

            // employees can only edit their own data
            if(((strtolower(Auth::getRole()) !== 'admin') && (strtolower(Auth::getRole()) === 'employee')) && ($users[$key]->id === Auth::getId())){
                $actionBtns = <<<DELIMETER
                <div class="action-btn">
                    <a href="javascript:void(0)" class="text-primary edit">
                        <i class="ti ti-eye fs-5"></i>
                    </a>
                    <a href="javascript:void(0)" class="text-dark delete ms-2">
                        <i class="ti ti-trash fs-5"></i>
                    </a>
                </div>
DELIMETER;
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
                            <img src="$image" alt="avatar" class="rounded-circle" width="35" />
                            <div class="ms-3">
                                <div class="user-meta-info d-flex flex-column">
                                    <h6 class="user-name mb-0" data-name="{$users[$key]->name}">{$users[$key]->name}</h6>
                                    <span class="text-success fw-bold">{$userRole}</span>
                                </div>
                            </div>
                        </div>
                    </td>
                    <td>
                        <span class="badge bg-success-subtle $textColorClass fw-semibold fs-2 gap-1 d-inline-flex align-items-center">
                            <i class="ti ti-circle fs-3"></i>$status
                        </span>
                    </td>
                    <td>
                        <span class="usr-email-addr" data-email="{$users[$key]->email}"><a href="mailto:{$users[$key]->email}">{$users[$key]->email}</a></span>
                    </td>
                    <td>
                        <span class="usr-phone" data-phone="{$users[$key]->phone}"><a href="tel:{$users[$key]->phone}"> {$users[$key]->phone} </a></span>
                    </td>
                    <td>
                        $actionBtns
                    </td>
                    <td class="d-none position-absolute">
                        <input hidden id="userid" name="userId" value="$userId"/>
                    </td>
                </tr>
DELIMETER;
        }

    return $tableRows;
        
    }
}
