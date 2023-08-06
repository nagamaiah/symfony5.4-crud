<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class TestController extends AbstractController
{
    #[Route('/test', name: 'test_index')]
    public function index(): Response
    {
        return $this->render('test/index.html.twig', [
            'controller_name' => 'TestController',
        ]);
    }

    #[Route('/test/message/{msg_id?}', name: 'test_message')]
    public function testMessage(int $msg_id=null): JsonResponse|Response
    {
        $data = ['name'=>'suraj',"age"=>30];
        if(!is_null($msg_id)){
            return new Response('message id is '.$msg_id); 
        }
        
        // return new Response('somethihggg');
        // return new Response(234.234);
        // return new Response('<h3>Message Response</h3>');
        // return new Response(json_encode(['name'=>'suraj',"age"=>30]));
        return $this->render('test/message.html.twig', ['data'=>$data]);
        // return $this->json(['name'=>'suraj',"age"=>30]);
    }

    public function showUser($user_id=null)
    {
        if(is_null($user_id))
        {
            return new Response('User not found');
        }
        return $this->json(['id'=>$user_id,'name'=>'jars',"age"=>32]);
    }
}
