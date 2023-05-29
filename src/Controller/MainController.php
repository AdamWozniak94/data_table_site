<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    /**
     * @Route("/")
     */
    public function index(): Response
    {
//        $data = $this->getData();
//        dump($data);
        return $this->render('main.html.twig');
    }

    /**
     * @Route("/data")
     */
    public function getPageData(Request $request): JsonResponse
    {
        $page = $request->query->get('page');
        $limit = $request->query->get('limit');
        $jsonData = file_get_contents('assets/naglowki_zamowienia.json');
        $decodedData = json_decode($jsonData);
        $total = count($decodedData);
        $pages = ceil($total / $limit);
        $offset = ($page - 1)  * $limit;
        $rows = array_slice($decodedData, $offset, $limit);
        return new JsonResponse(['pages'=>$pages, 'rows'=>$rows]);
    }
}