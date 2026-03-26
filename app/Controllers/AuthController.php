<?php
namespace App\Controllers;
use App\Models\UsersregistrationsModel;
use App\Models\PasswordresetModel;
class AuthController extends BaseController
{
    protected $usersregistrationsModel;
    protected $passwordresetModel;
    function __construct() {
        $this->usersregistrationsModel = new UsersregistrationsModel();
        $this->passwordresetModel = new PasswordresetModel();
    }
    public function userLogin() {
        $page ='Login';
        return view('frontend/login',compact('page'));
    }
     public function createAccount() {
        $page ='Create New Account';
        return view('frontend/register',compact('page'));
    }
    public function register()
    {
        if(!$this->request->isAJAX()){
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Invalid request',
            ]);
        }
        $rules = [
            'name' => 'required|min_length[2]',
            'email' => 'required|valid_email|is_unique[usersregistrations.email]',
            'phone' => 'required|numeric|exact_length[10]|is_unique[usersregistrations.phone]',
            'password' => 'required|min_length[6]|max_length[50]',
            'reviewcheck'   => 'required'
        ];
        if(!$this->validate($rules)){
            return $this->response->setJSON([
                'success' => false,
                'errors' => $this->validator->getErrors(),
            ]);
        }

        $data = [
            'name' => $this->request->getPost('name'),
            'email' => $this->request->getPost('email'),
            'phone' => $this->request->getPost('phone'),
            'password' => password_hash($this->request->getPost('password'),PASSWORD_DEFAULT)
        ];
        $userModel = new UsersregistrationsModel();
        if($userModel->insert($data)){
            session()->set('user', [
                'isLoggedIn' => true,
                'userId' => $userModel->insertID(),
                'name' => $data['name'],
                'email' => $data['email'],
                'phone' => $data['phone'],
            ]);
            //check ani items in his cart 

            return $this->response->setJSON([
                'success' => true,
                'message' => 'User registered successfully',
                'url' => base_url('checkout')
            ]);
        }
        return $this->response->setJSON([
            'success' => false,
            'message' => 'User registration failed',
        ]);
    }
    public function login()
    {
        if(!$this->request->isAJAX()){
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Invalid request',
            ]);
        }
        $rules = [
            'username' => 'required',
            'pwd' => 'required|min_length[6]|max_length[50]',
        ];
        if(!$this->validate($rules)){
            return $this->response->setJSON([
                'success' => false,
                'errors' => $this->validator->getErrors(),
            ]);
        }
        $userModel = new UsersregistrationsModel();
        $user = $userModel->where('email', $this->request->getPost('username'))->orWhere('phone', $this->request->getPost('username'))->first();
        if($user){
            if(password_verify($this->request->getPost('pwd'), $user['password'])){
                if($user['status'] ==0) {
                    return $this->response->setJSON([
                        'success' => false,
                        'errors' => ['pwd' => 'Your Account is Blocked Please contact to Our team'],
                    ]);
                }
                session()->set('user', [
                    'isLoggedIn' => true,
                    'userId' => $user['id'],
                    'name' => $user['name'],
                    'email' => $user['email'],
                    'phone' => $user['phone'],
                ]);
                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'User logged in successfully',
                    'url' => base_url('checkout')
                ]);
            }else{
                return $this->response->setJSON([
                    'success' => false,
                    'errors' => ['pwd' => 'Invalid password'],
                ]);
            }
        }else{
            return $this->response->setJSON([
                'success' => false,
                'errors' => ['username' => 'Invalid username'],
            ]);
        }
        return $this->response->setJSON([
            'success' => false,
            'message' => 'Invalid username or password',
        ]);
    }

    public function forgotPassword() {
        $page = "Forgot Password";
        return view('frontend/forgot-password',compact('page'));
    }

    public function emielVerify() {
        $emailService = \Config\Services::email();
        $rules = [
            'username' => 'required',
        ];
        if(!$this->validate($rules)){
            return $this->response->setJSON([
                'success' => false,
                'errors' => $this->validator->getErrors(),
            ]);
        }
        $userModel = new UsersregistrationsModel();
        $user = $userModel->where('email', $this->request->getPost('username'))->first();
        $token = bin2hex(random_bytes(32));

        if($user){
            $otp = rand(100000, 999999);
           // $userModel->update($user['id'], ['otp' => $otp]);
            $email = $this->request->getPost('username');
            $subject = "Reset Password";
            //some deyaild text
            $message = "<p>Dear User,</p>
            <p>You have requested to reset your password. Please use the OTP below to reset your password.</p>
            <p>OTP: " . $otp . "</p>
            <p>This OTP will expire in 10 minutes.</p>
            <p>Thank you,</p>
            <p>Robin Food</p>";
            $emailService->setTo($email);
            $emailService->setSubject($subject);
            $emailService->setMessage($message);

            $this->passwordresetModel->insert([
                'user_id' => $user['id'],
                'email' => $email,
                'token' => $token,
                'otp'   => $otp,
                'expires_at' => date('Y-m-d H:i:s', strtotime('+10 minutes')),
                'created_at' => date('Y-m-d H:i:s'),
                'used' => 0
            ]);
            session()->set('reset_email', $email);
            if($emailService->send()){
                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'OTP sent successfully',
                    'url' => base_url('otp-verification')
                ]);
            }else{
                return $this->response->setJSON([
                    'success' => false,
                    'errors' => ['username'=> 'OTP not sent'],
                    'message' => 'OTP not sent',
                ]);
            }
        }else{
            return $this->response->setJSON([
                'success' => false,
                'errors' => ['username'=> 'User not found'],
                'message' => 'User not found',
            ]);
        }
    }

    public function otppage() {
        if(!session()->get('reset_email')){
            return redirect()->to(base_url('forgot-password'));
        }
        $page = "OTP Verification";
        return view('frontend/otp-verification',compact('page'));
    }

    public function verifyOtp() {
        if(!$this->request->isAJAX()){
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Invalid request',
            ]);
        }
        $rules = [
            'otp' => 'required|numeric|exact_length[6]',
        ];
        if(!$this->validate($rules)){
            return $this->response->setJSON([
                'success' => false,
                'errors' => $this->validator->getErrors(),
            ]);
        }
        $userModel = new UsersregistrationsModel();
        $user = $userModel->where('email', session()->get('reset_email'))->first();
        if($user){
            //select only last Otp
            $passwordReset = $this->passwordresetModel->where('email', session()->get('reset_email'))->where('otp', $this->request->getPost('otp'))->orderBy('id','DESC')->first();
            if($passwordReset){
                if($passwordReset['expires_at'] < date('Y-m-d H:i:s')){
                    return $this->response->setJSON([
                        'success' => false,
                        'errors' => ['otp' => 'OTP has expired'],
                        'message' => 'OTP has expired',
                    ]);
                }
                if($passwordReset['used'] == 1){
                    return $this->response->setJSON([
                        'success' => false,
                        'errors' => ['otp' => 'OTP Invalid'],
                        'message' => 'OTP Invalid',
                    ]);
                }
               
                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'OTP verified successfully',
                    'url' => base_url('reset-password/').$passwordReset['token']
                ]);
            }else{
                return $this->response->setJSON([
                    'success' => false,
                    'errors' => ['otp' => 'Invalid OTP'],
                    'message' => 'Invalid OTP',
                ]);
            }
        }else{
            return $this->response->setJSON([
                'success' => false,
                'errors' => ['otp' => 'User not found'],
                'message' => 'User not found',
            ]);
        }
    }

    public function resendOtp()
    {
        $email = session()->get('reset_email');

        if (!$email) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Session expired'
            ]);
        }

        $lastOtp = $this->passwordresetModel->where('email', $email)->orderBy('id','DESC')->first();

        if($lastOtp){

            $cooldown = 30; // seconds

            $lastTime = strtotime($lastOtp['created_at']);
            $current = time();

            if(($current - $lastTime) < $cooldown){

                $remaining = $cooldown - ($current - $lastTime);

                return $this->response->setJSON([
                    'success'=>false,
                    'message'=>"Please wait {$remaining} seconds before resending OTP"
                ]);

            }
        }

        $userModel = $this->usersregistrationsModel;
        $user = $userModel->where('email',$email)->first();
        //update the bore all otp is used 
        $this->passwordresetModel->where('email', $email)->where('user_id', $user['id'])->set(['used' => 1])->update(); 

        $otp = random_int(100000,999999);
        $token = bin2hex(random_bytes(32));
        $this->passwordresetModel->insert([
            'user_id'=>$user['id'],
            'email'=>$email,
            'token'=> $token,
            'otp'=>$otp,
            'expires_at'=>date('Y-m-d H:i:s',strtotime('+10 minutes')),
            'created_at'=>date('Y-m-d H:i:s'),
            'used'=>0
        ]);

        $emailService = \Config\Services::email();

        $emailService->setTo($email);
        $emailService->setSubject("Resend OTP");
        $emailService->setMessage("<h3>Your OTP: ".$otp."</h3>");

        $emailService->send();

        return $this->response->setJSON([
            'success'=>true,
            'message'=>'OTP resent successfully'
        ]);
    }

    public function resetPasswordRequest($token) {
        if(!session()->get('reset_email')){
            return redirect()->to(base_url('forgot-password'));
        }
        $password = $this->request->getPost('password');

        $reset = $this->passwordresetModel->where('token',$token)->first();
        if(!$reset){
            return "Invalid token";
        }
        $page = "Reset Password";
        return view('frontend/reset-password',compact('page','token'));
    }

    public function resetpassword(){
        if(!$this->request->isAjax()) {
            return $this->response->setJSON(['success' => false,'message' => "invalid Request"]);
        }
        $rules = [
            'reset_password' => 'required|min_length[6]',
            'confirm_password' => 'required|matches[reset_password]',
        ];

        if(!$this->validate($rules)){
            return $this->response->setJSON([
                'success' => false,
                'errors' => $this->validator->getErrors(),
            ]);
        }

        $password = $this->request->getPost('reset_password');
        $confirm_password = $this->request->getPost('confirm_password');
        $token = $this->request->getPost('token');

        $reset = $this->passwordresetModel->where('token',$token)->first();
        if(empty($reset)){
            return $this->response->setJSON([
                'success' => false,
                'errors' => ['confirm_password' => 'invalid Token'],
                'message' => 'Invalid token',
            ]);
        }
        $user = $this->usersregistrationsModel->where('id',$reset['user_id'])->first();
        //set token expire no not 
        if($reset['expires_at'] < date('Y-m-d H:i:s')){
            return $this->response->setJSON([
                'success' => false,
                'errors' => ['confirm_password' => 'Time out Your Token is expired . Try to generate new toke click the forgot password'],
                'message' => 'Token has expired',
            ]);
        }
        if($reset['used'] == 1){
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Token has already been used',
            ]);
        }
        if(!$user){
            return $this->response->setJSON([
                'success' => false,
                'message' => 'User not found',
            ]);
        }

       $this->usersregistrationsModel->update($user['id'],[
            'password' => password_hash($password,PASSWORD_DEFAULT),
        ]);

        $this->passwordresetModel->update($reset['id'],[
            'used' => 1,
        ]);
        //clear session
        session()->remove('reset_email');

        return $this->response->setJSON([
            'success' => true,
            'message' => 'Password reset successfully',
            'url' => base_url('login'),
        ]);
    }


    public function logout() {
        $session = session();
        $session->remove('user');
        return  redirect()->to(base_url(''));
    }
}