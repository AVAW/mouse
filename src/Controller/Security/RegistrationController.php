<?php

namespace App\Controller\Security;

use App\Form\Security\RegistrationFormType;
use App\Security\EmailVerifier;
use App\Service\CaptchaManager;
use App\Service\UserFactory;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mime\Address;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;
use SymfonyCasts\Bundle\VerifyEmail\Exception\VerifyEmailExceptionInterface;

class RegistrationController extends AbstractController
{
    private EmailVerifier $emailVerifier;

    public function __construct(EmailVerifier $emailVerifier)
    {
        $this->emailVerifier = $emailVerifier;
    }

    #[Route('/register', name: 'app_register')]
    public function register(
        Request $request,
        TranslatorInterface $translator,
        CaptchaManager $captchaManager,
        UserFactory $userFactory,
    ): Response {
        $form = $this->createForm(RegistrationFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $userFactory->createFromRegistration(
                $form->get('login')->getData(),
                $form->get('email')->getData(),
                $form->get('plainPassword')->getData(),
            );

            // Generate a signed url and email it to the user
            $this->emailVerifier->sendEmailConfirmation('app_verify_email', $user,
                (new TemplatedEmail())
                    ->from(new Address('admin@example.com', 'Mouse'))
                    ->to($user->getEmail())
                    ->subject('Please Confirm your Email')
                    ->htmlTemplate('security/registration/confirmation_email.html.twig')
            );

            $this->addFlash('success', $translator->trans('security.success.account created'));

            return $this->redirectToRoute('app_home');
        }

        return $this->render('security/registration/register.html.twig', [
            'registrationForm' => $form->createView(),
            'captcha' => $captchaManager->create(),
        ]);
    }

    #[Route('/verify/email', name: 'app_verify_email')]
    public function verifyUserEmail(Request $request, TranslatorInterface $translator): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        // validate email confirmation link, sets User::isVerified=true and persists
        try {
            $this->emailVerifier->handleEmailConfirmation($request, $this->getUser());
        } catch (VerifyEmailExceptionInterface $exception) {
            $this->addFlash('error', $translator->trans($exception->getReason(), [], 'VerifyEmailBundle'));

            return $this->redirectToRoute('app_register');
        }

        $this->addFlash('success', $translator->trans('security.success.your email address has been verified'));

        return $this->redirectToRoute('app_home');
    }
}
