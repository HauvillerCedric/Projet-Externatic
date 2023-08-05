<?php

namespace App\Command;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[AsCommand(
    name: 'app:create-admin',
    description: 'create a new admin',
)]

/**
 * @SuppressWarnings(PHPMD)
 */
class CreateAdminCommand extends Command
{
    private UserPasswordHasherInterface $userPasswordHasher;
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager, UserPasswordHasherInterface $userPasswordHasher)
    {
        parent::__construct('app:create-admin');
        $this->entityManager = $entityManager;
        $this->passwordHasher = $userPasswordHasher;
    }

    protected function configure(): void
    {
        $this
            ->addArgument('email', InputArgument::OPTIONAL, 'Email')
            ->addArgument('password', InputArgument::OPTIONAL, 'Password')
            ->addArgument('phone', InputArgument::OPTIONAL, 'Phone')
            ->addArgument('firstname', InputArgument::OPTIONAL, 'Firstname')
            ->addArgument('lastname', InputArgument::OPTIONAL, 'Lastname')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $helper = $this->getHelper('question');
        $io = new SymfonyStyle($input, $output);
        $email = $input->getArgument('email');
        if (!$email) {
            $question = new Question('Entrer l\'e-mail du compte administrateur:');
            $email = $helper->ask($input, $output, $question);
        }

        $password = $input->getArgument('password');
        if (!$password) {
            $question = new Question('Entrer le mot de passe du compte administrateur:');
            $question->setHidden(true)->setHiddenFallback(false);
            $password = $helper->ask($input, $output, $question);
        }

        $hashedPassword = $this->passwordHasher->hashPassword(new User(), $password);
        $phone = $input->getArgument('phone');
        if (!$phone) {
            $question = new Question('Entrer le numéro de téléphone de l\'administrateur:');
            $phone = $helper->ask($input, $output, $question);
        }

        $firstname = $input->getArgument('firstname');
        if (!$firstname) {
            $question = new Question('Entrer le prénom de l\'administrateur:');
            $firstname = $helper->ask($input, $output, $question);
        }

        $lastname = $input->getArgument('lastname');
        if (!$lastname) {
            $question = new Question('Entrer le nom de l\'administrateur:');
            $lastname = $helper->ask($input, $output, $question);
        }

        $user = (new User())->setEmail($email)
                ->setPassword($hashedPassword)
                ->setPhone($phone)
                ->setFirstname($firstname)
                ->setLastname($lastname)
                ->SetRoles(['ROLE_ADMIN']);

                $this->entityManager->persist($user);
                $this->entityManager->flush();

        $io->success('le nouvel administrateur a été crée');

        return Command::SUCCESS;
    }
}
