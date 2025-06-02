<?php

namespace App\Controller;

use App\Entity\User;
use App\Helper\GenerateXLSX;
use App\Helper\UserFactory;
use App\Repository\LeadsRepository;
use App\Repository\UserRepository;
use Cortez\SymfonyHybridViews\Controllers\RenderViewsController;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;

class AdminController extends RenderViewsController
{

    private UserRepository $userRepository;
    private LeadsRepository $leads_repository;
    private EntityManagerInterface $entity_manager;
    private UserPasswordHasherInterface $password_hasher;
    private Security $security;

    public function __construct(UserRepository $userRepository, LeadsRepository $leads_repository, EntityManagerInterface $entity_manager, UserPasswordHasherInterface $password_hasher, Security $security)
    {
        $this->userRepository = $userRepository;
        $this->entity_manager = $entity_manager;
        $this->password_hasher = $password_hasher;
        $this->security = $security;
        $this->leads_repository = $leads_repository;
    }

    #[Route(path: '/admin', name: 'admin_home', methods: ['GET'])]
    public function index():Response{
        if(!$this->security->isGranted("IS_AUTHENTICATED_FULLY")){
            return $this->redirectToRoute("app_login");
        }

        $image = null;

        $file = $this->getParameter("upload_dir").DIRECTORY_SEPARATOR."banner.png";

        if(file_exists($file)){
            $image = "banner.png";
        }

        $leads = $this->leads_repository->findAll();

        return $this->view("admin/index", [
            "image" =>$image,
            "leads"=>$leads
        ]);
    }


    #[Route(path: "/admin/getfileExcel", name: "admin_getfileExcel", methods: ["GET"])]
    public function getfileExcel(): Response{
        if(!$this->security->isGranted("IS_AUTHENTICATED_FULLY")){
            return $this->redirectToRoute("app_login");
        }

        $leads = $this->leads_repository->findAll();


        $data_url = $this->generate($leads);

        return $this->json(["data_url"=>$data_url]);
    }

    #[Route(path: "/admin/uploadbanner", name:"upload_banner", methods: ["POST"])]
    public function uploadBanner(Request $request): Response{
        if(!$this->security->isGranted("IS_AUTHENTICATED_FULLY")){
            return $this->redirectToRoute("app_login");
        }

        $file = $request->files->get("banner");

        $file_dir = $this->getParameter("upload_dir").DIRECTORY_SEPARATOR;

        $file->move($file_dir, "banner.png");

        return $this->redirectToRoute("admin_home");
    }

    #[Route(path: "/admin/bannerdelete", name:"banner_delete")]
    public function bannerDelete(): Response{
        if(!$this->security->isGranted("IS_AUTHENTICATED_FULLY")){
            return $this->redirectToRoute("app_login");
        }

        
        $file_dir = $this->getParameter("upload_dir").DIRECTORY_SEPARATOR."banner.png";

        if(file_exists($file_dir)){
            unlink($file_dir);
        }
        
        return $this->redirectToRoute("admin_home");
    }

    #[Route(path:"/admin/users", name: "admin_users")]
    public function getUsers():Response
    {
        if(!$this->security->isGranted("IS_AUTHENTICATED_FULLY")){
            return $this->redirectToRoute("app_login");
        }

        if(!$this->security->isGranted("ROLE_ROOT")){
            return $this->redirectToRoute("admin_home");
        }


        $users = $this->userRepository->findAll();

        return $this->view("admin/users", [
            "users" =>$users
        ]);
    }

    #[Route(path:"/admin/users/add", name: "admin_users_add", methods:["GET"])]
    public function userAdd():Response
    {
        if(!$this->security->isGranted("IS_AUTHENTICATED_FULLY")){
            return $this->redirectToRoute("app_login");
        }
        
        if(!$this->security->isGranted("ROLE_ROOT")){
            return $this->redirectToRoute("admin_home");
        }

        return $this->view("admin/user_add_edit", [
            "isEdit"=>false
        ]);
    }

    #[Route(path:"/admin/users/add", name: "admin_users_create", methods:["POST"])]
    public function userCreate(Request $request):Response
    {
        if(!$this->security->isGranted("IS_AUTHENTICATED_FULLY")){
            return $this->redirectToRoute("app_login");
        }

        if(!$this->security->isGranted("ROLE_ROOT")){
            return $this->redirectToRoute("admin_home");
        }

        $isValid = $this->validateUser($request);

        if($isValid == false){
            return $this->redirectToRoute("admin_users_add");
        }

        $user = $this->createUser($request);

        $this->entity_manager->persist($user);
        $this->entity_manager->flush();

        return $this->redirectToRoute("admin_users");

    }

    #[Route(path:"/admin/users/edit/{id}", name: "admin_users_edit", methods:["GET"])]
    public function userEdit(int $id):Response
    {
        if(!$this->security->isGranted("IS_AUTHENTICATED_FULLY")){
            return $this->redirectToRoute("app_login");
        }
        
        if(!$this->security->isGranted("ROLE_ROOT")){
            return $this->redirectToRoute("admin_home");
        }

        $user = $this->userRepository->findOneBy([
            "id"=>$id
        ]);


        if(is_null($user)){
            throw new NotFoundHttpException("error 404 page not found.");
        }


        return $this->view("admin/user_add_edit", [
            "isEdit"=>true,
            "user"=>$user
        ]);
    }

    #[Route(path:"/admin/users/edit/{id}", name: "admin_users_update", methods:["POST"])]
    public function userUpdate(int $id, Request $request):Response
    {
        if(!$this->security->isGranted("IS_AUTHENTICATED_FULLY")){
            return $this->redirectToRoute("app_login");
        }
        
        if(!$this->security->isGranted("ROLE_ROOT")){
            return $this->redirectToRoute("admin_home");
        }

        /**
         * @var User $user
         * 
         */
        $user = $this->userRepository->findOneBy([
            "id"=>$id
        ]);


        if(is_null($user)){
            throw new NotFoundHttpException("error 404 page not found.");
        }


        $isValid = $this->validateUser($request, $id);

        if($isValid == false){
            return $this->redirectToRoute("admin_users_add");
        }

        $userNew = $this->createUser($request);

        $user->setNome($userNew->getNome())->setUsername($userNew->getUsername())->setEmail($userNew->getEmail())->setPassword($userNew->getPassword());

        $this->entity_manager->persist($user);
        $this->entity_manager->flush();

        return $this->redirectToRoute("admin_users");
    }


    #[Route(path:"/admin/users/delete/{id}", name : "admin_users_delete")]
    public function deleteUser(int $id):Response {
        if(!$this->security->isGranted("IS_AUTHENTICATED_FULLY")){
            return $this->redirectToRoute("app_login");
        }
        
        if(!$this->security->isGranted("ROLE_ROOT")){
            return $this->redirectToRoute("admin_home");
        }

        /**
         * @var User $user
         * 
         */
        $user = $this->userRepository->findOneBy([
            "id"=>$id
        ]);


        if(is_null($user)){
            throw new NotFoundHttpException("error 404 page not found.");
        }

        $this->entity_manager->remove($user);
        $this->entity_manager->flush();

        return $this->redirectToRoute("admin_users");
    }


    private function validateUser(Request $request, ?int $ignoreUserId = null): bool
    {
        $email = $request->get("email");
        $username = $request->get("username");

        $userWithEmail = $this->userRepository->findOneBy(["email" => $email]);
        if ($userWithEmail !== null && $userWithEmail->getId() !== $ignoreUserId) {
            $this->addFlash("error", "E-mail já cadastrado.");
            return false;
        }

        $userWithUsername = $this->userRepository->findOneBy(["username" => $username]);
        if ($userWithUsername !== null && $userWithUsername->getId() !== $ignoreUserId) {
            $this->addFlash("error", "Username já cadastrado.");
            return false;
        }

        return true;
    }


    private function createUser(Request $request):User
    {
        $userFactory = new UserFactory($this->password_hasher);
        $user = $userFactory->create([
            "name"=>$request->get("name"),
            "username"=>$request->get("username"),
            "email"=>$request->get("email"),
            "password"=>$request->get("password")
        ]);

        return $user;
    }


    private function generate($leads):string{
        $gen = new GenerateXLSX($leads);
        $b64 = $gen->generate();
        $dataUrl = 'data:application/vnd.openxmlformats-officedocument.spreadsheetml.sheet;base64,' . $b64;
        return $dataUrl;
    }

    
}