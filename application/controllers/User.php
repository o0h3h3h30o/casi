<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

/**
 * Class : User (UserController)
 * User Class to control all user related operations.
 * @author : Kishor Mali
 * @version : 1.1
 * @since : 15 November 2016
 */
class User extends BaseController
{
    /**
     * This is default constructor of the class
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('user_model');
        $this->isLoggedIn();   
    }
    
    /**
     * This function used to load the first screen of the user
     */
    public function index()
    {
        $this->global['pageTitle'] = 'CodeInsect : Dashboard';
        
        $this->loadViews("dashboard", $this->global, NULL , NULL);
    }
    
    /**
     * This function is used to load the user list
     */
    function userListing()
    {
        // var_dump($this->isAdmin());
        // die();
        if($this->isAdmin() != TRUE)
        {
            // echo "1234";die();
            $this->loadThis();
        }
        else
        {        
            $searchText = $this->security->xss_clean($this->input->post('searchText'));
            $data['searchText'] = $searchText;
            
            $this->load->library('pagination');
            
            $count = $this->user_model->userListingCount($searchText);

			$returns = $this->paginationCompress ( "userListing/", $count, 10 );
            
            $data['userRecords'] = $this->user_model->userListing($searchText, $returns["page"], $returns["segment"]);
            
            $this->global['pageTitle'] = 'CodeInsect : User Listing';
            
            $this->loadViews("users", $this->global, $data, NULL);
        }
    }




    /**
     * This function is used to load the user list
     */
    function config()
    {
        // var_dump($this->isAdmin());
        // die();
        if($this->isAdmin() != TRUE)
        {
            
            $this->loadThis();
        }
        else
        {        

            $hu_tx = $this->user_model->getKeyConfig('dw_tx');
            
            $data['dw_tx'] = $hu_tx->value;
            

            $this->load->library('pagination');
            
            $count = $this->user_model->logsListingCount();

            $returns = $this->paginationCompress ( "config/", $count, 10 );


            $data['logsRecords'] = $this->user_model->logsListing($returns["page"], $returns["segment"]);

            $this->global['pageTitle'] = 'Cập nhật thông tin hũ tài xỉu';
            
            $this->loadViews("log_tx", $this->global, $data, NULL);
        }
    }

    function config_bottx()
    {
        if($this->isAdmin() != TRUE)
        {         
            $this->loadThis();
        }
        else{
            $dw_tx = $this->security->xss_clean($this->input->post('dw_tx'));
            $note = $this->security->xss_clean($this->input->post('note'));
            $hu_tx = $this->user_model->getKeyConfig('dw_tx');
            $hu_ao = $hu_tx->value;
            // var_dump(expression)
            //lệch = sau - trước
            $lech = $dw_tx-$hu_ao;
            // $timechange = time();
            $current_tx = $hu_tx->value;

            $log_info = array(
                'gold_before' => $hu_ao,
                'gold_after' => $dw_tx,
                'gold_change' => $lech,
                'time_change' => time(),
                'note' => $note,
            );//addNewLog
            $this->load->model('user_model');
            $result = $this->user_model->addNewLog($log_info);
            

            //update config
            $config = array(
                'value' => $lech
            );
            $this->user_model->updateConfigByxKey($config, 'jar_tx');

            if($result > 0)
            {
                $this->session->set_flashdata('success', 'Thay đổi thông số hũ ảo thành công');
            }
            else
            {
                $this->session->set_flashdata('error', 'Thất bại');
            }
            
            redirect('config');
        }
    }


    function list_config()
    {
        // var_dump($this->isAdmin());
        // die();
        if($this->isAdmin() != TRUE)
        {
            
            $this->loadThis();
        }
        else
        {        

            $hu_tx = $this->user_model->getKeyConfig('dw_tx');
            
            $data['dw_tx'] = $hu_tx->value;
            

            // $this->load->library('pagination');
            
            // $count = $this->user_model->configListing();

            // $returns = $this->paginationCompress ( "config/", $count, 10 );


            $data['logsRecords'] = $this->user_model->configListing();

            $this->global['pageTitle'] = 'Thông số cấu hình toàn hệ thống';
            
            $this->loadViews("list_config", $this->global, $data, NULL);
        }
    }


    //thoong tin logs
    function logs()
    {
        if($this->isAdmin() != TRUE)
        {
            $this->loadThis();
        }
        else
        {        
            $searchText = $this->security->xss_clean($this->input->post('searchText'));
            $gameId = (int) $this->security->xss_clean($this->input->post('gameId'));
            $data['searchText'] = $searchText;
            
            $this->load->library('pagination');
            
            $count = $this->user_model->userLogsCount($searchText, $gameId);

            $returns = $this->paginationCompress ("logs/", $count, 50 );
            
            $data['userRecords'] = $this->user_model->userLogs($searchText, $gameId, $returns["page"], $returns["segment"]);
            // echo "<pre>";
            // print_r($count);
            // die();
            $this->global['pageTitle'] = 'Lịch sử game';
            
            $this->loadViews("logs", $this->global, $data, NULL);
        }
    }

    //thông tin hũ tài xỉu hiện tại
    function sessionSicbo()
    {
        if($this->isAdmin() != TRUE)
        {
            $this->loadThis();
        }
        else
        {        
            // $searchText = $this->security->xss_clean($this->input->post('searchText'));
            // $data['searchText'] = $searchText;
            
            $this->load->library('pagination');
            
            $session_tx = $this->user_model->getKeyConfig('tx_seq');
            // $session_tx->value = 121240;
            $data['session'] = $session_tx->value;

            //load toàn bộ người theo tài
            $rs_tai = $this->db->query('SELECT * FROM tbl_tx_session_log WHERE session = "'.$session_tx->value.'" AND tai_real > 0');

            $data['rs_tai'] = $rs_tai->result();
            
            $rs_xiu = $this->db->query('SELECT * FROM tbl_tx_session_log WHERE session = "'.$session_tx->value.'" AND xiu_real > 0');
            $data['rs_xiu'] = $rs_xiu->result();

            //tổng theo tài

            $total_tai = $this->db->query('SELECT sum(tai_real) as total_tai FROM tbl_tx_session_log WHERE session = "'.$session_tx->value.'" AND tai_real > 0');

            $data['total_tai'] = $total_tai->result();

            $total_xiu = $this->db->query('SELECT sum(xiu_real) as total_xiu FROM tbl_tx_session_log WHERE session = "'.$session_tx->value.'" AND xiu_real > 0');
            
            $data['total_xiu'] = $total_xiu->result();

            // print_r($data['session']);die();

            // $returns = $this->paginationCompress ( "userListing/", $count, 10 );
            
            // $data['userRecords'] = $this->user_model->userListing($searchText, $returns["page"], $returns["segment"]);
            
            $this->global['pageTitle'] = 'Phiên tài xỉu hiện tại';
            
            $this->loadViews("sicbo", $this->global, $data, NULL);
        }
    }
    //đại lý
    function dailyListing()
    {
        // echo "123";die();
        if($this->isAdmin() != TRUE)
        {
            // echo "1234";die();
            $this->loadThis();
        }
        else
        {        
            $searchText = $this->security->xss_clean($this->input->post('searchText'));
            $data['searchText'] = $searchText;
            
            $this->load->library('pagination');
            
            $count = $this->user_model->dailyListingCount($searchText);

            $returns = $this->paginationCompress ( "daily/", $count, 10 );
            
            $data['userRecords'] = $this->user_model->dailyListing($searchText, $returns["page"], $returns["segment"]);
            
            $this->global['pageTitle'] = 'Danh sách đại lý';
            
            $this->loadViews("users", $this->global, $data, NULL);
        }
    }
    /**
     * This function is used to load the add new form
     */
    function addNew()
    {
        if($this->isAdmin() != TRUE)
        {
            $this->loadThis();
        }
        else
        {

            $this->load->model('user_model');
            $data['roles'] = $this->user_model->getUserRoles();
            
            $this->global['pageTitle'] = 'Thêm mới người dùng';

            $this->loadViews("addNew", $this->global, $data, NULL);
        }
    }

    /**
     * This function is used to check whether email already exist or not
     */
    function checkEmailExists()
    {
        $userId = $this->input->post("userId");
        $email = $this->input->post("email");

        if(empty($userId)){
            $result = $this->user_model->checkEmailExists($email);
        } else {
            $result = $this->user_model->checkEmailExists($email, $userId);
        }

        if(empty($result)){ echo("true"); }
        else { echo("false"); }
    }
    

    function checkUsernamelExists()
    {
        $userId = $this->input->post("userId");
        $email = $this->input->post("username");

        if(empty($userId)){
            $result = $this->user_model->checkUsernamelExists($email);
        } else {
            $result = $this->user_model->checkUsernamelExists($email, $userId);
        }

        if(empty($result)){ echo("true"); }
        else { echo("false"); }
    }

    /**
     * This function is used to add new user to the system
     */
    function addNewUser()
    {
        if($this->isAdmin() != TRUE)
        {
            $this->loadThis();
        }
        else
        {
            $this->load->library('form_validation');
            
            $this->form_validation->set_rules('username','Tên đăng nhâpk','trim|required|max_length[128]');
            $this->form_validation->set_rules('nickname','Tên hiển thị','trim|required|max_length[128]');
            $this->form_validation->set_rules('password','Password','required|max_length[20]');
            $this->form_validation->set_rules('cpassword','Confirm Password','trim|required|matches[password]|max_length[20]');
            $this->form_validation->set_rules('role','Role','trim|required|numeric');
            if($this->form_validation->run() == FALSE)
            {
                $this->addNew();
            }
            else
            {
                $username = $this->security->xss_clean($this->input->post('username'));
                $nickname = $this->security->xss_clean($this->input->post('nickname'));
                $password = $this->security->xss_clean($this->input->post('password'));                
                $store_title = $this->security->xss_clean($this->input->post('store_title'));
                $roleId = $this->input->post('role');
                $phone = $this->security->xss_clean($this->input->post('phone'));
                $userInfo = array('username'=>$username,'nickname'=>$nickname, 'password'=>$password, 'user_type'=>$roleId, 'store_title'=> $store_title, 'status' => 1, 'phone'=>$phone, 'verify' => 1);               
                $this->load->model('user_model');
                $result = $this->user_model->addNewUser($userInfo);
                
                if($result > 0)
                {
                    $this->session->set_flashdata('success', 'New User created successfully');
                }
                else
                {
                    $this->session->set_flashdata('error', 'User creation failed');
                }
                
                redirect('addNew');
            }
        }
    }

    
    /**
     * This function is used load user edit information
     * @param number $userId : Optional : This is user id
     */
    function editOld($userId = NULL)
    {
        
        // echo "$userId";die();
        if($this->isAdmin() != TRUE)
        {
            $this->loadThis();
        }
        else
        {
            if($userId == null)
            {
                redirect('userListing');
            }
            
            $data['roles'] = $this->user_model->getUserRoles();
            $data['userInfo'] = $this->user_model->getUserInfo($userId);
            // echo "<pre>";
            // print_r($data['roles']);die();
            $this->global['pageTitle'] = 'Cap nhật thông tin người dùng';
            
            $this->loadViews("editOld", $this->global, $data, NULL);
        }
    }

    function editConfig($configId = NULL)
    {
        
        // echo $configId;die();
        if($this->isAdmin() != TRUE)
        {
            $this->loadThis();
        }
        else
        {
            if($configId == null)
            {
                redirect('list_config');
            }
            
            $data['config_info'] = $this->user_model->getKeyConfigById($configId);
            // echo "<pre>";
            // print_r($data['config_info']);die();
            $this->global['pageTitle'] = 'Cap nhật giá trị config';
            
            $this->loadViews("editConfig", $this->global, $data, NULL);
        }
    }
    
    
    /**
     * This function is used to edit the user information
     */
    function editUser()
    {
        if($this->isAdmin() != TRUE)
        {
            $this->loadThis();
        }
        else
        {
            $this->load->library('form_validation');
            
            $userId = $this->input->post('userId');
            
            $this->form_validation->set_rules('username','Full Name','trim|required|max_length[128]');
            // $this->form_validation->set_rules('nickname','Tên hiển thị','trim|required');
            $this->form_validation->set_rules('password','Password','matches[cpassword]|max_length[20]');
            $this->form_validation->set_rules('cpassword','Confirm Password','matches[password]|max_length[20]');
            $this->form_validation->set_rules('role','Role','trim|required|numeric');
            $this->form_validation->set_rules('phone','Mobile Number','required');
            // $this->form_validation->set_rules('store_tile','Mobile Number','required');
            
            if($this->form_validation->run() == FALSE)
            {
                $this->editOld($userId);
            }
            else
            {
                $username = $this->security->xss_clean($this->input->post('username'));
                $nickname = $this->security->xss_clean($this->input->post('nickname'));
                $store_title = $this->security->xss_clean($this->input->post('store_title'));
                $phone = $this->security->xss_clean($this->input->post('phone'));
                $password = $this->input->post('password');
                $roleId = $this->input->post('role');
                $phone = $this->security->xss_clean($this->input->post('phone'));
                
                $userInfo = array();
                
                if(empty($password))
                {
                    $userInfo = array('username'=>$username, 'user_type'=>$roleId, 'nickname'=>$nickname,'store_title'=>$store_title, 'phone'=>$phone,'user_type'=>$roleId, 'phone'=>$phone, );
                }
                else
                {
                    $userInfo = array('nickname'=>$nickname,'username'=>$username, 'password'=>$password, 'user_type'=>$roleId,
                        'username'=>$username, 'store_title'=>$store_title, 'phone'=>$phone );
                }
                
                $result = $this->user_model->editUser($userInfo, $userId);
                
                if($result == true)
                {
                    $this->session->set_flashdata('success', 'User updated successfully');
                }
                else
                {
                    $this->session->set_flashdata('error', 'User updation failed');
                }
                
                redirect('userListing');
            }
        }
    }


    /**
     * This function is used to delete the user using userId
     * @return boolean $result : TRUE / FALSE
     */
    function deleteUser()
    {
        if($this->isAdmin() == TRUE)
        {
            echo(json_encode(array('status'=>'access')));
        }
        else
        {
            $userId = $this->input->post('userId');
            $userInfo = array('isDeleted'=>1,'updatedBy'=>$this->vendorId, 'updatedDtm'=>date('Y-m-d H:i:s'));
            
            $result = $this->user_model->deleteUser($userId, $userInfo);
            
            if ($result > 0) { echo(json_encode(array('status'=>TRUE))); }
            else { echo(json_encode(array('status'=>FALSE))); }
        }
    }
    
    /**
     * Page not found : error 404
     */
    function pageNotFound()
    {
        $this->global['pageTitle'] = 'CodeInsect : 404 - Page Not Found';
        
        $this->loadViews("404", $this->global, NULL, NULL);
    }

    /**
     * This function used to show login history
     * @param number $userId : This is user id
     */
    function loginHistoy($userId = NULL)
    {
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {
            $userId = ($userId == NULL ? 0 : $userId);

            $searchText = $this->input->post('searchText');
            $fromDate = $this->input->post('fromDate');
            $toDate = $this->input->post('toDate');

            $data["userInfo"] = $this->user_model->getUserInfoById($userId);

            $data['searchText'] = $searchText;
            $data['fromDate'] = $fromDate;
            $data['toDate'] = $toDate;
            
            $this->load->library('pagination');
            
            $count = $this->user_model->loginHistoryCount($userId, $searchText, $fromDate, $toDate);

            $returns = $this->paginationCompress ( "login-history/".$userId."/", $count, 10, 3);

            $data['userRecords'] = $this->user_model->loginHistory($userId, $searchText, $fromDate, $toDate, $returns["page"], $returns["segment"]);
            
            $this->global['pageTitle'] = 'CodeInsect : User Login History';
            
            $this->loadViews("loginHistory", $this->global, $data, NULL);
        }        
    }

    /**
     * This function is used to show users profile
     */
    function profile($active = "details")
    {
        // $data["userInfo"] = $this->user_model->getUserInfoWithRole($this->vendorId);
        // $data["active"] = $active;
        
        // $this->global['pageTitle'] = $active == "details" ? 'CodeInsect : My Profile' : 'CodeInsect : Change Password';
        // $this->loadViews("profile", $this->global, $data, NULL);
    }

    /**
     * This function is used to update the user details
     * @param text $active : This is flag to set the active tab
     */
    function profileUpdate($active = "details")
    {
        // $this->load->library('form_validation');
            
        // $this->form_validation->set_rules('fname','Full Name','trim|required|max_length[128]');
        // $this->form_validation->set_rules('mobile','Mobile Number','required|min_length[10]');
        // $this->form_validation->set_rules('email','Email','trim|required|valid_email|max_length[128]|callback_emailExists');        
        
        // if($this->form_validation->run() == FALSE)
        // {
        //     $this->profile($active);
        // }
        // else
        // {
        //     $name = ucwords(strtolower($this->security->xss_clean($this->input->post('fname'))));
        //     $mobile = $this->security->xss_clean($this->input->post('mobile'));
        //     $email = strtolower($this->security->xss_clean($this->input->post('email')));
            
        //     $userInfo = array('name'=>$name, 'email'=>$email, 'mobile'=>$mobile, 'updatedBy'=>$this->vendorId, 'updatedDtm'=>date('Y-m-d H:i:s'));
            
        //     $result = $this->user_model->editUser($userInfo, $this->vendorId);
            
        //     if($result == true)
        //     {
        //         $this->session->set_userdata('name', $name);
        //         $this->session->set_flashdata('success', 'Profile updated successfully');
        //     }
        //     else
        //     {
        //         $this->session->set_flashdata('error', 'Profile updation failed');
        //     }

        //     redirect('profile/'.$active);
        // }
    }

    /**
     * This function is used to change the password of the user
     * @param text $active : This is flag to set the active tab
     */
    function changePassword($active = "changepass")
    {
        $this->load->library('form_validation');
        
        $this->form_validation->set_rules('oldPassword','Old password','required|max_length[20]');
        $this->form_validation->set_rules('newPassword','New password','required|max_length[20]');
        $this->form_validation->set_rules('cNewPassword','Confirm new password','required|matches[newPassword]|max_length[20]');
        
        if($this->form_validation->run() == FALSE)
        {
            $this->profile($active);
        }
        else
        {
            $oldPassword = $this->input->post('oldPassword');
            $newPassword = $this->input->post('newPassword');
            
            $resultPas = $this->user_model->matchOldPassword($this->vendorId, $oldPassword);
            
            if(empty($resultPas))
            {
                $this->session->set_flashdata('nomatch', 'Your old password is not correct');
                redirect('profile/'.$active);
            }
            else
            {
                $usersData = array('password'=>getHashedPassword($newPassword), 'updatedBy'=>$this->vendorId,
                                'updatedDtm'=>date('Y-m-d H:i:s'));
                
                $result = $this->user_model->changePassword($this->vendorId, $usersData);
                
                if($result > 0) { $this->session->set_flashdata('success', 'Password updation successful'); }
                else { $this->session->set_flashdata('error', 'Password updation failed'); }
                
                redirect('profile/'.$active);
            }
        }
    }

    /**
     * This function is used to check whether email already exist or not
     * @param {string} $email : This is users email
     */
    function emailExists($email)
    {
        $userId = $this->vendorId;
        $return = false;

        if(empty($userId)){
            $result = $this->user_model->checkEmailExists($email);
        } else {
            $result = $this->user_model->checkEmailExists($email, $userId);
        }

        if(empty($result)){ $return = true; }
        else {
            $this->form_validation->set_message('emailExists', 'The {field} already taken');
            $return = false;
        }

        return $return;
    }

    //caapj nhat cau hinh
    function updateConfig()
    {
        if($this->isAdmin() != TRUE)
        {
            $this->loadThis();
        }
        else
        {
            $this->load->library('form_validation');
            
            $config_id = $this->input->post('config_id');
                        
            
            
            $value = $this->security->xss_clean($this->input->post('value'));
            
            
            $config_info = array(
                'value' => $value,
            );
            
            $this->load->model('user_model');
            
            $result = $this->user_model->updateConfigById($config_info, $config_id);
            
            if($result == true)
            {
                $this->session->set_flashdata('success', 'User updated successfully');
            }
            else
            {
                $this->session->set_flashdata('error', 'User updation failed');
            }
            
            redirect('list_config');
        }
        
    }

    function addGold($userId)
    {
        if($this->isAdmin() != TRUE)
        {
            $this->loadThis();
        }
        else
        {
            if($userId == null)
            {
                redirect('userListing');
            }
            
            // $data['roles'] = $this->user_model->getUserRoles();
            $data['userInfo'] = $this->user_model->getUserInfo($userId);

            $this->global['pageTitle'] = 'Cap nhật thông tin người dùng';
            
            $this->loadViews("addGold", $this->global, $data, NULL);
        }
    }

    function update_gold()
    {
        if($this->isAdmin() != TRUE)
        {
            $this->loadThis();
        }
        else
        {
            $this->load->library('form_validation');
            
            $userId = $this->input->post('userId');
            $username = $this->input->post('username');
            $gold_update = $this->input->post('gold_update');
                        
            $flushObj = array(
                'username' => $username,
                'flush_type' => 'GOLD',
                'value' => $gold_update
            );
            
            // $value = $this->security->xss_clean($this->input->post('value'));
            
            
            // $config_info = array(
            //     'value' => $value,
            // );
            
            $this->load->model('user_model');
            
            $result = $this->user_model->updateGold($flushObj);
            
            if($result == true)
            {
                $this->session->set_flashdata('success', 'User updated successfully');
            }
            else
            {
                $this->session->set_flashdata('error', 'User updation failed');
            }
            
            redirect('userListing');
        }
        
    }

}

?>