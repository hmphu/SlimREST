<?php

namespace App\Command;

use Slim\Interfaces\RouterInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class RoutesCommand extends Command
{
    /**
     * @var RouterInterface
     */
    private $router;

    public function __construct(RouterInterface $router)
    {
        parent::__construct();

        $this->router = $router;
    }

    protected function configure()
    {
        $this
            ->setName('routes')
            ->setDescription('Display API routes');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $routes = [];
        foreach ($this->router->getRoutes() as $route) {
            $routes[] = [
                'methods' => implode(', ', $route->getMethods()),
                'name' => $route->getName(),
                'pattern' => $route->getPattern(),
                'callable' => $route->getCallable()
            ];

            $output->writeln('<fg=cyan;options=bold>' . $route->getName() . '</>');
            $output->writeln('    ' . implode(', ', $route->getMethods()));
            $output->writeln('    ' . $route->getPattern());
            $output->writeln('    ' . $route->getCallable());
        }
        return 0;
    }
}