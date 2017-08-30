<?php

namespace JobBundle\Controller;

use JobBundle\Entity\Category;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class CategoryController extends Controller
{
    public function listAction()
    {
        $categories = $this->getDoctrine()->getRepository(Category::class)->findAll();

        $data['categories'] = $categories;

        return $this->render('JobBundle:Category:list.html.twig', $data);
    }

    public function createAction(Request $request)
    {
        if($request->getMethod() == 'POST')
        {
            $name = $request->get('category');

            $category = new Category();

            $category->setName($name);

            $em = $this->getDoctrine()->getEntityManager();

            $em->persist($category);

            try{
                $em->flush();
            }catch (\Throwable $t){
                print_r($t->getMessage());
            }

            return $this->redirectToRoute('category_list');
        }

        return $this->render('JobBundle:Category:create.html.twig');
    }

    public function editAction(Request $request)
    {
        $id = $request->get('id');

        $category = $this->getDoctrine()->getRepository(Category::class)->find($id);

        if($request->getMethod() == 'POST')
        {
            $name = $request->get('category');

            $category->setName($name);

            $em = $this->getDoctrine()->getEntityManager();

            $em->persist($category);

            try{
                $em->flush();
            }catch (\Throwable $t){
                print_r($t->getMessage());
            }

            return $this->redirectToRoute('category_list');
        }

        $data['category'] = $category;

        return $this->render('JobBundle:Category:edit.html.twig', $data);
    }

    public function deleteAction(Request $request)
    {
        $id = $request->get('id');

        $category = $this->getDoctrine()->getRepository(Category::class)->find($id);

        if($category){
            $em = $this->getDoctrine()->getEntityManager();

            $em->remove($category);
            $em->flush();
        }

        return $this->redirectToRoute('category_list');
    }
}
