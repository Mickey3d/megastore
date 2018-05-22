<?php

namespace App\Controller;

use App\Entity\Profile;
use App\Entity\User;
use App\Form\Profile\ProfileAdminType;
use App\Repository\ProfileRepository;
use App\Repository\UserRepository;
use App\Repository\TeamRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/profiles")
 */
class ProfileController extends Controller
{
    /**
     * @Route("/", name="profile_index", methods="GET")
     */
    public function index(ProfileRepository $profileRepository, UserRepository $userRepository, TeamRepository $teamRepository): Response
    {
        return $this->render('Community/index.html.twig', [
            'profiles' => $profileRepository->findAll(),
            'users' => $userRepository->findAll(),
            'teams' => $teamRepository->findAll()
          ]);

    }

    /**
     * @Route("/{id}/show", name="profile_show", methods="GET")
     */
    public function show(Profile $profile): Response
    {
        return $this->render('Community/profile/show.html.twig', ['profile' => $profile]);
    }

    /**
     * @Route("/{id}/edit", name="profile_edit", methods="GET|POST")
     */
    public function edit(Request $request, Profile $profile): Response
    {
        $form = $this->createForm(ProfileAdminType::class, $profile);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('success','The Profile have been updated!');

            return $this->redirectToRoute('profile_edit', ['id' => $profile->getId()]);
        }

        return $this->render('Community/profile/edit.html.twig', [
            'profile' => $profile,
            'form' => $form->createView(),
        ]);
    }


    /**
     * @Route("/admin/profile/new", name="admin_profile_new", methods="GET|POST")
     */
    public function adminNewProfile(Request $request)
    {
        $profile = new Profile();
        $form = $this->createForm(ProfileAdminType::class, $profile);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($profile);
            $em->flush();
            $this->addFlash('success','The Profile have been created!');
            return $this->redirectToRoute('profile_edit', ['id' => $profile->getId()]);
        }

        return $this->render('Admin/Community/profile/new.html.twig', [
            'profile' => $profile,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/profile/{id}", name="profile_delete", methods="DELETE")
     */
    public function delete(Request $request, Profile $profile): Response
    {
        if ($this->isCsrfTokenValid('delete'.$profile->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($profile);
            $em->flush();
            $this->addFlash('success','The Profile have been deleted!');
        }

        return $this->redirectToRoute('community_index');
    }
}
