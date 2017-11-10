<?php

namespace AppBundle\Controller;

use AppBundle\Form\SubscribeType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="app_homepage")
     */
    public function indexAction(Request $request)
    {       
        return $this->render('AppBundle:Default:index.html.twig');
    }

    /**
     * @Route("/create", name="app_create")
     */
    public function createAction(Request $request)
    {
        $subscribeForm = $this->createForm(new SubscribeType());
        $subscribeForm->handleRequest($request);
        if ($subscribeForm->isValid()) {
            $data = $subscribeForm->getData();
            $campaignMonitorService = $this->container->get('campaign.monitor.service');
            $results = $campaignMonitorService->subscribe($data['email'], $data['name']);
            if($results['success'] == true){
                $this->addFlash('success', $this->get('translator')->trans('subscribe.saved'));
            }else{
                $this->addFlash('error', $results['message']);
            }
        }
        return $this->render('AppBundle:Default:create.html.twig',[
            'subscribeForm' => $subscribeForm->createView()
        ]);
    }

    /**
     * @Route("/ajax/get_subscribers/", name="app_get_subscribers", options={"expose"=true})
     * @param Request $request
     */
    public function getSubscribersAction(Request $request)
    {
        if ($request->isXmlHttpRequest()) {
            $start = $request->request->get('start');
            $limit = $request->request->get('length');
            if($start >= 0){
                $page = ($start / $limit) + 1;
                $results = $this->container->get('campaign.monitor.service')->getActiveSubscribers(NULL, $page, $limit);
                return new JsonResponse([
                    'data' => $results,
                ]);
            }
        }
        return new JsonResponse(false);
    }

    /**
     * @Route("/ajax/delete_subscribers/", name="app_delete_subscribers", options={"expose"=true})
     * @param Request $request
     */
    public function deleteSubscribersAction(Request $request)
    {
        if ($request->isXmlHttpRequest()) {
            $results = $this->container->get('campaign.monitor.service')->delete($request->get('email'));
            return new JsonResponse($results);
        }
        return new JsonResponse(false);
    }
}
