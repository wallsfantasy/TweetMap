<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
        ]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @Route("/search", name="search")
     */
    public function search(Request $request)
    {
        $city = $request->query->get('city');

        try {
            $json = $this->get('app.service.search_city_tweet')->search($city);
        } catch (\Exception $e) {
            return new JsonResponse(['success' => false], 400);
        }

        return new JsonResponse($json, 200, [], true);
    }
}
