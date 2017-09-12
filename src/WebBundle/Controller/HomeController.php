<?php

namespace WebBundle\Controller;

use JobBundle\Entity\Job;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class HomeController extends Controller
{
    public function indexAction()
    {
        $recentJobs = $this->getDoctrine()->getRepository(Job::class)->findBy([], ['id' => 'DESC']);

        $data['recentJobs'] = $recentJobs;

        return $this->render('WebBundle:Home:index.html.twig', $data);
    }

    public function detailAction(Request $request)
    {
        $id = $request->get('id');

        $job = $this->getDoctrine()->getRepository(Job::class)->find($id);

        $data['job'] = $job;

        return $this->render('WebBundle:Home:detail.html.twig', $data);
    }
}
