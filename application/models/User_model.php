<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Class : User_model (User Model)
 * User model class to get to handle user related data 
 * @author : Kishor Mali
 * @version : 1.1
 * @since : 15 November 2016
 */
class User_model extends CI_Model
{
    /**
     * This function is used to get the user listing count
     * @param string $searchText : This is optional search text
     * @return number $count : This is row count
     */
    function userListingCount($searchText = '')
    {
        $this->db->select('BaseTbl.id, BaseTbl.username, BaseTbl.nickname, BaseTbl.phone, BaseTbl.gold, BaseTbl.user_type');
        $this->db->from('users as BaseTbl');        
        if(!empty($searchText)) {
            $likeCriteria = "(BaseTbl.username  LIKE '%".$searchText."%'
                            OR  BaseTbl.nickname  LIKE '%".$searchText."%'
                            OR  BaseTbl.nickname  LIKE '%".$searchText."%'
                            OR  BaseTbl.phone  LIKE '%".$searchText."%')";
            $this->db->where($likeCriteria);
        }
        // $this->db->where('BaseTbl.isDeleted', 0);
        // $this->db->where('BaseTbl.roleId !=', 1);
        $query = $this->db->get();
        
        return $query->num_rows();
    }

    function getKeyConfig($xkey = ''){
        $this->db->select('value');
        $this->db->from('tbl_config as BaseTbl');        
        if(!empty($xkey)) {
            $likeCriteria = "BaseTbl.xkey  LIKE '%".$xkey."%'";
            $this->db->where($likeCriteria);
        }
        
        $query = $this->db->get(); 
        
        return $query->row();
    }

    function getKeyConfigById($id = 0){
         $this->db->select('*');
        $this->db->from('tbl_config');
        $this->db->where('id', $id);
        $query = $this->db->get();
        
        return $query->row();
    }

    function dailyListingCount($searchText = '')
    {
        $this->db->select('BaseTbl.id, BaseTbl.username, BaseTbl.nickname, BaseTbl.phone, BaseTbl.gold, BaseTbl.user_type');
        $this->db->from('users as BaseTbl');        
        if(!empty($searchText)) {
            $likeCriteria = "(BaseTbl.username  LIKE '%".$searchText."%'
                            OR  BaseTbl.nickname  LIKE '%".$searchText."%'
                            OR  BaseTbl.nickname  LIKE '%".$searchText."%'
                            OR  BaseTbl.phone  LIKE '%".$searchText."%')";
            $this->db->where($likeCriteria);
        }
        $this->db->where('BaseTbl.user_type', 2);
        // $this->db->where('BaseTbl.roleId !=', 1);
        $query = $this->db->get();
        
        return $query->num_rows();
    }
    
    /**
     * This function is used to get the user listing count
     * @param string $searchText : This is optional search text
     * @param number $page : This is pagination offset
     * @param number $segment : This is pagination limit
     * @return array $result : This is result
     */
   

    function dailyListing($searchText = '', $page, $segment)
    {
        $this->db->select('BaseTbl.id, BaseTbl.username, BaseTbl.nickname, BaseTbl.phone, BaseTbl.gold, BaseTbl.user_type');
        $this->db->from('users as BaseTbl');        
        if(!empty($searchText)) {
            $likeCriteria = "(BaseTbl.username  LIKE '%".$searchText."%'
                            OR  BaseTbl.nickname  LIKE '%".$searchText."%'
                            OR  BaseTbl.nickname  LIKE '%".$searchText."%'
                            OR  BaseTbl.phone  LIKE '%".$searchText."%')";
            $this->db->where($likeCriteria);
        }
        $this->db->where('BaseTbl.user_type', 2);
        $this->db->order_by('BaseTbl.id', 'DESC');
        $this->db->limit($page, $segment);
        $query = $this->db->get();
        
        $result = $query->result();        
        return $result;
    }
    
    function userListing($searchText = '', $page, $segment)
    {
        $this->db->select('BaseTbl.id, BaseTbl.username, BaseTbl.nickname, BaseTbl.phone, BaseTbl.gold, BaseTbl.user_type');
        $this->db->from('users as BaseTbl');        
        if(!empty($searchText)) {
            $likeCriteria = "(BaseTbl.username  LIKE '%".$searchText."%'
                            OR  BaseTbl.nickname  LIKE '%".$searchText."%'
                            OR  BaseTbl.nickname  LIKE '%".$searchText."%'
                            OR  BaseTbl.phone  LIKE '%".$searchText."%')";
            $this->db->where($likeCriteria);
        }
        $this->db->order_by('BaseTbl.id', 'DESC');
        $this->db->limit($page, $segment);
        $query = $this->db->get();
        
        $result = $query->result();        
        return $result;
    }
    /**
     * This function is used to get the user roles information
     * @return array $result : This is result of the query
     */
    function getUserRoles()
    {
        $this->db->select('*');
        $this->db->from('tbl_roles');
        $this->db->where('roleId !=', 3);
        $query = $this->db->get();
        
        return $query->result();
    }

    /**
     * This function is used to check whether email id is already exist or not
     * @param {string} $email : This is email id
     * @param {number} $userId : This is user id
     * @return {mixed} $result : This is searched result
     */
    function checkEmailExists($email, $userId = 0)
    {
        $this->db->select("email");
        $this->db->from("tbl_users");
        $this->db->where("email", $email);   
        $this->db->where("isDeleted", 0);
        if($userId != 0){
            $this->db->where("userId !=", $userId);
        }
        $query = $this->db->get();

        return $query->result();
    }

    function checkUsernamelExists($username, $userId = 0)
    {
        $this->db->select("username");
        $this->db->from("users");
        $this->db->where("username", $username);   
        if($userId != 0){
            $this->db->where("userId !=", $userId);
        }
        $query = $this->db->get();

        return $query->result();
    }
    
    
    /**
     * This function is used to add new user to system
     * @return number $insert_id : This is last inserted id
     */
    function addNewUser($userInfo)
    {
        $this->db->trans_start();
        $this->db->insert('users', $userInfo);
        
        $insert_id = $this->db->insert_id();
        
        $this->db->trans_complete();
        
        return $insert_id;
    }
    
    /**
     * This function used to get user information by id
     * @param number $userId : This is user id
     * @return array $result : This is user information
     */
    function getUserInfo($userId)
    {
        $this->db->select('*');
        $this->db->from('users');
        // $this->db->where('isDeleted', 0);
		// $this->db->where('roleId !=', 1);
        $this->db->where('id', $userId);
        $query = $this->db->get();
        
        return $query->row();
    }
    
    
    /**
     * This function is used to update the user information
     * @param array $userInfo : This is users updated information
     * @param number $userId : This is user id
     */
    function editUser($userInfo, $userId)
    {
        $this->db->where('id', $userId);
        $this->db->update('users', $userInfo);
        
        return TRUE;
    }
    
    
    
    /**
     * This function is used to delete the user information
     * @param number $userId : This is user id
     * @return boolean $result : TRUE / FALSE
     */
    function deleteUser($userId, $userInfo)
    {
        $this->db->where('userId', $userId);
        $this->db->update('tbl_users', $userInfo);
        
        return $this->db->affected_rows();
    }


    /**
     * This function is used to match users password for change password
     * @param number $userId : This is user id
     */
    function matchOldPassword($userId, $oldPassword)
    {
        $this->db->select('userId, password');
        $this->db->where('userId', $userId);        
        $this->db->where('isDeleted', 0);
        $query = $this->db->get('tbl_users');
        
        $user = $query->result();

        if(!empty($user)){
            if(verifyHashedPassword($oldPassword, $user[0]->password)){
                return $user;
            } else {
                return array();
            }
        } else {
            return array();
        }
    }
    
    /**
     * This function is used to change users password
     * @param number $userId : This is user id
     * @param array $userInfo : This is user updation info
     */
    function changePassword($userId, $userInfo)
    {
        $this->db->where('userId', $userId);
        $this->db->where('isDeleted', 0);
        $this->db->update('tbl_users', $userInfo);
        
        return $this->db->affected_rows();
    }


    /**
     * This function is used to get user login history
     * @param number $userId : This is user id
     */
    function loginHistoryCount($userId, $searchText, $fromDate, $toDate)
    {
        $this->db->select('BaseTbl.userId, BaseTbl.sessionData, BaseTbl.machineIp, BaseTbl.userAgent, BaseTbl.agentString, BaseTbl.platform, BaseTbl.createdDtm');
        if(!empty($searchText)) {
            $likeCriteria = "(BaseTbl.sessionData LIKE '%".$searchText."%')";
            $this->db->where($likeCriteria);
        }
        if(!empty($fromDate)) {
            $likeCriteria = "DATE_FORMAT(BaseTbl.createdDtm, '%Y-%m-%d' ) >= '".date('Y-m-d', strtotime($fromDate))."'";
            $this->db->where($likeCriteria);
        }
        if(!empty($toDate)) {
            $likeCriteria = "DATE_FORMAT(BaseTbl.createdDtm, '%Y-%m-%d' ) <= '".date('Y-m-d', strtotime($toDate))."'";
            $this->db->where($likeCriteria);
        }
        if($userId >= 1){
            $this->db->where('BaseTbl.userId', $userId);
        }
        $this->db->from('tbl_last_login as BaseTbl');
        $query = $this->db->get();
        
        return $query->num_rows();
    }

    /**
     * This function is used to get user login history
     * @param number $userId : This is user id
     * @param number $page : This is pagination offset
     * @param number $segment : This is pagination limit
     * @return array $result : This is result
     */
    function loginHistory($userId, $searchText, $fromDate, $toDate, $page, $segment)
    {
        $this->db->select('BaseTbl.userId, BaseTbl.sessionData, BaseTbl.machineIp, BaseTbl.userAgent, BaseTbl.agentString, BaseTbl.platform, BaseTbl.createdDtm');
        $this->db->from('tbl_last_login as BaseTbl');
        if(!empty($searchText)) {
            $likeCriteria = "(BaseTbl.sessionData  LIKE '%".$searchText."%')";
            $this->db->where($likeCriteria);
        }
        if(!empty($fromDate)) {
            $likeCriteria = "DATE_FORMAT(BaseTbl.createdDtm, '%Y-%m-%d' ) >= '".date('Y-m-d', strtotime($fromDate))."'";
            $this->db->where($likeCriteria);
        }
        if(!empty($toDate)) {
            $likeCriteria = "DATE_FORMAT(BaseTbl.createdDtm, '%Y-%m-%d' ) <= '".date('Y-m-d', strtotime($toDate))."'";
            $this->db->where($likeCriteria);
        }
        if($userId >= 1){
            $this->db->where('BaseTbl.userId', $userId);
        }
        $this->db->order_by('BaseTbl.id', 'DESC');
        $this->db->limit($page, $segment);
        $query = $this->db->get();
        
        $result = $query->result();        
        return $result;
    }

    /**
     * This function used to get user information by id
     * @param number $userId : This is user id
     * @return array $result : This is user information
     */
    function getUserInfoById($userId)
    {
        $this->db->select('*');
        $this->db->from('users');
        // $this->db->where('isDeleted', 0);
        $this->db->where('id', $userId);
        $query = $this->db->get();
        
        return $query->row();
    }

    /**
     * This function used to get user information by id with role
     * @param number $userId : This is user id
     * @return aray $result : This is user information
     */
    function getUserInfoWithRole($userId)
    {
        $this->db->select('BaseTbl.userId, BaseTbl.email, BaseTbl.name, BaseTbl.mobile, BaseTbl.roleId, Roles.role');
        $this->db->from('tbl_users as BaseTbl');
        $this->db->join('tbl_roles as Roles','Roles.roleId = BaseTbl.roleId');
        $this->db->where('BaseTbl.userId', $userId);
        $this->db->where('BaseTbl.isDeleted', 0);
        $query = $this->db->get();
        
        return $query->row();
    }

    //Log
    function userLogs($searchText = '', $game_id, $page, $segment)
    {
        $this->db->select('*');
        $this->db->from('logs');        
        if(!empty($searchText)) {

            $likeCriteria = "(username  LIKE '%".$searchText."%')";
            $this->db->where($likeCriteria);
            if($game_id != 0){
                $this->db->where(' gameId = '.$game_id);    
            }
            // $this->db->where(' userId >0 ');
        }else{

            if($game_id != 0){
                $this->db->where(' gameId = '.$game_id);    
            }
            // $this->db->where('userId >0 ');
        }
       
        $this->db->order_by('id', 'DESC');
        $this->db->limit($page, $segment);
        $query = $this->db->get();
        
        $result = $query->result();        
        return $result;
    }


    function userLogsCount($searchText = '', $game_id)
    {
        $this->db->select('id');
        $this->db->from('logs');        
        if(!empty($searchText)) {

            $likeCriteria = "(username  LIKE '%".$searchText."%')";
            $this->db->where($likeCriteria);
            if($game_id != 0){
                $this->db->where('gameId = '.$game_id);    
            }
            // $this->db->where('userId >0 ');
        }else{
            if($game_id != 0){
                $this->db->where(' AND gameId = '.$game_id);    
            }
            // $this->db->where('userId >0 ');
        }
       
        // $this->db->where('BaseTbl.roleId !=', 1);
        $query = $this->db->get();
        
        return $query->num_rows();
    }
    
    function addNewLog($logs)
    {
        $this->db->trans_start();
        $this->db->insert('tbl_dw_logs', $logs);
        
        $insert_id = $this->db->insert_id();
        
        $this->db->trans_complete();
        
        return $insert_id;
    }

    function updateConfigByxKey($config_info, $xkey){
        $this->db->where('xkey', $xkey);
        $this->db->update('tbl_config', $config_info);
        
        return TRUE;
    }

    function updateConfigById($config_info, $id){
        $this->db->where('id', $id);
        $this->db->update('tbl_config', $config_info);
        
        return TRUE;
    }

    //lịch sử thay đổi hũ
    function logsListingCount()
    {
        $this->db->select('id');
        $this->db->from('tbl_dw_logs');                
        $query = $this->db->get();
        return $query->num_rows();
    }
    
    /**
     * This function is used to get the user listing count
     * @param string $searchText : This is optional search text
     * @param number $page : This is pagination offset
     * @param number $segment : This is pagination limit
     * @return array $result : This is result
     */
    function logsListing($page, $segment)
    {
        $this->db->select('*');
        $this->db->from('tbl_dw_logs');        
        $this->db->order_by('id', 'DESC');
        $this->db->limit($page, $segment);
        $query = $this->db->get();
        $result = $query->result();        
        return $result;
    }


    function configListing()
    {
        $this->db->select('*');
        $this->db->from('tbl_config');        
        $query = $this->db->get();
        $result = $query->result();        
        return $result;
    }

    function updateGold($logs)
    {
        $this->db->trans_start();
        $this->db->insert('server_flush', $logs);
        
        $insert_id = $this->db->insert_id();
        
        $this->db->trans_complete();
        
        return $insert_id;
    }

    function addNewTopup($logs)
    {
        $this->db->trans_start();
        $this->db->insert('topup', $logs);
        
        $insert_id = $this->db->insert_id();
        
        $this->db->trans_complete();
        
        return $insert_id;
    }

    // function giftcodeListing()
    // {
    //     $this->db->select('*');
    //     $this->db->from('gift_code');        
    //     $query = $this->db->get();
    //     $result = $query->result();        
    //     return $result;
    // }

    function addgiftcode($logs)
    {
        $this->db->trans_start();
        $this->db->insert('gift_code', $logs);
        
        $insert_id = $this->db->insert_id();
        
        $this->db->trans_complete();
        
        return $insert_id;
    }

    function giftcodeListing($searchText = '', $page, $segment)
    {
        $this->db->select('*');
        $this->db->from('gift_code');        
        // if(!empty($searchText)) {
        //     $likeCriteria = "(BaseTbl.username  LIKE '%".$searchText."%'
        //                     OR  BaseTbl.nickname  LIKE '%".$searchText."%'
        //                     OR  BaseTbl.nickname  LIKE '%".$searchText."%'
        //                     OR  BaseTbl.phone  LIKE '%".$searchText."%')";
        //     $this->db->where($likeCriteria);
        // }
        $this->db->order_by('id', 'DESC');
        $this->db->limit($page, $segment);
        $query = $this->db->get();
        
        $result = $query->result();        
        return $result;
    }

    

    function giftcodeListingExcel()
    {
        $this->db->select('*');
        $this->db->from('gift_code');
        $this->db->where('status',1);     
        $this->db->order_by('id', 'DESC');       
        $query = $this->db->get();
        
        $result = $query->result();        
        return $result;
    }

    function giftcodeListingCount($searchText = '')
    {
        $this->db->select('id');
        $this->db->from('gift_code');       
        // if(!empty($searchText)) {
        //     $likeCriteria = "(BaseTbl.username  LIKE '%".$searchText."%'
        //                     OR  BaseTbl.nickname  LIKE '%".$searchText."%'
        //                     OR  BaseTbl.nickname  LIKE '%".$searchText."%'
        //                     OR  BaseTbl.phone  LIKE '%".$searchText."%')";
        //     $this->db->where($likeCriteria);
        // }
        // $this->db->where('BaseTbl.user_type', 2);
        // $this->db->where('BaseTbl.roleId !=', 1);
        $query = $this->db->get();
        
        return $query->num_rows();
    }


    function transListingCount( $userId)
    {
        $this->db->select('*');
        $this->db->from('trans_log');
        if($userId>0){
            $this->db->where('sender', $userId);   
        }    
             
        $this->db->order_by('id', 'DESC');
        $query = $this->db->get();        
        return $query->num_rows();
    }

    function RecListingCount( $userId)
    {
        $this->db->select('*');
        $this->db->from('trans_log');        
        $this->db->where('recived', $userId);        
        $this->db->order_by('id', 'DESC');
        $query = $this->db->get();        
        return $query->num_rows();
    }
    
    /**
     * This function is used to get the user listing count
     * @param string $searchText : This is optional search text
     * @param number $page : This is pagination offset
     * @param number $segment : This is pagination limit
     * @return array $result : This is result
     */
   
    function RecListing($userId, $page, $segment)
    {
        $this->db->select('*');
        $this->db->from('trans_log');        
        $this->db->where('recived', $userId);        
        $this->db->order_by('id', 'DESC');
        $this->db->limit($page, $segment);
        $query = $this->db->get();  
        $result = $query->result();        
        return $result;
    }
    function transListing($userId, $page, $segment)
    {
        $this->db->select('*');
        $this->db->from('trans_log');
        if($userId>0){
            $this->db->where('sender', $userId);   
        }            
        $this->db->order_by('id', 'DESC');
        $this->db->limit($page, $segment);
        $query = $this->db->get();  
        $result = $query->result();        
        return $result;
    }
//listchat
    function listchat()
    {
        $this->db->select('*');
        $this->db->from('tbl_chat_fake');
        $query = $this->db->get();  
        $result = $query->result();        
        return $result;
    }

    function addLogTrans($logs)
    {
        $this->db->trans_start();
        $this->db->insert('trans_log', $logs);
        
        $insert_id = $this->db->insert_id();
        
        $this->db->trans_complete();
        
        return $insert_id;
    }

    function addChat($logs)
    {
        $this->db->trans_start();
        $this->db->insert('tbl_chat_fake', $logs);
        
        $insert_id = $this->db->insert_id();
        
        $this->db->trans_complete();
        
        return $insert_id;
    }

}

  