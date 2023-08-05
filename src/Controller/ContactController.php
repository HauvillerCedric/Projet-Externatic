<?php

namespace App\Controller;

use App\Entity\Mailer;
use App\Entity\Subject;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mailer\MailerInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ContactController extends AbstractController
{
    #[Route('/contact', name: 'app_contact')]
    public function index(Request $request, EntityManagerInterface $entityManager, MailerInterface $mailer): Response
    {
        $error = '';
        $success = '';

        if ($request->isMethod('POST')) {
            $formData = $request->request->all();
            $missingFields = $this->getMissingFields($formData, ['name', 'phone', 'email', 'description', 'subject']);

            if (!empty($missingFields)) {
                $error = 'Veuillez remplir tous les champs requis';
            } else {
                $mail = new Mailer();
                $mail->setName($formData['name']);
                $mail->setPhone($formData['phone']);
                $mail->setEmail($formData['email']);
                $mail->setDescription($formData['description']);

                $subjectId = $formData['subject'];
                $subject = $entityManager->getRepository(Subject::class)->find($subjectId);

                if (!$subject) {
                    $error = 'Le sujet spécifié est invalide';
                } else {
                    $mail->setSubject($subject);
                    $entityManager->persist($mail);
                    $entityManager->flush();

                    $fromEmail = $mail->getEmail();
                    $email = $this->createEmail($fromEmail, $mail, $subject);

                    $mailer->send($email);
                    $success = 'L\'Email a été envoyé avec succès!';
                }
            }
        }

        $subjects = $entityManager->getRepository(Subject::class)->findAll();

        return $this->render('contact/index.html.twig', [
            'controller_name' => 'ContactController',
            'subjects' => $subjects,
            'error' => $error,
            'success' => $success,
        ]);
    }

    private function getMissingFields(array $formData, array $requiredFields): array
    {
        return array_filter($requiredFields, function ($field) use ($formData) {
            return empty(trim($formData[$field]));
        });
    }

    private function createEmail(string $fromEmail, Mailer $mail, Subject $subject): Email
    {
        return (new Email())
            ->from($fromEmail)
            ->to('externatic@gmail.com')
            ->subject('Vous venez de recevoir un Email !')
            ->html($this->renderView('contact/EmailContact.html.twig', [
                'mailer' => $mail,
                'subject' => $subject
            ]));
    }
}
