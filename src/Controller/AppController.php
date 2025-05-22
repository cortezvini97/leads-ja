<?php

namespace App\Controller;

use App\Entity\Leads;
use App\Repository\LeadsRepository;
use Cortez\SymfonyHybridViews\Controllers\RenderViewsController;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class AppController extends RenderViewsController{

    private EntityManagerInterface $entityManager;
    private LeadsRepository $leadsRepository;

    public function __construct(EntityManagerInterface $entityManager, LeadsRepository $leadsRepository)
    {
        $this->entityManager = $entityManager;
        $this->leadsRepository = $leadsRepository;
    }

    #[Route(path: "/", name: "home")]
    public function index():Response{

        $image = null;

        $file = $this->getParameter("upload_dir").DIRECTORY_SEPARATOR."banner.png";

        if(file_exists($file)){
            $image = "banner.png";
        }

        return $this->view("index", [
            "image"=>$image
        ]);
    }


    /*#[Route(path:"/getleads", name:"getleads")]
    public function getLeads():Response {
        $leads = $this->leadsRepository->findAll();
        dd($leads);
        return $this->view("leads", [
            "leads"=>$leads
        ]);
    }*/

    #[Route(path: "/send", name: "app_send", methods:["POST"])]
    public function saveEvent(Request $request):Response {
        $name = $request->get('name');
        $city = $request->get('city');
        $state = $request->get('state');
        $email = $request->get('email');
        $phone = $request->get('phone');
        $category = $request->get('category');


        $lead = new Leads();
        $lead->setNome($name)->setCidade($city)->setEstado($state)->setEmail($email)->setTelefone($phone)->setCategoria($category);

        $this->entityManager->persist($lead);
        $this->entityManager->flush();

        return $this->redirectToRoute("home");
    }
}
