<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\DtrLog;
use Carbon\Carbon;

class TestCertSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::updateOrCreate(
            ['email' => 'testcert@ojtracker.test'],
            [
                'name'              => 'Test Completion',
                'username'          => 'testcert',
                'password'          => Hash::make('password123'),
                'required_hours'    => 16,
                'school'            => 'Southern de Oro Philippines College',
                'email_verified_at' => now(),
            ]
        );

        DtrLog::where('user_id', $user->id)->delete();

        foreach ([2, 1] as $daysAgo) {
            DtrLog::create([
                'user_id'         => $user->id,
                'date'            => Carbon::today()->subDays($daysAgo)->toDateString(),
                'time_in'         => '08:00:00',
                'time_out'        => '17:00:00',
                'break_hours'     => 1,
                'total_hours'     => 8,
                'status'          => 'completed',
                'notes'           => 'Test day',
                'face_confidence' => null,
                'face_photo'      => null,
            ]);
        }

        $this->command->info('Email: testcert@ojtracker.test');
        $this->command->info('Password: password123');
    }
}
