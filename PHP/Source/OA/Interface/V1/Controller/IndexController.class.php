<?php

namespace V1\Controller;
use Common\Controller\ApiController;

class IndexController extends ApiController {
    
    // 不验证token
    protected function _initialize() {
    }
    
    public function index(){
        $code  = http_response_code();
        echo $this ->jsonPrint('无效接口',$code,false);exit;
    }
    
    function  login() {
        
        $data['code'] = http_response_code();//php5.4版本以上
        $data['result'] = false;
        $data['msg'] = '';
        
        if (IS_POST) {
 
            // 判断当前登录的用户和密码是否正确
            $post = I('post.');
            $userInfo = array (
                'username' => $post['username'],
                'password' => md5($post['password']),
            );
            $model = D('User');
            $result = $model ->field("username,nickname,truename,id,tel,birthday,sex,role_id,token") 
                    ->where($userInfo) 
                    ->find();
            
            if ($result) { // 登录成功
                $updateInfo['deadline']=time()+7*24*3600;//token过期时间
                $updateInfo['token']=createstring(16);
                $updateInfo['client_ip']=get_client_ip($type = 0, $adv = true);//$type 0 返回IP地址 1 返回IPV4地址数字
              
                // 保存到数据库中
                $model -> where('id='.$result['id']) -> save($updateInfo);
                
                $data['msg']='登录成功';
                $data['result']=true;
                
                $data['data'] = $result;
                echo json_encode($data);exit; 
            } else { // 登录失败
                $data['msg'] = '未受理请求';
                echo json_encode($data);exit; 
            }
            

        } else {
            $data['msg']='请求错误';
            echo json_encode($data);exit;
        }
    }
    
    function register() {
        
        $data['code'] = http_response_code();//php5.4版本以上
        $data['result'] = false;
        $data['msg'] = '';
        
        if(IS_POST) {
            $post = I('post.');
            $phone = $post['username'];
            $password = md5($post['password']);
            $post['password'] = $password;
            $post['nickname'] = '';
            $post['truename'] = '';
            $post['sex'] = '保密';
            $post['birthday'] = date('Y-m-d H:i:s', time());
            $post['tel'] = $phone;
            $post['email'] = '';
            if (empty($phone)) {
                $data['msg']='手机号不能为空'; 
                echo json_encode($data);exit;
                
            }
            if (empty($password)){ 
                $data['msg']='密码不能为空'; 
                echo json_encode($data);exit;
                
            }
            if (strlen($password) < 6) {
                $data['msg']='密码长度不能小于6位'; 
                echo json_encode($data);exit;
            }
            if (strlen($password) > 32) {
                $data['msg']='密码长度不能大于32位'; 
            echo json_encode($data);exit;
            
            }
            $model = D('User');
            $result = $model->where('username='.$phone) ->find();
            if ($result) { //账户已注册过
                $data['msg']='您的账户已注册过'; echo json_encode($data);exit;
            } else {
                $result = $model ->add($post);
                if ($result) {
                    $data['result'] = true;
                    $data['msg']='注册成功'; 
                    echo json_encode($data);exit;
                }else {
                    $data['msg']='信息未受理'; 
                    echo json_encode($data);exit;
                }
            }
            
        } else {
            $data['msg']='请求错误';
            echo json_encode($data);exit; 
        }
    }
    
    function sendCode() {
        
        
        if (IS_POST) {
            $phone=I("post.phone");

            //查找是否已经注册
            $user = D('User') -> where("tel = {$phone}") -> find();
            if ($user) { // 该手机已经注册过了

            }else{
                $this->send_phone($phone);
            }
        }
 

    }
    
    /**
     * 生成短信验证码
     * @param  integer $length [验证码长度]
     */
    public function createSMSCode($length = 4){
        $min = pow(10 , ($length - 1));
        $max = pow(10, $length) - 1;
        return rand($min, $max);
    }


    /**
     * 发送验证码
     * @param  [integer] $phone [手机号]
     */
    public function send_phone($phone){
        $code=$this->createSMSCode($length = 4);
        vendor('AliyunSms.AliyunSmsTool');
        $cfg = array (
            'signName' => '',       // 短信的签名
            'templateCode' => '',   // 短信模板代码
            'accessKeyId' => '',
            'accessKeySecret' => ''
        );
        $content = array (
            'code' => $code, // 模板中可替换的内容
        );
        $result = \AliyunSmsTool::sendSms('13800000000',$cfg,$content);
        $resp = $result['Code'];
        $this->sendMsgResult($resp,$phone,$code);
    }


    /**
     * 验证手机号是否发送成功  前端用ajax，发送成功则提示倒计时，如50秒后可以重新发送
     * @param  [json] $resp  [发送结果]
     * @param  [type] $phone [手机号]
     * @param  [type] $code  [验证码]
     * @return [type]        [description]
     */
    private function sendMsgResult($resp,$phone,$code){
        if ($resp == "OK") { // 短信验证码发送成功
            // 保存到当前的数据数据库中
            $data['phone']=$phone;
            $data['code']=$code;
            $data['send_time']=time();
            $result=D("Smsverif")->add($data);
            if($result){
                $data="发送成功";
            }else{
                $data="发送失败";
            }
        } else{
            $data="发送失败";
        }
        return $data;
    }


    /**
     * 验证短信验证码是否有效,前端用jquery validate的remote
     * @return [type] [description]
     */
    public function checkSMSCode(){
        $phone = $_POST['phone'];
        $code = $_POST['verify'];
        $nowTimeStr = time();
        $smscodeObj = D("Smsverif")->where("phone={$phone} and code = {$code}")->find();
        if($smscodeObj){
            $smsCodeTimeStr = $smscodeObj['send_time'];
            $recordCode = $smscodeObj['code'];
            $flag = $this->checkTime($nowTimeStr, $smsCodeTimeStr);
            if($flag!=true || $code !== $recordCode){
                echo 'no';
            }else{
                echo 'ok';
            }
        }
    }


    /**
     * 验证验证码是否在可用时间
    *  @param  [json] $nowTimeStr  [发送结果]
     * @param  [type] $smsCodeTimeStr [手机号]
     */
    public function checkTime ($nowTimeStr,$smsCodeTimeStr) {
        $time = $nowTimeStr - $smsCodeTimeStr;
        if ($time>900) {
            return false;
        }else{
            return true;
        }
    }
}