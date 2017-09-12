<?php

namespace JobBundle\Controller;

use JobBundle\Entity\Job;
use JobBundle\Form\JobType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class JobController extends Controller
{
    public function listAction()
    {
        $jobs = $this->getDoctrine()->getRepository(Job::class)->findAll();

        $data['jobs'] = $jobs;

        return $this->render('JobBundle:Job:list.html.twig', $data);
    }

    public function createAction(Request $request)
    {
        $job = null;

        $form = $this->createForm(JobType::class, $job);

        if($request->isMethod('POST'))
        {
            $form->handleRequest($request);

            if ($form->isValid()) {
                $job = $form->getData();

                $em = $this->getDoctrine()->getManager();
                $em->persist($job);

                try {
                    $em->flush();
                    $this->addFlash('success', "Job Created");
                } catch (Exception $e) {
                    print_r($e->getMessage());
                    exit;
                }

                return $this->redirectToRoute('job_list');
            }
        }

        $data['form'] = $form->createView();

        return $this->render('JobBundle:Job:create.html.twig', $data);
    }

    public function editAction(Request $request)
    {
        $id = $request->get('id');

        $job = $this->getDoctrine()->getRepository(Job::class)->find($id);

        $form = $this->createForm(JobType::class, $job);

        if($request->isMethod('POST'))
        {
            $form->handleRequest($request);

            if ($form->isValid()) {
                $job = $form->getData();

                $em = $this->getDoctrine()->getManager();
                $em->persist($job);

                try {
                    $em->flush();
                    $this->addFlash('success', "Job Updated");
                } catch (Exception $e) {
                    print_r($e->getMessage());
                    exit;
                }

                return $this->redirectToRoute('job_list');
            }
        }

        $data['form'] = $form->createView();

        return $this->render('JobBundle:Job:edit.html.twig', $data);
    }

    public function deleteAction(Request $request)
    {
        $id = $request->get('id');

        $job = $this->getDoctrine()->getRepository(Job::class)->find($id);

        if($job){
            $em = $this->getDoctrine()->getEntityManager();

            $em->remove($job);
            $em->flush();
        }

        return $this->redirectToRoute('job_list');
    }
}
