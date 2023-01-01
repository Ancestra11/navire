<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Message;

#[Route('message', name: 'message')]
class MessageController extends AbstractController
{
    #[Route('', name: 'index')]
    public function demandeRenseignement(Request $request): Response {
        $message = new Message();
        $form = $this->createFormBuilder($message)
                ->add('nom')
                ->add('prenom')
                ->add('mail')
                ->add('message')
                ->getForm();
        
         // Traiter la requête HTTP soumise par l'utilisateur
        $form->handleRequest($request);

        // Vérifier si le formulaire est valide
        if ($form->isSubmitted() && $form->isValid()) {
            // Récupérer les données du formulaire
            $data = $form->getData();
            
            $email = $data->getMail();
            $config = \SendinBlue\Client\Configuration::getDefaultConfiguration()->setApiKey('api-key', 
                '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');
            $apiInstance = new \SendinBlue\Client\Api\TransactionalEmailsApi(
                new \GuzzleHttp\Client(),
                $config
            );
            $sendSmtpEmail = new \SendinBlue\Client\Model\SendSmtpEmail();
            $sendSmtpEmail['subject'] = "Renseignement TP navire";
            $sendSmtpEmail['htmlContent'] = '<html><body><h1>Vous avez reçu ce mail.</h1></body></html>';
            $sendSmtpEmail['sender'] = array('name' => 'Envoyeur de mail', 'email' => 'EnvoiMail.ATR@yahoo.com');
            $sendSmtpEmail['to'] = array(
                array('email' => $email, 'name' => 'Utilisateur')
            );
            try {
                $result = $apiInstance->sendTransacEmail($sendSmtpEmail);
            } catch (Exception $e) {
                echo 'Exception when calling TransactionalEmailsApi->sendTransacEmail: ', $e->getMessage(), PHP_EOL;
            }
            
            // Enregistrer les données dans la base de données
            // (par exemple en utilisant Doctrine)
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($data);
            $entityManager->flush();

            // Rediriger l'utilisateur vers une autre page
            return $this->redirect('http://navire.sio/message/validation');
        }
        
        return $this->render('message/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    
    #[Route('/validation', name:'validation')]
    public function demandeRenseignementValide() : Response {
        return $this->render('message/validation.html.twig');
    }
}
