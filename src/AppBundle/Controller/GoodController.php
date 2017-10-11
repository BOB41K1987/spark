<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class GoodController extends Controller
{
    /**
     * @Route("/autocomplete", name="autocomplete", options = { "expose" = true })
     */
    public function indexAction(Request $request)
    {
        /** @var $sphinx \IAkumaI\SphinxsearchBundle\Search\Sphinxsearch */
        $sphinx = $this->get('iakumai.sphinxsearch.search');

        /** @var $sphinxDoctrineBridge \IAkumaI\SphinxsearchBundle\Doctrine\Bridge */
        $sphinxDoctrineBridge = $this->get('iakumai.sphinxsearch.doctrine.bridge');
        $sphinx->setBridge($sphinxDoctrineBridge); //IMPORTANT! Set doctrine bridge.
        $result = $sphinx->searchEx('*'.$sphinx->getClient()->EscapeString($request->query->get('term', '')).'*', 'spark');

        foreach($result['matches'] as $match){
            $resultArray[] = [
                "id"=>$match['entity']->getId(),
                "label"=>$match['entity']->getName(),
                "value"=>$match['entity']->getId()
            ];
        }

        return new JsonResponse($resultArray);
    }
}