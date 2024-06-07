<?php

declare(strict_types=1);

namespace Kiona\Console;

use Kiona\Data\Provider;
use Kiona\Report\Daily;
use Kiona\Report\Monthly;
use Kiona\Report\Weekly;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'app:csv-report')]
final class Report extends Command
{
    private const ARGUMENT_FILE = 'file';
    private const ARGUMENT_FILE_DEFAULT = 'data Kiona.csv';

    private Provider $dataProvider;

    public function __construct(?string $name = null)
    {
        parent::__construct($name);

        $this->dataProvider = new Provider();
    }

    protected function configure(): void
    {
        $this->setDescription('Homework task for Kiona - energy consumption CSV file processing and reporting"')
            ->addArgument(
                self::ARGUMENT_FILE,
                InputArgument::OPTIONAL,
                'CSV file name to process',
                self::ARGUMENT_FILE_DEFAULT,
        );
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $fileName = sprintf('data/%s', $input->getArgument('file'));

        $daily = Daily::create();
        $weekly = Weekly::create();
        $monthly = Monthly::create();

        foreach ($this->dataProvider->provide($fileName) as $data) {
            $daily->add($data);
            $weekly->add($data);
            $monthly->add($data);
        }

        $this->renderDailyReport($output, $daily);
        $this->renderWeeklyReport($output, $weekly);
        $this->renderMonthlyReport($output, $monthly);

        return Command::SUCCESS;
    }

    private function renderDailyReport(OutputInterface $output, Daily $daily): void
    {
        $dailyTable = new Table($output);
        $dailyTable->setStyle('box');
        $dailyTable->setHeaderTitle('Daily values:');
        $dailyTable->setHeaders(['Date', 'Sum', 'Peak Value', 'Peak Time']);

        foreach ($daily->getAll() as $day) {
            $dailyTable->addRow($day->toArray());
        }

        $dailyTable->render();
    }

    private function renderWeeklyReport(OutputInterface $output, Weekly $weekly): void
    {
        $weeklyTable = new Table($output);
        $weeklyTable->setStyle('box');
        $weeklyTable->setHeaderTitle('Weekly values:');
        $weeklyTable->setHeaders(['Year', 'Week', 'Sum', 'Peak Value', 'Peak Time']);

        foreach ($weekly->getAll() as $month) {
            $weeklyTable->addRow($month->toArray());
        }

        $weeklyTable->render();
    }

    private function renderMonthlyReport(OutputInterface $output, Monthly $monthly): void
    {
        $monthlyTable = new Table($output);
        $monthlyTable->setStyle('box');
        $monthlyTable->setHeaderTitle('Monthly values:');
        $monthlyTable->setHeaders(['Year', 'Month', 'Sum', 'Peak Value', 'Peak Time']);

        foreach ($monthly->getAll() as $month) {
            $monthlyTable->addRow($month->toArray());
        }

        $monthlyTable->render();
    }
}
