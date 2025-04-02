<?
require __DIR__ . '/../repositories/UserRepository.php';

class UserService{
    private UserRepository $userRepository;
    function __construct(){
        $this->userRepository = new UserRepository();
    }

    public function getAllUsers(){
        return $this->userRepository->getAllUsers();
    }

    public function getUserById($user_id){
        return $this->userRepository->getUserById($user_id);
    }

    public function getUserByEmail($email){
        return $this->userRepository->getUserByEmail($email);
    }


    public function validateUser($email , $password)  {
        return $this->userRepository->validateUser($email,$password);
    }

}