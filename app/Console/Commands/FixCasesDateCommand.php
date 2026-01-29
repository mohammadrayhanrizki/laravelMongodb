<?php

namespace App\Console\Commands;

use App\Models\CaseModel;
use Carbon\Carbon;
use Illuminate\Console\Command;

class FixCasesDateCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:fix-cases-date';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Convert string dates to MongoDB ISODate objects';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting date conversion...');

        $cases = CaseModel::raw(function($collection) {
            return $collection->find();
        });

        $count = 0;
        foreach ($cases as $case) {
            // Check if date is already a BSON Date (UTCDateTime)
            if ($case->date instanceof \MongoDB\BSON\UTCDateTime) {
                continue;
            }

            try {
                // Parse "10-Mar-20"
                $dateString = $case->date;
                $carbonDate = Carbon::createFromFormat('d-M-y', $dateString)->setTime(0,0,0);
                
                // Update directly using raw update to ensure type change
                CaseModel::raw(function($collection) use ($case, $carbonDate) {
                    $collection->updateOne(
                        ['_id' => $case->_id],
                        ['$set' => ['date' => new \MongoDB\BSON\UTCDateTime($carbonDate)]]
                    );
                });

                $count++;
            } catch (\Exception $e) {
                $this->error("Failed to parse date for ID {$case->_id}: " . $e->getMessage());
            }
        }

        $this->info("Successfully converted {$count} records.");
    }
}
