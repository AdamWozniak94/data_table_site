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
        return $this->render('main.html.twig');
    }

    /**
     * @Route("/data")
     */
    public function getPageData(Request $request): JsonResponse
    {
        $page = $request->query->get('page');
        $limit = $request->query->get('limit');
        $orderBy = $request->query->get('orderBy');
        $sortOrder = $request->query->get('sortOrder');
        $search = $request->query->get('search');

        // get json content and decode it into array
        $jsonData = file_get_contents('assets/naglowki_zamowienia.json');
        $decodedData = json_decode($jsonData);

        // sort data by provided values
        usort($decodedData, function ($a, $b) use ($orderBy, $sortOrder) {
            if ('asc' == $sortOrder) {
                return $a->$orderBy > $b->$orderBy ? 1 : -1;
            } else {
                return $a->$orderBy > $b->$orderBy ? -1 : 1;
            }
        });

        // search matching rows by ref and symbol if search phrase is provided
        if ($search) {
            $matchingData = [];
            foreach ($decodedData as $decodedDatum) {
                if (strpos($decodedDatum->ref, $search) !== FALSE) {
                    $matchingData[] = $decodedDatum;
                } elseif (strpos($decodedDatum->symbol, $search) !== FALSE) {
                    $matchingData[] = $decodedDatum;
                }
            }
            $decodedData = $matchingData;
        }

        // paginate results
        $total = count($decodedData);
        $pages = ceil($total / $limit);
        $offset = ($page - 1)  * $limit;
        $rows = array_slice($decodedData, $offset, $limit);

        return new JsonResponse(['pages'=>$pages, 'rows'=>$rows]);
    }
}