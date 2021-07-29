<?php


namespace App\UseCases\Prospect;


use App\Models\Prospect;
use App\Models\User;
use Carbon\Carbon;
use Carbon\CarbonImmutable;
use Carbon\CarbonPeriod;
use Illuminate\Support\Collection;
use Illuminate\Database\Query\Builder;
use App\Models\ProspectActionLog;


class analysisUsedInDailyReports
{
    private Collection $prospectsOnHalfPeriod;
    private Collection $prospectsOnMonth;
    private Collection $prospectsOnToday;
    private Collection $prospectsOnTodayForCheckStageUp;
    private Collection $prospectsOnMonthForCheckStageUp;


    public function __invoke(int $userId, Carbon $date): array
    {
        $this->setProspects($this->fetchUser($userId), $date);

        //        当日期間
        $prospectsOnToday = $this->prospectsOnToday->filter(fn(Prospect $prospect) => Carbon::parse($prospect->date)
                                                                                            ->diffInDays($date) === 0);
        $TodayStage = [
                'discrimination' => $this->checkStage($prospectsOnToday, 1),
                'latent'         => $this->checkStage($prospectsOnToday, 2),
                'overt'          => $this->checkStage($prospectsOnToday, 3),
        ];
        $TodayStageUp = [
                'LatentForDiscrimination' => $this->StageUpCheckToday($date, 1, 2),
                'OvertForDiscrimination'  => $this->StageUpCheckToday($date, 1, 3),
                'OvertForLatent'          => $this->StageUpCheckToday($date, 2, 3),
        ];
        $TodayOpportunity = [
                'discrimination' => $this->checkOpportunity($this->prospectsOnToday, 1),
                'latent'         => $this->checkOpportunity($this->prospectsOnToday, 2),
                'overt'          => $this->checkOpportunity($this->prospectsOnToday, 3),
        ];

        //当月期間
        $ToMonthStage = [
                'discrimination' => $this->checkStage($this->prospectsOnMonth, 1),
                'latent'         => $this->checkStage($this->prospectsOnMonth, 2),
                'overt'          => $this->checkStage($this->prospectsOnMonth, 3),
        ];
        $ToMonthStageUp = [
                'LatentForDiscrimination' => $this->StageUpCheckToMonth($date, 1, 2),
                'OvertForDiscrimination'  => $this->StageUpCheckToMonth($date, 1, 3),
                'OvertForLatent'          => $this->StageUpCheckToMonth($date, 2, 3),
        ];
        $ToMonthOpportunity = [
                'discrimination' => $this->checkOpportunity($this->prospectsOnMonth, 1),
                'latent'         => $this->checkOpportunity($this->prospectsOnMonth, 2),
                'overt'          => $this->checkOpportunity($this->prospectsOnMonth, 3),
        ];
        $ToMonthMediation = [
                'FullTime'  => $this->checkMediation($this->prospectsOnMonth, 15),
                'Seller'    => $this->checkMediation($this->prospectsOnMonth, 14),
                'panpy'     => $this->checkMediation($this->prospectsOnMonth, 16),
                'Exclusive' => $this->checkMediation($this->prospectsOnMonth, 17),
        ];

        //半期
        $HalfPeriodMediation = [
                'FullTime'  => $this->checkMediation($this->prospectsOnHalfPeriod, 15),
                'Seller'    => $this->checkMediation($this->prospectsOnHalfPeriod, 14),
                'panpy'     => $this->checkMediation($this->prospectsOnHalfPeriod, 16),
                'Exclusive' => $this->checkMediation($this->prospectsOnHalfPeriod, 17),
        ];

        return array_merge(
                ['TodayStage' => $TodayStage],
                ['ToMonthStage' => $ToMonthStage],
                ['TodayStageUp' => $TodayStageUp],
                ['ToMonthStageUp' => $ToMonthStageUp],
                ['TodayOpportunity' => $TodayOpportunity],
                ['ToMonthOpportunity' => $ToMonthOpportunity],
                ['ToMonthMediation' => $ToMonthMediation],
                ['HalfPeriodMediation' => $HalfPeriodMediation]
        );
    }


    private function fetchUser(int $id): User
    {
        return User::findOrFail($id);
    }


    private function setProspects(User $user, Carbon $date)
    {
        $immutableDate = CarbonImmutable::parse($date);
        $prospects = $this->fetchProspectsByHalfPeriod($user, $immutableDate);
        $this->prospectsOnHalfPeriod = $prospects;

        $this->prospectsOnMonth = Prospect::with([
                'prospectActionLogs' => function ($query) use ($immutableDate) {
                    $query->whereBetween('date', [$immutableDate->startOfMonth(), $immutableDate->endOfMonth()]);
                },
        ])
                                          ->where('office_master_id', $user->office_master_id)
                                          ->whereIn('area_master_id', $user->AllAreaSearch)
                                          ->get();

        $this->prospectsOnToday = Prospect::with([
                'prospectActionLogs' => function ($query) use ($immutableDate) {
                    $query->whereDate('date', $immutableDate);
                },
        ])
                                          ->where('office_master_id', $user->office_master_id)
                                          ->whereIn('area_master_id', $user->AllAreaSearch)
                                          ->get();

        $this->prospectsOnTodayForCheckStageUp = Prospect::with([
                'prospectActionLogs' => function ($query) use ($immutableDate) {
                    $query->whereDate('date', '<=', $immutableDate);
                },
        ])
                                                         ->where('office_master_id', $user->office_master_id)
                                                         ->whereIn('area_master_id', $user->AllAreaSearch)
                                                         ->get();

        $this->prospectsOnMonthForCheckStageUp = Prospect::with([
                'prospectActionLogs' => function ($query) use ($immutableDate) {
                    $query->whereDate('date', '<=', $immutableDate);
                },
        ])
                                                         ->whereDate('date', '<', $date)
                                                         ->where('office_master_id', $user->office_master_id)
                                                         ->whereIn('area_master_id', $user->AllAreaSearch)
                                                         ->get();
    }


    private function fetchProspectsByHalfPeriod(User $user, CarbonImmutable $date): Collection
    {
        if (Carbon::APRIL <= $date->month && $date->month < Carbon::SEPTEMBER) {
            $start = $date->month(Carbon::APRIL)->startOfMonth();
            $end = $date->month(Carbon::SEPTEMBER)->endOfMonth();
        } elseif (Carbon::OCTOBER <= $date->month) {
            $start = $date->month(Carbon::OCTOBER)->startOfMonth();
            $end = $date->month(Carbon::MARCH)->addYear()->endOfMonth();
        } else {
            $start = $date->month(Carbon::OCTOBER)->subYear()->startOfMonth();
            $end = $date->month(Carbon::MARCH)->endOfMonth();
        }

        return Prospect::with([
                'prospectActionLogs' => function ($query) use ($start, $end) {
                    $query->whereBetween('date', [$start, $end]);
                },
        ])
                       ->where('office_master_id', $user->office_master_id)
                       ->whereIn('area_master_id', $user->AllAreaSearch)
                       ->get();
    }


    private function checkStage(Collection $prospects, int $stageId): int
    {
        return $prospects->reduce(function (int $count, Prospect $prospect) use ($stageId) {
            return $prospect->prospectActionLogs->first()?->stage_action_master_id === $stageId
                    ? ++$count
                    : $count;
        }, 0);
    }


    private function checkOpportunity(Collection $prospects, int $stage_id): int
    {
        return $prospects->reduce(function (int $count, Prospect $prospect) use ($stage_id) {
            if ($prospect->prospectActionLogs->isEmpty()) return $count;

            $count += $prospect->prospectActionLogs
                    ->where('stage_action_master_id', $stage_id)
                    ->where('assessment_negotiation', 1)
                    ->count();

            return $count;
        }, 0);
    }


    private function checkMediation(Collection $prospects, int $status_id): int
    {
        return $prospects->reduce(function (int $count, Prospect $prospect) use ($status_id) {
            return $prospect->prospectActionLogs->last()?->status_action_master_id === $status_id
                    ? ++$count
                    : $count;
        }, 0);
    }


    private function StageUpCheckToday(Carbon $date, $first_Stage_id, $last_stage_id): int
    {
        $immutableDate = CarbonImmutable::parse($date);

        return $this->prospectsOnTodayForCheckStageUp->reduce(function (int $count, Prospect $prospect) use ($immutableDate, $first_Stage_id, $last_stage_id) {
            if ($prospect->prospectActionLogs->isEmpty()) return $count;

            $isMovedStageFromLessThanOrEqualToYesterday = (
                            $prospect->prospectActionLogs
                                    ->where('date', '<', $immutableDate->subDay())
                                    ->sortByDesc('created_at')
                                    ->sortByDesc('date')
                                    ->first()?->stage_action_master_id === $first_Stage_id
                    ) &&
                    (
                            $prospect->prospectActionLogs
                                    ->sortByDesc('created_at')
                                    ->sortByDesc('date')
                                    ->first()?->stage_action_master_id === $last_stage_id
                    );

            $isMovedStageOnToday = (
                            $prospect?->prospectActionLogs
                                    ->where('date', $immutableDate)
                                    ->sortByDesc('created_at')
                                    ->sortByDesc('date')
                                    ->last()
                                    ?->stage_action_master_id === $first_Stage_id
                    ) && (
                            $prospect?->prospectActionLogs
                                    ->sortByDesc('created_at')
                                    ->sortByDesc('date')
                                    ->first()
                                    ->stage_action_master_id === $last_stage_id
                    );

            return $isMovedStageFromLessThanOrEqualToYesterday || $isMovedStageOnToday ? ++$count : $count;
        }, 0);
    }


    private function StageUpCheckToMonth(Carbon $date, $firstStageId, $lastStageId): int
    {
        $date = CarbonImmutable::parse($date);
        $period = CarbonPeriod::create($date->startOfMonth(), $date);

        return collect($period)->reduce(function ($count, Carbon $date) use ($firstStageId, $lastStageId) {
            $prospects = $this->prospectsOnMonthForCheckStageUp->filter(fn(Prospect $prospect) => Carbon::parse($prospect->date)
                                                                                         ->lessThan($date));
            $date = CarbonImmutable::parse($date);
            return $prospects->reduce(function ($count, Prospect $prospect) use ($date, $firstStageId, $lastStageId) {

                return (
                        $prospect->prospectActionLogs->where('date', '<', $date->subDay())
                                                     ->sortByDesc('created_at')
                                                     ->sortByDesc('date')
                                                     ->first()
                                ?->stage_action_master_id === $firstStageId
                ) && (
                        $prospect->prospectActionLogs->sortByDesc('created_at')
                                                     ->sortByDesc('date')
                                                     ->first()
                                ?->stage_action_master_id === $lastStageId
                )
                        ? ++$count
                        : $count;
            }, 0);
        }, 0);
    }
}

