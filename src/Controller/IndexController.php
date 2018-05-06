<?php
namespace App\Controller;

use App\Entity\User;
use App\Form\User\UserProfileType;
use App\Form\User\UserAdminType;
use App\Repository\UserRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


class IndexController extends Controller
{
    /**
     * @Route("/", name="index")
     */
    public function index()
    {
        return $this->render('index.html.twig');
    }
    /**
     * @Route("/admin", name="admin")
     */
    public function admin()
    {
        return $this->render('Admin/index.html.twig');
    }

    /**
     * @Route("/community", name="community_index", methods="GET")
     */
    public function community(UserRepository $userRepository): Response
    {
        return $this->render('Community/index.html.twig', ['users' => $userRepository->findAll()]);
    }
}
