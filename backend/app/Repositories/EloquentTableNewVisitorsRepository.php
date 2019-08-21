<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Repositories\Contracts\TableNewVisitorsRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use App\Entities\Visitor;
use Illuminate\Database\Eloquent\Builder;

final class EloquentTableNewVisitorsRepository implements TableNewVisitorsRepository
{

    public function groupVisitorsByParameter(
        int $website_id, string $from, string $to, string $parameter
    ): Collection
    {

        $total = Visitor::whereHas('sessions', function (Builder $query) use($from, $to) {
                return $query->whereBetween('start_session', [$from, $to]);
            }, '=', 1)->count();

        dump($total);

        $query = Visitor::whereHas('sessions', function (Builder $query) use($from, $to) {
                    return $query->whereBetween('start_session', [$from, $to]);
                }, '=', 1)
                ->selectRaw('COUNT(*) as total, COUNT(*) / ? * 100 as percentage', [$total])
                ->when(in_array($parameter, ['country', 'city']),
                    function($query) use($parameter) {
                        return $query->join('visits', 'visits.visitor_id', '=', 'visitors.id')
                            ->join('geo_positions', 'visits.geo_position_id', '=', 'geo_positions.id')
                            // ->when($parameter === 'country', function (Builder $query) {
                            //     return $query->addSelect('country as parameter');
                            // })
                            ->when($parameter === 'city', function (Builder $query)  {
                                return $query->addSelect('geo_positions.city as parameter_value')
                                            ->groupBy('parameter_value');
                            });
                });
                // ->when(in_array($parameter, ['language', 'browser','operating_system','screen_resolution']),
                //     function($query, $parameter) {
                //         return $query->join('sessions', 'sessions.visitor_id', '=', 'visitors.id')
                //             ->join('systems', 'sessions.system_id', '=', 'systems.id')
                //             ->when($parameter === 'browser', function (Builder $query) {
                //                 return $query->addSelect('browser as parameter');
                //             })
                //             ->when($parameter === 'operating_system', function (Builder $query) {
                //                 return $query->addSelect('os as parameter');
                //             })
                //             ->when($parameter === 'screen_resolution', function (Builder $query) {
                //                 return $query->addSelect(
                //                     DB::raw('concat(resolution_width, \'x\', resolution_height) as parameter')
                //                     );
                //             })
                //             ->when($parameter === 'language', function (Builder $query) {
                //                 return $query->addSelect('language as parameter');
                //         });
                // })

            $query->dump();

            return $query->get();
    }

}
