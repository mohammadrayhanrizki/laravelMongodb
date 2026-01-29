<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CaseModel;
use Carbon\Carbon;
use MongoDB\BSON\UTCDateTime;

class CaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Option: Truncate to ensure clean chart data
        CaseModel::truncate();

        $startDate = Carbon::create(2020, 3, 1);
        $totalConfirmed = 0;
        $totalNegative = 0;
        
        $data = [];

        for ($i = 0; $i < 1000; $i++) {
            $currentDate = $startDate->copy()->addDays($i);
            
            // Random daily fluctuation
            $newConfirmed = rand(100, 5000);
            $newNegative = rand(200, 8000);
            
            $totalConfirmed += $newConfirmed;
            $totalNegative += $newNegative;
            
            // Avoid division by zero
            $totalTests = $totalConfirmed + $totalNegative;
            $positiveRate = $totalTests > 0 ? ($totalConfirmed / $totalTests) * 100 : 0;

            $data[] = [
                'date' => new UTCDateTime($currentDate), // Insert as proper BSON Date
                'new_confirmed' => $newConfirmed,
                'acc_confirmed' => $totalConfirmed,
                'acc_negative' => $totalNegative,
                'positive_rate' => round($positiveRate, 2),
            ];

            // Batch insert every 100 records to avoid memory issues
            if (count($data) >= 100) {
                CaseModel::insert($data);
                $data = [];
            }
        }

        // Insert remaining
        if (!empty($data)) {
            CaseModel::insert($data);
        }

        $this->command->info('Successfully seeded 1000 records starting from 2020-03-01.');
    }
}
