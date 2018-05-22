<?php
namespace App\Controller;

use App\Repository\ProfileRepository;
use App\Repository\UserRepository;
use App\Repository\TeamRepository;
use App\Repository\ItemRepository;
use App\Repository\CategoryRepository;
use App\Repository\StockRepository;
use App\Repository\StatusRepository;
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
    public function community(ProfileRepository $profileRepository, UserRepository $userRepository, TeamRepository $teamRepository): Response
    {
        return $this->render('Community/index.html.twig', [
          'profiles' => $profileRepository->findAll(),
          'users' => $userRepository->findAll(),
          'teams' => $teamRepository->findAll(),
        ]);
    }

    /**
     * @Route("/admin/inventory", name="inventory_index", methods="GET")
     */
    public function inventory(ItemRepository $itemRepository, CategoryRepository $categoryRepository, StockRepository $stockRepository, StatusRepository $statusRepository): Response
    {
        return $this->render('Admin/inventory/index.html.twig', [
          'items' => $itemRepository->findAll(),
          'categories' => $categoryRepository->findAll(),
          'stocks' => $stockRepository->findAll(),
          'statuses' => $statusRepository->findAll()
        ]);
    }
}
