<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';
require APPPATH . '/libraries/GoogleAuthenticator.php';

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
        $GLOBALS["carriers_number"] = [
            '096' => 'Viettel',
            '097' => 'Viettel',
            '098' => 'Viettel',
            '032' => 'Viettel',
            '033' => 'Viettel',
            '034' => 'Viettel',
            '035' => 'Viettel',
            '036' => 'Viettel',
            '037' => 'Viettel',
            '038' => 'Viettel',
            '039' => 'Viettel',
            '090' => 'Mobifone',
            '093' => 'Mobifone',
            '070' => 'Mobifone',
            '071' => 'Mobifone',
            '072' => 'Mobifone',
            '076' => 'Mobifone',
            '078' => 'Mobifone',
            '091' => 'Vinaphone',
            '094' => 'Vinaphone',
            '083' => 'Vinaphone',
            '084' => 'Vinaphone',
            '085' => 'Vinaphone',
            '087' => 'Vinaphone',
            '089' => 'Vinaphone',
            '099' => 'Gmobile',
            '092' => 'Vietnamobile',
            '056' => 'Vietnamobile',
            '058' => 'Vietnamobile',
            '095'  => 'SFone'
        ];
        parent::__construct();
        $this->load->model('user_model');
        $this->isLoggedIn();   
    }
    
    /**
     * This function used to load the first screen of the user
     */

    public function index()
    {   
        //update đầu số
      

        // echo "1";die();
        //update đầu số
        if($this->isAdmin() != TRUE)
        {
             $this->loadThis();
        }else{
            $this->global['pageTitle'] = 'Big686 : Quản lý tài khoản';
        
            $user_id = $this->session->userdata('userId');  
            // tổng tiền user
            
            $data['gold_user'] = $this->getGoldByUserType(1);
            $data['gold_user_deposit'] = $this->getGoldDepositeByUserType(1);
            $data['gold_daily'] = $this->getGoldByUserType(2);
            $data['gold_daily_deposit'] = $this->getGoldDepositeByUserType(2);
            $data['userInfo'] = $this->user_model->getUserInfo($user_id);
            // $data['']
            $this->loadViews("dashboard", $this->global, $data , NULL);
        }
    }
    

    private function getGoldByUserType($user_type){
        $sql = 'SELECT SUM(gold) as `gold` FROM users WHERE user_type = "'.$user_type.'"';        
        return $this->db->query($sql)->row()->gold;
    }

    private function getGoldDepositeByUserType($user_type){
        $sql = 'SELECT SUM(gold_deposit) as `gold_deposit` FROM users WHERE user_type = "'.$user_type.'"';        
        return $this->db->query($sql)->row()->gold_deposit;
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
            $searchText = $this->security->xss_clean($this->input->post('searchText'));
            $data['searchText'] = $searchText;
            
            $this->load->library('pagination');
            
            $count = $this->user_model->userListingCount($searchText);

            $returns = $this->paginationCompress ( "userListing/", $count, 10 );
            
            $data['userRecords'] = $this->user_model->userListing($searchText, $returns["page"], $returns["segment"]);
            
            $this->global['pageTitle'] = 'Danh sách người dùng';
            
            $this->loadViews("users2", $this->global, $data, NULL);
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
            

            //tổng số tiền bơm vào
            $sql = 'SELECT (SUM(gold_before)-SUM(gold_after)) as tienrut FROM tbl_dw_logs WHERE gold_before > gold_after';
            $data['tienrut'] = $this->db->query($sql)->row()->tienrut;
            
            $sql = 'SELECT (SUM(gold_after)-SUM(gold_before)) as tiennap FROM tbl_dw_logs WHERE gold_after > gold_before';
            $data['tiennap'] = $this->db->query($sql)->row()->tiennap;
            

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
                $location = $this->security->xss_clean($this->input->post('location'));                
                $store_title = $this->security->xss_clean($this->input->post('store_title'));
                $roleId = $this->input->post('role');
                $phone = $this->security->xss_clean($this->input->post('phone'));
                $userInfo = array('username'=>$username,'nickname'=>$nickname, 'password'=>$password, 'user_type'=>$roleId, 'store_title'=> $store_title, 'status' => 1, 'phone'=>$phone, 'location' => $location , 'verify' => 1);               
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
                $location = $this->security->xss_clean($this->input->post('location'));
                $facebook_url = $this->security->xss_clean($this->input->post('facebook_url'));
                $store_title = $this->security->xss_clean($this->input->post('store_title'));
                $phone = $this->security->xss_clean($this->input->post('phone'));
                $password = $this->input->post('password');
                $roleId = $this->input->post('role');
                $phone = $this->security->xss_clean($this->input->post('phone'));
                
                $userInfo = array();
                
                if(empty($password))
                {
                    $userInfo = array('username'=>$username, 'user_type'=>$roleId, 'nickname'=>$nickname, 'location'=>$location, 'facebook_url'=>$facebook_url, 'store_title'=>$store_title, 'phone'=>$phone,'user_type'=>$roleId, 'phone'=>$phone, );
                }
                else
                {
                    $userInfo = array('nickname'=>$nickname,'username'=>$username, 'location'=>$location, 'password'=>$password, 'user_type'=>$roleId,'facebook_url'=>$facebook_url,
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
        
        $this->global['pageTitle'] = $active == "details" ? 'CodeInsect : My Profile' : 'CodeInsect : Change Password';
        $this->loadViews("profile", $this->global, $data, NULL);
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

    function recharge(){
        $user_id = $this->session->userdata('userId');

        $data['userInfo'] = $this->user_model->getUserInfo($user_id);
       
        $this->global['pageTitle'] = 'Nạp thẻ điện thoại';
        
        $this->loadViews("recharge", $this->global, $data, NULL);

    }

    function request_recharge(){
            $user_id = $this->session->userdata('userId');
            $userInfo = $this->user_model->getUserInfo($user_id);
            $serial = $this->security->xss_clean($this->input->post('serial'));
            $code = $this->security->xss_clean($this->input->post('code'));
            $type = $this->security->xss_clean($this->input->post('type'));
            $menhGia = $this->security->xss_clean($this->input->post('menhGia'));
            $requestId = time();
            //?apiKey={{apiKey}}&code={{mã_thẻ}}&serial={{serial}}&type={{loại_thẻ}}&menhGia={{menhGia}}&requestId={{requestId}}

            $param = array(
                'serial' => $serial,
                'code' => $code,
                'type' => $type,
                'menhGia' => $menhGia,
                'requestId' => 0,
                'apiKey' => 'cbe4df97-bca5-4d15-ac7f-5138d3455909',
            );

            // $url = 'http://naptien.ga/api/SIM/CheckCharge?apiKey=cbe4df97-bca5-4d15-ac7f-5138d3455909&id=278714';
            $url = 'http://naptien.ga/api/SIM/RegCharge?apiKey=cbe4df97-bca5-4d15-ac7f-5138d3455909&code='.$code.'&serial='.$serial.'&type='.$type.'&menhGia='.$menhGia.'&requestId='.$requestId;
           
            // Khởi tạo CURL
            $ch = curl_init($url);
             
            // Thiết lập có return
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            $result = curl_exec($ch);
            
            curl_close($ch);

            $rs = json_decode($result);
            
          
            if($rs->stt==1)
            {
                $this->session->set_flashdata('success', 'User updated successfully');
                $objTopup = array(
                    'req_id' => $requestId,
                    'card_vl' => $menhGia,
                    'card_code' => $code,
                    'card_seri' => $serial,
                    'telco' => $type,
                    'status' => 1,
                    'return_id' => $rs->data->id,
                    'uid' => $user_id,
                    'username' => $userInfo->username,
                );
                $this->user_model->addNewTopup($objTopup);

            }
            else
            {
                $this->session->set_flashdata('error', $rs->msg);
            }

            

            $data['userInfo'] = $this->user_model->getUserInfo($user_id);
           
            $this->global['pageTitle'] = 'Nạp thẻ điện thoại';
            redirect('recharge');
            $this->loadViews("recharge", $this->global, $data, NULL);

    }


    function send_gold($userRevId){
        $user_id = $this->session->userdata('userId');
        $data['userInfo'] = $this->user_model->getUserInfo($user_id);
        $this->global['pageTitle'] = 'Chuyển tiền người chơi';

        $recived = $this->user_model->getUserInfo($userRevId);
        $data['recived'] = $recived;
        $this->loadViews("send_gold", $this->global, $data, NULL);
    }

    function giftcode(){

        $this->global['pageTitle'] = 'Thêm mới giftcode';
        $this->loadViews("giftcode", $this->global, NULL, NULL);
    }

    function uploadgiftcode(){
        if($this->isAdmin() != TRUE)
        {
            $this->loadThis();
        }
        else
        {
            $this->load->model('user_model');
            $soluong = $this->security->xss_clean($this->input->post('soluong'));
            $menhGia = str_replace(',', '', $this->security->xss_clean($this->input->post('menhGia')));
                  
            for ($i=0; $i<$soluong ; $i++) { 
                $objGift = array(
                    'create_by_id' => 1,
                    'code' => $this->getName(10),
                    'value' => $menhGia,
                    'unit' => 'GOLD',
                    'status' => '1',
                );
                $this->user_model->addgiftcode($objGift);
            }
            if($result == true)
            {
                $this->session->set_flashdata('success', 'Tạo giftcode thành công');
            }
            else
            {
                $this->session->set_flashdata('error', 'User updation failed');
            }
            
            redirect('user/list_giftcode');
        }       
    }

    function list_giftcode(){
        if($this->isAdmin() != TRUE)
        {
            $this->loadThis();
        }
        else
        {        
            $searchText = $this->security->xss_clean($this->input->post('searchText'));
            $data['searchText'] = $searchText;
            
            $this->load->library('pagination');
            // echo "1";die();
            $count = $this->user_model->giftcodeListingCount($searchText);
            // echo "1";die();
            $returns = $this->paginationCompress ( "userListing/", $count, 200 );

            $data['userRecords'] = $this->user_model->giftcodeListing($searchText, $returns["page"], $returns["segment"]);
          
            $this->global['pageTitle'] = 'List GiftCode';
            
            $this->loadViews("list_giftcode", $this->global, $data, NULL);
        }
    }

    function excelgiftcode(){
        if($this->isAdmin() != TRUE)
        {
            $this->loadThis();
        }
        else
        {   
            $filename = 'giftcode.xls';
            $this->load->model('user_model');
            header("Content-Type: application/vnd.ms-excel");
            header("Content-Disposition: attachment; filename=\"$filename\"");

            $data = $this->user_model->giftcodeListingExcel();
           
            foreach ($data as $key => $value) {
                
                $arr[$key]['code'] = $value->code;
                $arr[$key]['value'] = $value->value;
                
            }
            $this->ExportFile($arr);
            exit();
        }
    }

    function testG(){
        $abc = '0372552050=0356527047=0931923486=0949969931=0356216473=0768539121=0961209208=0968085515=0366421468=0982123440=0335721205=0987038861=0789327174=0854478980=0889159688=0972333724=0917424995=0925261856=0984062356=0973013825=0336398156=0964381322=0707318054=0789376817=0981972502=0382843800=0976535683=0373342483=0981543575=0944931812=0977693518=0926347273=0792308021=0983839810=0866400173=0842045677=0933931874=0983473480=0961572521=0374279294=0968852934=0835089650=0378928422=0971268058=0376138487=0589509595=0797316730=0335314181=0925835905=0914361815=0977297531=0368145895=0359945193=0925039817=0372508336=0353077129=0896740403=0918110960=0363858511=0865159537=0965596846=0334654691=0942299261=0964276483=0368571056=0942150863=0798109998=0329724348=0345848972=0786820820=0945028135=0385768891=0334770074=0967147537=0945243960=0935885343=0966160655=0399937658=0352423678=0866192207=0769356323=0373548778=0776806832=0987723898=0905175670=0798385650=0798296671=0385595630=0356801792=0377887950=0589551197=0382437675=0798219094=0936905090=0794357738=0372027296=0375759345=0968124781=0981215214=0364362809=0967735762=0334288992=0785325080=0978883260=0582996714=0962352031=0948682187=0948055679=0905182524=0925779894=0921381030=0836495444=0969084268=0965319795=0587340316=0929612884=0768181339=0907668182=0789273900=0977363301=0903692320=0812005345=0868298428=0981706760=0965472072=0376476133=0762968068=0353321840=0393993363=0369309383=0935983661=0981757913=0903149914=0372771359=0972049033=0366029662=0352955071=0907644251=0931471351=0961549507=0795050172=0367999270=0915743230=0386900027=0988645603=0888205124=0817999973=0777818911=0345609003=0362040678=0967816376=0913007798=0364114732=0971839295=0974943656=0971097643=0336760932=0961731047=0348877847=0868676873=0983566028=0971757545=0983566028=0767611045=0375009645=0949669991=0362679141=0931460080=0904987572=0868955192=0399744993=0843250393=0372854633=0968872803=0362356949=0968032553=0911971691=0352955071=0966867608=0908704040=0375974481=0945148126=0926888252=0355023966=0386390792=0905933781=0964615060=0365557930=0386067839=0839393980=0961731047=0935885343=0978191408=0905416136=0941934252=0923904211=0915207105=0973372980=0379477824=0902582954=0868747484=0923135565=0933237983=0942786361=0777760097=0939748189=0762835804=0586040847=0338142580=0909708609=0793431232=0374019527=0818958279=0948142769=0961204290=0368311154=0397709043=0947298777=0326895900=0346880939=0925237370=0776508331=0369741029=0798400519=0374134581=0365449673=0333460608=0968348565=0769480444=0965616001=0936878240=0938297601=0868454494=0967283270=0938348392=0944097652=0944078345=0938009320=0944097652=0944078345=0353790138=0935391203=0349444943=0901399613=0905813671=0908038637=0936593717=0901367330=0976660942=0334560192=0327213365=0989577073=0982283511=0942363136=0818194404=0902596016=0963909582=0868492222=0968147055=0961211326=0782810234=0968603229=0868690437=0339831294=0949393958=0585302725=0944413823=0795768789=0926816169=0913295769=0987001643=0375622497=0975474167=0865239181=0869265698=098887449=0866839319=0917461793=0393702789=0385409135=0338119679=0965982230=0849667688=0963787149=0766902849=0383303795=0387023352=0988673227=0979968737=0901263928=0933154275=0918158732=0976712193=0779310874=0914294585=0765964998=0935185296=0869231662=0978324537=0399944312=0328695288=0889782585=0359147577=0938463361=0932395128=0836024585=0799714325=0383698890=0349722957=0963909847=0969590993=0823530835=0971240670=0369728221=0931141428=0397676985=0889763123=0923399567=0395335444=0326569222=0965954070=0979474520=0366708502=0962846846=0389777432=0399959869=0977166030=0922983626=0386629345=0528547587=0797271932=0945335310=0332570051=0989719866=0971043000=0839896648=0388125998=0971337649=0903306542=0767558231=0966811710=0777227306=0385841207=0797686137=0366239757=0917647732=0382021304=0976740468=0353416765=0923135565=0943131868=0961990441=0342414338=0903306542=0839896648=0931944165=0898462942=0972817490=0798380987=0967041061=0972727813=0963233530=0975881930=0386167576=0965399694=0898430092=0971497943=0776188217=0965375645=0976350801=0981038007=0848889979=0376072553=0326795325=0986258601=0916594212=0898488319=0587303246=0702059290=0971790419=0903466025=0908410616=0384782805=0904951085=0369927778=0909531857=0965547882=0918199489=0706367346=0397618333=0823058925=0367552455=0946240610=0774939007=0777268828=0382221462=0902907287=0985357601=0797992821=0357358239=0792699058=0586850536=0769323805=0987880230=0377776103=0836263680=0396310158=0385361218=0839351187=0939755469=0332244504=0385888437=0797576717=0971522763=0972691626=0935582176=0898797152=0824566489=0925825435=0949096170=0384564876=0971174619=0931179706=0906505211=0393881410=0848855020=0386167576=0975881930=0963233530=0977200541=0978699436=0822921043=0343452798=0869254785=0337183590=0868126757=0836049222=0388421477=0388421477=0963253526=0942494595=0962325279=0368322771=0703227532=0704716148=0986389892=0946564436=0793079024=0976112597=0364741689=0929690736=0901645771=0966967641=0904160494=0987656229=0942282703=0978324537=0948369108=0376566608=0898542972=0961841591=0395362865=0388125998=0866901309=0925237370=0379141373=0937114079=0857321129=0962673862=0912972295=0354349910=0964152536=0777319044=0965679752=0528325068=0937840616=0914447479=0972415542=0388260837=0916894905=0866780562=0343643697=0706636482=0935046424=0338800916=0389537811=0985020101=0946074023=0337183590=0975647438=0369208331=0384536418=0824533357=0363595487=0834728328=0931931485=0962245855=0938472820=0971966276=0987976213=0356690980=0904160494=0359491420=0989609369=0866730096=0774545946=0853209978=0818958279=0925859213=0342414338=0925859213=0937113088=0776807652=0968853657=0901506357=0818995601=0385005165=0359184067=0907341362=0866767940=0363813660=0987907700=0869757029=0964385280=0849667688=0977403169=0907644251=0868445800=0979365802=0357355986=0965303490=0826785468=0985319734=0867470392=0986071908=0965616001=0353940511=0869319795=0394234350=0989841988=0964935519=0353311687=0379261498=0988511660=0344445665=0333130972=0372484194=0971802500=0373369644=0975455820=0364393573=0971725418=0988911254=0985020101=0797783908=0382082108=0793726470=0393544982=0976551543=0817832444=0968819736=0908510951=0971140068=0979704504=0389429412=0911123291=0866839319=0932895147=0344710974=0366228200=0925825435=0937448029=0969375786=0387841996=0356720983=0963233142=0332474066=0822394516=0978699436=0962062486=0797576717=0348181490=0396310158=0917530260=0977809766=0582001016=0333748135=0971632987=0354845909=0776549197=0337880147=0943361691=0799620708=0989700897=0393951957=0926347273=0349800924=0818995601=0947855356=0901506357=0359184067=0385005165=0865941330=0984650007=0941862652=0398736016=0942861007=0702435745=0396862862=0339142642=0898747940=0904884884=0359147577=0947855356';

        $arrsdt = explode('=', $abc);
        $filename = 'giftcode.xls';
        $this->load->model('user_model');
        header("Content-Type: application/vnd.ms-excel");
        header("Content-Disposition: attachment; filename=\"$filename\"");

        $data = $this->user_model->giftcodeListingExcel();
        $i = 0;
        foreach ($arrsdt as $key => $value) {
            
            $cus[$i][0] = $value;
            $cus[$i][1] = $data[$key]->code;
            $i++;
        }
        $this->ExportFile($cus);
        exit();
    
            
        echo "<pre>";
        print_r($cus);
        die();
    }

    private function ExportFile($records) {
        $heading = false;
            if(!empty($records))
              foreach($records as $row) {
                
                if(!$heading) {
                  // display field/column names as a first row
                  echo implode("\t", array_keys($row)) . "\n";
                  $heading = true;
                }
                echo implode("\t ", array_values($row)) . "\n";
              }
            exit;
    }

    function reward(){
            
        $this->global['pageTitle'] = 'Đổi thuởng';
        // $data_the =
        $user_id = $this->session->userdata('userId');
        $data['userInfo'] = $this->user_model->getUserInfo($user_id);
        $sql = 'SELECT * FROM tbl_reward group by loaithe, gold';
        $data['rs'] = $this->db->query($sql)->result();
        $this->loadViews("reward", $this->global, $data, NULL);
    }

    function addreward(){
            
        $this->global['pageTitle'] = 'Đổi thuởng';
        // $data_the =
        $user_id = $this->session->userdata('userId');
        $searchText = $this->security->xss_clean($this->input->post('searchText'));
        
        $this->loadViews("reward", $this->global, $data, NULL);
    }

    function transactions(){
            
        $this->global['pageTitle'] = 'Danh sách giao dịch';
        // $data_the =
        $user_id = $this->session->userdata('userId');
        $searchText = $this->security->xss_clean($this->input->post('searchText'));
        $data['searchText'] = $searchText;
        $count = $this->user_model->transListingCount($user_id);
        $returns = $this->paginationCompress ( "transactions/", $count, 20);
      
        $rs = $this->user_model->transListing($user_id, $returns["page"], $returns["segment"]);

        foreach ($rs as $key => $value) {
            $rs[$key]->user_recived = $this->user_model->getUserInfo($value->recived);
        }        
        $data['rs'] = $rs;
        $this->loadViews("list_transaction", $this->global, $data, NULL);
    }

    function alltransaction(){
        
        $this->global['pageTitle'] = 'Danh sách giao dịch toàn hệ thống';
        
        $searchText = $this->security->xss_clean($this->input->post('searchText'));
        $data['searchText'] = $searchText;
        $count = $this->user_model->transListingCount(0);
        $returns = $this->paginationCompress ( "transactions/", $count, 20);
      
        $rs = $this->user_model->transListing(0, $returns["page"], $returns["segment"]);

        foreach ($rs as $key => $value) {
            $rs[$key]->user_recived = $this->user_model->getUserInfo($value->recived);
            $rs[$key]->user_send = $this->user_model->getUserInfo($value->sender);
        }        
        $data['rs'] = $rs;
        $this->loadViews("all_trans", $this->global, $data, NULL);
    }

    function recived(){
            
        $this->global['pageTitle'] = 'Danh sách giao dịch nhận';
        // $data_the =
        $user_id = $this->session->userdata('userId');
        $searchText = $this->security->xss_clean($this->input->post('searchText'));
        $data['searchText'] = $searchText;
        $count = $this->user_model->RecListingCount($user_id);
        $returns = $this->paginationCompress ( "recived/", $count, 20);
      
        $rs = $this->user_model->RecListing($user_id, $returns["page"], $returns["segment"]);

        foreach ($rs as $key => $value) {
            $rs[$key]->user_recived = $this->user_model->getUserInfo($value->sender);
        }        
        $data['rs'] = $rs;
        $this->loadViews("list_transaction", $this->global, $data, NULL);
    }

    function addthe(){
         if($this->isAdmin() != TRUE)
        {
            $this->loadThis();
        }
        else
        {
            $this->global['pageTitle'] = 'Thêm thẻ điện thoại';
            $data = array();
            $this->loadViews("addthe", $this->global, $data, NULL);
        }
    }

    function addchat(){
        if($this->isAdmin() != TRUE)
        {
            $this->loadThis();
        }
        else
        {
            $this->global['pageTitle'] = 'Thêm nội dung chat';
            $data = array();
            $this->loadViews("addchat", $this->global, $data, NULL);
        }
    }

    function updatechat(){
        if($this->isAdmin() != TRUE)
        {
            $this->loadThis();
        }
        else
        {
            $chat = $this->security->xss_clean($this->input->post('chat'));
            $userInfo = array('chat'=>$chat);               
            $this->load->model('user_model');
            $result = $this->user_model->addChat($userInfo);
            $this->global['pageTitle'] = 'Thêm nội dung chat';
            if($result > 0)
            {
                $this->session->set_flashdata('success', 'New User created successfully');
            }
            else
            {
                $this->session->set_flashdata('error', 'User creation failed');
            }
            redirect('user/addchat');
        }
    }

    function listchat(){
        if($this->isAdmin() != TRUE)
        {
            $this->loadThis();
        }
        else
        {
           
          
            $rs = $this->user_model->listchat();

               
            $data['rs'] = $rs;
            $this->loadViews("listchat", $this->global, $data, NULL);
        }
    }

    function addTransactions(){
            
        $this->load->library('form_validation');
             
        $userId = $this->session->userdata('userId');
        $amount = str_replace(',', '', $this->security->xss_clean($this->input->post('amount')));
        $recived = str_replace(',', '', $this->security->xss_clean($this->input->post('recived')));
        $note = $this->security->xss_clean($this->input->post('note'));
        
        $rs_recived = $this->user_model->getUserInfo($recived);
        $userInfo = $this->user_model->getUserInfo($userId);
        $gold_hientai = $userInfo->gold;
        $chenh = $amount - $gold_hientai;
        
        if($chenh>0){
           
            $this->session->set_flashdata('error', 'Gold lớn hơn hiện có');
            redirect('send_gold/'.$recived);
        }
        else
        {
            //update bang transaction
            $transObj = array(
                'sender' => $userId,
                'recived' => $recived,
                'amount' => $amount,
                'status' => 0,
                'current_amount_sender' => $userInfo->gold,
                'current_amount_reciver' => $rs_recived->gold,
                'note' => $note,
            );
            $this->user_model->addLogTrans($transObj);

            //Update tieenf nguoi chuyen
            $flushObj = array(
                'username' => $userInfo->username,
                'flush_type' => 'GOLD',
                'value' => 0-$amount,
            );
            $this->user_model->updateGold($flushObj);

            //update gold nguoi nhan
            $flushObj2 = array(
                'username' => $rs_recived->username,
                'flush_type' => 'GOLD',
                'value' => $amount,
            );
            $this->user_model->updateGold($flushObj2);
            $this->session->set_flashdata('success', 'Chuyen tien thanh cong');
           redirect('send_gold/'.$recived);
        }
        
        
    }
    

    function createSession(){
        for ($i=0; $i < 500 ; $i++) { 
            $flushObj = array(
                'session' => $i + 149410,
                'money_xiu' => rand(16000000,24000000),
                'money_tai' => rand(16000000,24000000),
                'num_tai' => rand(40,70),
                'num_xiu' => rand(40,70),
            );
            $this->db->trans_start();
            $this->db->insert('tbl_faketx', $flushObj);
            $insert_id = $this->db->insert_id();
        
            $this->db->trans_complete();
            echo $insert_id.'<br>';

        }
        die();
    }

    function getName($n) { 
        $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ'; 
        $randomString = ''; 
      
        for ($i = 0; $i < $n; $i++) { 
            $index = rand(0, strlen($characters) - 1); 
            $randomString .= $characters[$index]; 
        } 
      
        return $randomString; 
    } 

}

?>