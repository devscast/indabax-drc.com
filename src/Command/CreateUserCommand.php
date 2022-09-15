<?php

declare(strict_types=1);

namespace App\Command;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Stopwatch\Stopwatch;

use function Symfony\Component\String\u;

#[AsCommand(
    name: 'app:user:create',
    description: 'create a user',
)]
final class CreateUserCommand extends Command
{
    private SymfonyStyle $io;

    public function __construct(
        private readonly EntityManagerInterface $em,
        private readonly UserPasswordHasherInterface $passwordHasher,
        private readonly UserRepository $repository
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->setDescription('Creates users and stores them in the database')
            ->setHelp($this->getCommandHelp())
            ->addArgument('name', InputArgument::OPTIONAL, 'The name of the new user')
            ->addArgument('email', InputArgument::OPTIONAL, 'The email of the new user')
            ->addArgument('password', InputArgument::OPTIONAL, 'The plain password of the new user');
    }

    protected function initialize(InputInterface $input, OutputInterface $output): void
    {
        $this->io = new SymfonyStyle($input, $output);
    }

    protected function interact(InputInterface $input, OutputInterface $output): void
    {
        if (
            $input->getArgument('password') !== null &&
            $input->getArgument('email') !== null &&
            $input->getArgument('name') !== null
        ) {
            return;
        }

        $this->io->title('Add User Command Interactive Wizard');
        $this->io->text([
            'If you prefer to not use this interactive wizard, provide the',
            'arguments required by this command as follows:',
            '',
            ' $ php bin/console app:create-user email@example.com password ',
            '',
            "Now we'll ask you for the value of all the missing command arguments.",
        ]);

        /** @var string|null $name */
        $name = $input->getArgument('name');
        if ($name !== null) {
            $this->io->text(' > <info>Name</info>: ' . $name);
        } else {
            $name = $this->io->ask('Name');
            $input->setArgument('name', $name);
        }

        /** @var string|null $email */
        $email = $input->getArgument('email');
        if ($email !== null) {
            $this->io->text(' > <info>Email</info>: ' . $email);
        } else {
            $email = $this->io->ask('Email');
            $input->setArgument('email', $email);
        }

        /** @var string|null $password */
        $password = $input->getArgument('password');
        if ($password !== null) {
            $this->io->text(' > <info>Password</info>: ' . u('*')->repeat(u($password)->length()));
        } else {
            $password = $this->io->askHidden('Password (your type will be hidden)');
            $input->setArgument('password', $password);
        }
    }

    /**
     * This method is executed after interact() and initialize(). It usually
     * contains the logic to execute to complete this command task.
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $stopwatch = new Stopwatch();
        $stopwatch->start('create-user-command');

        /** @var string $plainPassword */
        $plainPassword = $input->getArgument('password');

        /** @var string $email */
        $email = $input->getArgument('email');

        $this->validateUserData($email);

        // create the user and hash its password
        $user = new User();
        $user->setName(strval($input->getArgument('name')))
            ->setEmail($email)
            ->setRoles(['ROLE_ADMIN'])
        ;

        // See https://symfony.com/doc/current/security.html#c-encoding-passwords
        $hashedPassword = $this->passwordHasher->hashPassword($user, $plainPassword);
        $user->setPassword($hashedPassword);

        $this->em->persist($user);
        $this->em->flush();

        $message = sprintf('User %s was successfully created', $user->getUserIdentifier());

        $this->io->success($message);

        $event = $stopwatch->stop('create-user-command');
        if ($output->isVerbose()) {
            $message = sprintf(
                'New user database id: %d / Elapsed time: %.2f ms / Consumed memory: %.2f MB',
                $user->getId(),
                $event->getDuration(),
                $event->getMemory() / (1024 ** 2)
            );
            $this->io->comment($message);
        }

        return Command::SUCCESS;
    }

    /**
     * The command help is usually included in the configure() method, but when
     * it's too long, it's better to define a separate method to maintain the
     * code readability.
     */
    private function getCommandHelp(): string
    {
        return <<<'HELP'
The <info>%command.name%</info> command creates new users and saves them in the database:
  <info>php %command.full_name%</info> <comment>email password</comment>
HELP;
    }

    private function validateUserData(string $email): void
    {
        // check if a user with the same email already exists.
        $existingEmail = $this->repository->findOneBy([
            'email' => $email,
        ]);

        if ($existingEmail !== null) {
            throw new \RuntimeException(sprintf('There is already a user registered with the "%s" email.', $email));
        }
    }
}
