<?php

declare(strict_types=1);

namespace App\Console;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\PasswordHasher\Hasher\PasswordHasherFactoryInterface;

#[AsCommand(name: 'iphotonic:create-admin', description: 'Creating user with admin role')]
class CreateAdminUserCommand extends Command
{
	private const ARGUMENT_USERNAME = 'username';
	private const ARGUMENT_PASSWORD = 'password';

	public function __construct(
		private readonly PasswordHasherFactoryInterface $passwordHasherFactory,
		private readonly UserRepository $userRepository,
		private readonly EntityManagerInterface $entityManager
	) {
		parent::__construct();
	}

	protected function configure(): void
	{
		$this
			->addArgument(self::ARGUMENT_USERNAME, InputOption::VALUE_REQUIRED, 'Username of user for login')
			->addArgument(self::ARGUMENT_PASSWORD, InputOption::VALUE_REQUIRED, 'Password of user for login');
	}

	protected function execute(InputInterface $input, OutputInterface $output): int
	{
		$userName = $input->getArgument(self::ARGUMENT_USERNAME);
		$password = $input->getArgument(self::ARGUMENT_PASSWORD);
		if (!$userName || !$password) {
			$output->writeln('Username and password arguments is required');

			return self::FAILURE;
		}
		if ($existedUser = $this->userRepository->findOneByUserName($userName)) {
			$output->writeln(sprintf('User with username %s already existed', $existedUser->getUsername()));

			return self::FAILURE;
		}
		$user = new User();
		$user
			->setUsername($userName)
			->setPassword($this->passwordHasherFactory->getPasswordHasher($user)->hash($password))
			->setRoles(['ROLE_ADMIN']);

		$this->entityManager->persist($user);
		$this->entityManager->flush();

		return self::SUCCESS;
	}
}