<?php   

namespace App\Filament\Widgets;

use App\Models\User;
use Filament\Support\Enums\IconPosition;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use League\Csv\Serializer\CastToArray;
use Filament\Widgets\StatsOverviewWidget\Chart;

class test extends BaseWidget
{
    protected function getStats(): array
    {

       $userCount = User::count();
        
       

    $userData =[];
     for($i=0;$i<$userCount;$i++){
          $userData[ ] = $i +1  ;
     }


     $previousMonthUserCount = User::whereMonth('created_at', now()->subMonth()->month)->count();
     

    
    $difference = $userCount - $previousMonthUserCount;


    


    if ($previousMonthUserCount === 0) {
      
        $description = 'No data available for the previous month';
    } else {
       
        $difference = $userCount - $previousMonthUserCount;
    
        if ($difference < 0) {
            $decreasePercentage = ($difference / $previousMonthUserCount) * 100;
            $description = sprintf('%.2f%% decrease compared to last month', $decreasePercentage);
        } elseif ($difference > 0) {
            $increasePercentage = ($difference / $previousMonthUserCount) * 100;
            $description = sprintf('%.2f%% increase compared to last month', $increasePercentage);
        } else {
            $description = 'No change compared to last month';
        }
    }
    

        
    
        return [
            Stat::make('Users', $userCount)->icon('heroicon-o-users')->description($description)->descriptionIcon('heroicon-o-user-group' , IconPosition::Before)->color('info')
            ->chart($userData),
        ];
        
    }
}
