<?php

use Carbon\Carbon;
use Modules\Users\Model\User;

if ( ! function_exists('modules_path')) {
    function modules_path($module, $path = '')
    {
        return base_path('modules') . DIRECTORY_SEPARATOR . $module . ($path ? DIRECTORY_SEPARATOR . $path : $path);
    }
}

if ( ! function_exists('plural_form')) {
    function plural_form($n, $forms)
    {
        return $n % 10 == 1 && $n % 100 != 11 ? $forms[0] : ($n % 10 >= 2 && $n % 10 <= 4 && ($n % 100 < 10 || $n % 100 >= 20) ? $forms[1] : $forms[2]);
    }
}

if ( ! function_exists('uuid')) {
    function uuid()
    {
        return Ramsey\Uuid\Uuid::uuid1()->toString();
    }
}

if ( ! function_exists('month')) {
    function month($month)
    {
        $months = [
            'янв',
            'фев',
            'мар',
            'апр',
            'май',
            'июн',
            'июл',
            'авг',
            'сен',
            'окт',
            'ноя',
            'дек',
        ];
        return array_get($months, $month - 1);
    }
}

if ( ! function_exists('full_month')) {
    function full_month($month)
    {
        $months = [
            'января',
            'февраля',
            'марта',
            'апреля',
            'мая',
            'июня',
            'июля',
            'августа',
            'сентября',
            'октября',
            'ноября',
            'декабря',
        ];
        return array_get($months, $month - 1);
    }
}

if ( ! function_exists('human_datetime')) {
    function human_datetime(Carbon $date = null)
    {
        if ( ! $date) {
            return null;
        }
        return $date->format('j') . ' ' . month($date->format('n')) . ' ' . $date->format('H:i');
    }
}

if ( ! function_exists('human_date')) {
    function human_date(Carbon $date = null)
    {
        if ( ! $date) {
            return null;
        }
        return $date->format('j') . ' ' . full_month($date->format('n')) . ' ' . $date->format('Y');
    }
}

if ( ! function_exists('human_short_date')) {
    function human_short_date(Carbon $date = null)
    {
        if ( ! $date) {
            return null;
        }
        return $date->format('j') . ' ' . month($date->format('n'));
    }
}

if ( ! function_exists('work_days_in_period')) {
    function work_days_in_period(Carbon $date = null, Carbon $date2 = null)
    {
        if ( ! $date || ! $date2) {
            return 0;
        }
        $workDays = 0;
        $d = $date->copy();
        if ($date->lt($date2)) {
            while ($d->lte($date2)) {
                if ( ! $d->isWeekend()) {
                    $workDays++;
                }
                $d->addDay();
            }
        } else {
            while ($d->gte($date2)) {
                if ( ! $d->isWeekend()) {
                    $workDays--;
                }
                $d->subDay();
            }
        }
        return $workDays;
    }
}

if ( ! function_exists('day')) {
    function day($day)
    {
        $days = [
            'вс',
            'пн',
            'вт',
            'ср',
            'чт',
            'пт',
            'сб',
        ];
        return array_get($days, $day);
    }
}

if ( ! function_exists('day_full')) {
    function day_full($day)
    {
        $days = [
            'Воскресенье',
            'Понедельник',
            'Вторник',
            'Среда',
            'Четверг',
            'Пятница',
            'Суббота',
        ];
        return array_get($days, $day);
    }
}

if ( ! function_exists('rmany')) {
    function rmany($num, $form_for_1, $form_for_2, $form_for_5)
    {
        $num = abs($num) % 100;
        $num_x = $num % 10;
        if ($num > 10 && $num < 20) {
            return $form_for_5;
        }
        if ($num_x > 1 && $num_x < 5) {
            return $form_for_2;
        }
        if ($num_x == 1) {
            return $form_for_1;
        }
        return $form_for_5;
    }
}

if ( ! function_exists('date_format_or_null')) {
    function date_format_or_null(Carbon $date = null, $format)
    {
        if ( ! $date) {
            return null;
        }

        return $date->format($format);
    }
}

if ( ! function_exists('human_format_time')) {
    function human_format_time($minutes)
    {
        $hours = floor($minutes / 60);
        $minutes = $minutes % 60;
        return implode(
            ' ',
            [
                $hours,
                plural_form(
                    $hours,
                    [
                        'час',
                        'часа',
                        'часов',
                    ]),
                $minutes,
                plural_form(
                    $minutes,
                    [
                        'минута',
                        'минуты',
                        'минут',
                    ]),
            ]);
    }
}

if ( ! function_exists('format_time')) {
    function format_time($minutes)
    {
        return now()->startOfDay()->addMinutes($minutes)->format('H:i');
    }
}

if ( ! function_exists('now')) {
    /**
     * @return Carbon
     */
    function now()
    {
        return Carbon::now();
    }
}

if ( ! function_exists('carbon')) {
    /**
     * @param $date
     *
     * @return null|Carbon
     */
    function carbon($date)
    {
        if ( ! $date) {
            return null;
        }
        try {
            return Carbon::parse($date);
        } catch (\Exception $e) {
        }
        return null;
    }
}

if ( ! function_exists('isCacheAlive')) {
    function isCacheAlive()
    {
        return config('cache_alive');
    }
}

if ( ! function_exists('cached')) {
    function cached($closure, $key, $tags = '_default', $minutes = 60)
    {
        if (isCacheAlive()) {
            return Cache::tags($tags)->remember($key, $minutes, $closure);
        }
        return $closure();
    }
}

if ( ! function_exists('cacheFlush')) {
    function cacheFlush($tag)
    {
        if (isCacheAlive()) {
            Cache::tags($tag)->flush();
        }
    }
}

if ( ! function_exists('user_permission')) {
    function user_permission($code, $type, $success, $failure = null)
    {
        /** @var User $user */
        $user = auth()->user();

        if ($user->hasPermission($code, $type)) {
            return $success();
        } else {
            return ($failure && is_callable($failure)) ? $failure() : null;
        }
    }
}

if ( ! function_exists('percent')) {
    function percent($value, $total)
    {
        if ($total == 0) {
            return '0%';
        }
        return round(100 * $value / $total) . '%';
    }
}

if ( ! function_exists('asset_versioned')) {
    // версионируемые файлы
    function asset_versioned($path)
    {
        return asset($path) . '?v=' . config('sump.version');
    }
}

if ( ! function_exists('unformat_time')) {
    function unformat_time($time)
    {
        try {
            list($hours, $minutes) = explode(':', $time, 2);
            return $hours * 60 + $minutes;
        } catch (\Exception $e) {
        }
        return (int)$time;
    }
}

if ( ! function_exists('distance')) {
    /**
     * Расчет расстояния между точками, км.
     *
     * @param $lat1
     * @param $lon1
     * @param $lat2
     * @param $lon2
     *
     * @return float
     */
    function distance($lat1, $lon1, $lat2, $lon2)
    {
        $theta = $lon1 - $lon2;
        $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
        $dist = acos($dist);
        $dist = rad2deg($dist);
        $miles = $dist * 60 * 1.1515;
        return ($miles * 1.609344);
    }
}
