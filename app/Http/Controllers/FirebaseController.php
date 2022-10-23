<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Kreait\Firebase\Factory;
use Kreait\Firebase\Auth;
use Firebase\Auth\Token\Exception\InvalidToken;
use Kreait\Firebase\Exception\Auth\RevokedIdToken;

class FirebaseController extends Controller
{
    protected $auth, $database,$storage,$storageClient,$defaultBucket;

    public function __construct()
    {
        $factory = (new Factory)
        ->withServiceAccount(base_path().'/covid-runner-f54c7-firebase-adminsdk-s84ur-0346af759f.json')
        ->withDatabaseUri('https://covid-runner-f54c7-default-rtdb.firebaseio.com/');
        $this->auth = app('firebase.auth');
        $this->database = app('firebase.database');
        $this->storage = app('firebase.storage');
        $this->storageClient = $this->storage->getStorageClient();
        $this->defaultBucket = $this->storage->getBucket();
    }

    public function recover()
    {
        //variables
            $username = $_GET['username'];
            $email = $_GET['email'];
            $pass = $_GET['password'];
            $token = $_GET['token'];
            $highscore = $_GET['highscore'];
            try {
                $userProperties = [
                    'uid' => $token,
                    'email' => $email,
                    'emailVerified' => false,
                    'password' => $pass,
                    'displayName' => $username,
                    'disabled' => false,];
                $createdUser = $this->auth->createUser($userProperties);
                $signInResult = $this->auth->signInWithEmailAndPassword($email, $pass);
                $uid = $signInResult->firebaseUserId();
                $ref = $this->database->getReference('users/'.$uid)->set([
                        "username" => $username,
                        "Highscore" => (int)$highscore
                ]);      
                $msg = "Account Recovered!";
            } 
            catch (\Throwable $e) {
                switch ($e->getMessage()) {
                    case 'The email address is already in use by another account.':
                        $msg = "Account already exist!";
                        break;
                    case 'A password must be a string with at least 6 characters.':
                        $msg = "Password must be atleast 6 characters";
                        break;
                    default:
                        $msg = "Error";
                        break;
                }
            }
            catch (ReferenceHasNotBeenSnapshotted $e) {

                $referenceInQuestion = $e->getReference();
            
                $msg = $e->getReference()->getUri().': '.$e->getMessage();
            
            } catch (TransactionFailed $e) {
            
                $referenceInQuestion = $e->getReference();
                $failedRequest = $e->getRequest();
                $failureResponse = $e->getResponse();
            
                $msg = $e->getReference()->getUri().': '.$e->getMessage();
            
            }
        
        return response()->json(array('msg'=> $msg), 200);
    }

    public function signUp()
    {
        //variables
            $username = $_POST['username'];
            $email = $_POST['email'];
            $pass = $_POST['password'];
            $pass_2 = $_POST['password_2'];
            $defaultPhoto = "https://upload.wikimedia.org/wikipedia/commons/7/7c/Profile_avatar_placeholder_large.png";
            if($pass != $pass_2)
            {
                $msg = "Password verification not matched";
            }
            else{
            try {
                $userProperties = [
                    'email' => $email,
                    'emailVerified' => false,
                    'password' => $pass,
                    'displayName' => $username,
                    'photoURL'=> $defaultPhoto,
                    'phoneNumber'=>'+639000000000',
                    'disabled' => false,
                ];
                $createdUser = $this->auth->createUser($userProperties);
                $signInResult = $this->auth->signInWithEmailAndPassword($email, $pass);
                $uid = $signInResult->firebaseUserId();
                $ref = $this->database->getReference('users/'.$uid)
                ->set([
                        "username" => $username,
                        "Highscore" => 0
                ]);      
                $msg = "Account Created!";
            } 
            catch (\Throwable $e) {
                switch ($e->getMessage()) {
                    case 'The email address is already in use by another account.':
                        $msg = "Account already exist!";
                        break;
                    case 'A password must be a string with at least 6 characters.':
                        $msg = "Password must be atleast 6 characters";
                        break;
                    default:
                        $msg = "Error";
                        break;
                }
            }
        }
        return response()->json(array('msg'=> $msg), 200);
    }
    public function signIn(Request $request)
    {
        $email = $_POST['email'];
        $pass = $_POST['password'];
        if($email == "" || $pass==""){
            $msg = "Please input required informations";
        }
        else if($email == "admin@gmail.com" && $pass == "admin"){
                $msg = "admin";
                $signInResult = $this->auth->signInAnonymously();
                $uid = $signInResult->firebaseUserId();
                Session::put('firebaseUserId', $uid);
                Session::put('idToken', $signInResult->idToken());
                Session::put('email', $email);
                Session::save();
        }
        else{
            try {
                $signInResult = $this->auth->signInWithEmailAndPassword($email, $pass);
                $uid = $signInResult->firebaseUserId();
                $user = $this->auth->getUser($uid);
                $photo = $user->photoUrl;
                $number = $user->phoneNumber;
                $username = $this->database->getReference('users/'.$uid.'/username')->getValue();
                $highscore = $this->database->getReference('users/'.$uid.'/Highscore')->getValue();
                Session::put('firebaseUserId', $signInResult->firebaseUserId());
                Session::put('idToken', $signInResult->idToken());
                Session::put('email', $email);
                if($photo == null){
                    Session::put('profilePhoto', "https://upload.wikimedia.org/wikipedia/commons/7/7c/Profile_avatar_placeholder_large.png");
                }
                else{
                    Session::put('profilePhoto', $photo);
                }
                if($number == null){
                    Session::put('coverphoto', '+639000000000');
                }
                else{
                    Session::put('coverphoto', $number);
                }
               
                Session::put('username', $username);
                Session::put('highscore', $highscore);
                Session::save();
                $msg = "Success";
            } catch (\Throwable $e) {
                switch ($e->getMessage()) {
                    case 'INVALID_PASSWORD':
                        $msg = "Invalid Password";
                        break;
                    case 'EMAIL_NOT_FOUND':
                        $msg = "Account does not exist";
                        break;
                    default:
                        $msg = $e->getMessage();
                        break;
                }
            }
            
        }
        
        return response()->json(array('msg'=> $msg), 200);
    }

    public function signInWithPassword(Request $request)
    {
        $email = Session::get('email');
        $pass = $_POST['password'];
        try {
                $signInResult = $this->auth->signInWithEmailAndPassword($email, $pass);
                $msg = "back-up downloading...";
            } 
            catch (\Throwable $e) {
                switch ($e->getMessage()) {
                    case 'INVALID_PASSWORD':
                        $msg = "Invalid Password";
                        break;
                    case 'EMAIL_NOT_FOUND':
                        $msg = "Account does not exist";
                        break;
                    default:
                        $msg = $e->getMessage();
                        break;
                }
            }
        return response()->json(array('msg'=> $msg), 200);
    }

    public function signOut()
    {
       
        $email = Session::get('email');
        $uid = Session::get('firebaseUserId');
        $msg ="";
        $name = Session::get('firebaseUserId').".png";
        Storage::disk('links')->delete($name);

        if (Session::has('firebaseUserId') && Session::has('idToken')&& $email != "admin@gmail.com") {
            $this->auth->revokeRefreshTokens(Session::get('firebaseUserId'));
            Session::forget('firebaseUserId');
            Session::forget('idToken');
            Session::forget('email');
            Session::forget('username');
            Session::forget('highscore');
            Session::save();
        } 
        if(Session::has('firebaseUserId') && $email == "admin@gmail.com"){
            $this->auth->revokeRefreshTokens(Session::get('firebaseUserId'));
            try {
                $this->auth->deleteUser($uid);
                $msg = 'success';
            }
            catch (\Kreait\Firebase\Exception\Auth\UserNotFound $e) {
             $msg =    $e->getMessage();
            }
            catch (\Kreait\Firebase\Exception\AuthException $e) {
                $msg =   'Deleting';
            }
            
            Session::forget('firebaseUserId');
            Session::forget('idToken');
            Session::forget('email');
            Session::forget('username');
            Session::forget('highscore');
            Session::save();
        }
      return redirect()->route('home');
    }
    public function updateUsername(Request $request)
    {
        try{
            $username =$_POST['username'];
            $uid = Session::get('firebaseUserId');
            $properties = ['displayName' => $username];
            $updatedUser = $this->auth->updateUser($uid, $properties);
            Session::forget('username');
            Session::put('username', $username);
            Session::save();
            $updates = [
                'username' => $username,
            ];
            $this->database->getReference("users/".$uid)->update($updates);
            $msg="Success";
           }
        catch(\exception $e){
            $msg=$e->getMessage();
        }
        return response()->json(array('msg'=> $msg), 200);
    }

    public function updateEmail(Request $request){
        try{
            $email =$_POST['email'];
            $uid = Session::get('firebaseUserId');
            $updatedUser = $this->auth->changeUserEmail($uid, $email);
            Session::forget('email');
            Session::put('email', $email);
            Session::save();
            $msg="Success";
        }
        catch(\Throwable $e){
            $msg = $e->getMessage();
        }
        return response()->json(array('msg'=> $msg), 200);
    }

    public function updatePassword(){
        $password =$_POST['password'];
        $uid = Session::get('firebaseUserId');
        try{
        $updatedUser = $this->auth->changeUserPassword($uid, $password);
        $msg="Success";
           }
        catch(\Throwable $e){
            $msg = $e->getMessage();
        }

        return response()->json(array('msg'=> $msg), 200);
    }

    
    public function DeleteUser()
    {   
        $uid = Session::get('firebaseUserId');
        $this->auth->deleteUser($uid);
        $this->database->getReference("users/".$uid)->remove();
        Session::forget('firebaseUserId');
        Session::forget('idToken');
        Session::forget('email');
        Session::forget('username');
        Session::forget('highscore');
        Session::save();
    }

    public function table(){
        $ref = $this->database->getReference('users')->orderByChild('Highscore')->getSnapshot();
        $value = $ref->getValue();
        if($value !=null)
       {
        $reversed = array_reverse($value);
        $json_array =  json_encode($reversed);
        return $json_array;
        }
        else{  
            return "no data";
        }
      
    }
    public function table_disabled(){
        $ref = $this->database->getReference('blacklist')->getSnapshot();
        $value = $ref->getValue();
        if($value !=null)
        {
         $json_array =  json_encode($value);
         return $json_array;
        }
         else{  
             return "no data";
         }
    }
    public function initializeSession(){
        $uid = Session::get('firebaseUserId');
        $user = $this->auth().getUser($uid);
    }

    public function resetPassword(){
        // Using an email address only
        $email = $_POST['email'];
        $msg = "";
        try{
            $this->auth->sendPasswordResetLink($email);
            $msg =   "Email sent";
        }
        catch(\Throwable $e){
            $msg =  "failed";
        }
        return $msg;
        
    }

    public function updatePhoto()
    {
        $uid =  Session::get('firebaseUserId');
        $photoURL = $_POST['photoURL'];
        $properties = [
            'photoURL' => $photoURL
        ];
        $updatedUser = $this->auth->updateUser($uid, $properties);
       
        $user = $this->auth->getUser($uid);
        $photoURL = $user->photoUrl;
        Session::put('profilePhoto', $photoURL);
        $msg = "photo uploaded successfully!";
        return $msg;
    }
    public function editCover()
    {
       $cover_no = $_POST['select_cover'];
       Session::put('coverphoto', $cover_no);
       $uid =  Session::get('firebaseUserId');
       $properties = [
           'phoneNumber' => $cover_no
       ];
       $updatedUser = $this->auth->updateUser($uid, $properties);

       return $cover_no;
    }
    public function disableAccount()
    {

        $uid =  $_POST['user_id'];
        $username = $this->database->getReference('users/'.$uid.'/username')->getSnapshot()->getValue();
        $highscore = $this->database->getReference('users/'.$uid.'/Highscore')->getSnapshot()->getValue();
        $updatedUser = $this->auth->disableUser($uid);
        $this->database->getReference("users/".$uid)->remove();
        $ref = $this->database->getReference('blacklist/'.$uid)->set([
                        "username" => $username,
                        "Highscore" => 0
                ]);
        echo $username;
        echo $highscore;
    }
    public function EnableAccount()
    {
        $uid =  $_POST['user_id'];
        $username = $this->database->getReference('blacklist/'.$uid.'/username')->getSnapshot()->getValue();
        $highscore = $this->database->getReference('blacklist/'.$uid.'/Highscore')->getSnapshot()->getValue();
        $updatedUser = $this->auth->enableUser($uid);
        $this->database->getReference("blacklist/".$uid)->remove();
        $ref = $this->database->getReference('users/'.$uid)->set([
                        "username" => $username,
                        "Highscore" => 0
                ]);
        echo $username;
        echo $highscore;
    }
    public function downloadPhoto(){
        $url = Session::get('profilePhoto');
        $contents = file_get_contents($url);
        $name = Session::get('firebaseUserId').".png";
        $path = Storage::disk('links')->put($name, $contents);
        $msg = "uploaded photo successfully!";
        return $msg;
    }
    public function test()
    {
        $uid =  Session::get('firebaseUserId');
        $user = $this->auth->getUser($uid);
        dd($user->phoneNumber);
    }
}
