<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Collection;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class CollectionMacroServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        // Filter Location Macro
        Collection::macro('filterLocation', function ($location) {

            if(!$location) return $this->collect();

            return $this->filter(function ($post) use ($location) {
                return strtolower($post->user->city) === strtolower($location);
            });
        });

        // Filter Price Macro
        Collection::macro('filterPrice', function ($price, $price2) {

            if(!$price) return $this->collect();

            return $this->filter(function ($post) use ($price, $price2) {
                if($price > 5000){
                    return $post->est_price > 5000;
                }else if($price > 100){
                    return $post->est_price >= $price2 && $post->est_price <= $price;
                }else{
                    return $post->est_price < 100;
                }
            });
        });

        // Filter Hide Post Macro
        Collection::macro('filterHideOwnPost', function ($hideOwnPost) {

            if(!$hideOwnPost) return $this->collect();

            return $this->filter(function ($post){
                return $post->user_id != Auth::user()->id;
            });
        });

        // Filter Category Macro
        Collection::macro('filterCategory', function ($category) {

            if($category == 'all' ){
                return $this->filter(function ($post) use($category){
                    return $post->category != null;
                });
            }

            return $this->filter(function ($post) use($category){
                return $post->category === $category;
            });
        });

        // Filter by Produced Date Macro
        Collection::macro('filterProducedDate', function ($producedDate){
            if(!$producedDate) return $this->collect();

            return $this->filter(function ($post) use($producedDate){
                
                $prodDate = Carbon::parse($post->date_produced);
                $now = Carbon::now();

                if($producedDate == 'month'){
                    return $prodDate->isSameMonth($now);
                }else if($producedDate == 'week'){
                    return $prodDate->addWeek()->isNextWeek();
                }else if($producedDate == 'today'){
                    return $prodDate->isToday();
                }
            });
        });

        // Filter by Expired Date Macro 
        Collection::macro('filterExpiredDate', function ($expiredDate){
            if(!$expiredDate) return $this->collect();

            return $this->filter(function ($post) use($expiredDate){
                
                $expDate = Carbon::parse($post->date_expiree);
                $now = Carbon::now();

                if($expiredDate == 'month'){
                    return $expDate->isSameMonth($now);
                }else if($expiredDate == 'week'){
                    return $expDate->addWeek()->isNextWeek();
                }else if($expiredDate == 'today'){
                    return $expDate->isToday();
                }
            });
        });

          // Filter by Status Macro 
          Collection::macro('filterStatus', function ($status){
            if(!$status) return $this->collect();

            return $this->filter(function ($post) use($status){
                return $post->status === $status;
            });
        });
        
        // Search Keyword Macro
        Collection::macro('searchKeyword', function ($searchKeyword) {

            if(!$searchKeyword) return $this->collect();

            return $this->filter(function ($post) use($searchKeyword){
                return stripos($post->prod_name, $searchKeyword) !== false ||
                        stripos($post->title, $searchKeyword) !== false;
            });
        });

        // Custom Pagination Macro
        Collection::macro('customPaginate', function($perPage, $total = null, $page = null, $pageName = 'page') {
            $page = $page ?: LengthAwarePaginator::resolveCurrentPage($pageName);

            return new LengthAwarePaginator(
                $this->forPage($page, $perPage)->values(),
                $total ?: $this->count(),
                $perPage,
                $page,
                [
                    'path' => LengthAwarePaginator::resolveCurrentPath(),
                    'pageName' => $pageName,
                ]
            );
        });
    }
}
