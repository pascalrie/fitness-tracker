<?php

namespace App\Command;

use App\Repository\ExecutionRepository;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Serializer\SerializerInterface;

#[AsCommand(
    name: 'app:list-executions',
    description: 'List all available executions of fitness-exercises.',
)]
class ListExecutionsCommand
{
    public function __construct(
        protected readonly ExecutionRepository $repository,
        protected SerializerInterface $serializer
    )
    { }

    public function __invoke(InputInterface $input, OutputInterface $output): int
    {
        $allExecutions = $this->repository->findAll();

        $executions = [];
        foreach ($allExecutions as $execution) {
            $executions[] = $execution->jsonSerialize(true, true, true, false, false);
        }

        $output->writeln(json_encode($executions, JSON_PRETTY_PRINT));
        return Command::SUCCESS;
    }
}
