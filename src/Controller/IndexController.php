<?php
namespace App\Controller;

use App\Repository\UserRepository;
use App\Repository\TeamRepository;
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
    public function community(UserRepository $userRepository, TeamRepository $teamRepository): Response
    {
        return $this->render('Community/index.html.twig', [
          'users' => $userRepository->findAllTheUsers(),
          'teams' => $teamRepository->findAll()
        ]);
    }
}
