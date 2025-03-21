<?php
    namespace App\Command;

    use Exception;
    use League\Csv\Reader;
    use PDO;
    use Symfony\Component\Console\Attribute\AsCommand;
    use Symfony\Component\Console\Command\Command;
    use Symfony\Component\Console\Input\InputArgument;
    use Symfony\Component\Console\Input\InputInterface;
    use Symfony\Component\Console\Output\OutputInterface;
    use Symfony\Component\Console\Style\SymfonyStyle;

    #[AsCommand(name:'import-csv', description:'Import customer data from CSV')]
    class ImportCSVCommand extends Command
    {
        protected function configure(): void
        {
            $this->addArgument('url', InputArgument::REQUIRED, 'URL of the CSV file');
        }

        protected function execute(InputInterface $input, OutputInterface $output): int
        {
            $io = new SymfonyStyle($input, $output);
            $csvUrl = $input->getArgument('url');
            $io->info("Fetching CSV from URL: $csvUrl");

            // Define storage path
            $storagePath = __DIR__ . '/../../var/csv';
            if (!is_dir($storagePath)) {
                mkdir($storagePath, 0755, true);
            }


            // Define file path
            $csvFilePath = $storagePath . '/customers_' . time() . '.csv';

            // Fetch and store the CSV file
            if (!$this->fetchAndStoreCsv($csvUrl, $csvFilePath)) {
                $io->error("Failed to fetch and store CSV from the provided URL.");
                return Command::FAILURE;
            }

            $io->success("CSV stored at: $csvFilePath");

            try {
                $pdo = new PDO('mysql:host=localhost;dbname=csv_database;charset=utf8', 'josh', 'securePass', [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
                ]);

                // Read CSV from file
                $csv = Reader::createFromPath($csvFilePath, 'r');
                $csv->setHeaderOffset(0); // First row as header

                // Start transaction
                $io->info("Transaction started");
                $pdo->beginTransaction();

                $stm = $pdo->prepare("INSERT INTO customers (`Customer Id`, `First Name`, `Last Name`, `Company`, `City`, `Country`, `Phone 1`, `Phone 2`, `Email`, `Subscription Date`, `Website`)
                        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
                $startTime = microtime(true);

                foreach ($csv as $row) {
                    $stm->execute([
                        $row['Customer Id'],
                        $row['First Name'],
                        $row['Last Name'],
                        $row['Company'],
                        $row['City'],
                        $row['Country'],
                        $row['Phone 1'],
                        $row['Phone 2'],
                        $row['Email'],
                        $row['Subscription Date'] ? date('Y-m-d', strtotime($row['Subscription Date'])) : null,
                        $row['Website']
                    ]);
                }


                $io->info("Transaction ended");
                $pdo->commit();

                $endTime = microtime(true);
                $executionTime = $endTime - $startTime;
                $io->success("CSV imported successfully in {$executionTime} seconds.");
                return Command::SUCCESS;
            } catch (Exception $e) {
                $pdo->rollBack();
                $io->error('Import failed: ' . $e->getMessage());
                return Command::FAILURE;
            }
        }

        private function fetchAndStoreCsv(string $url, string $filePath): bool
        {
            $ch = curl_init();

            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
            curl_setopt($ch, CURLOPT_FAILONERROR, true);

            $data = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            if ($httpCode >= 400 || !$data) {
                return false;
            }

            return file_put_contents($filePath, $data) !== false;
        }
    }