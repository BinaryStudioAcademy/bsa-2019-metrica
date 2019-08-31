<?php


namespace App\Utils;


class HostIndicationsProvider
{
    public static function getDomainLookupTime(string $domain): ?int
    {
        $startTime = microtime(true);
        $ip = gethostbyname(preg_replace('/^http[s]?:\/\//i','', $domain));
        $stopTime  = microtime(true);

        if ($ip === $domain){
            return null;
        }

        return self::getDifferenceInMilliseconds($stopTime, $startTime);
    }

    public static function getServerResponseTime(string $pageUrl): ?int
    {
        $info = self::getInfo($pageUrl);

        if (!$info){
            return null;
        }

        return floor( $info['starttransfer_time']*1000);
    }

    private static function getInfo(string $pageUrl)
    {
        $ch = curl_init($pageUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        curl_exec($ch);
        $info = null;
        if (!curl_errno($ch)) {
            $info = curl_getinfo($ch);
        }

        curl_close($ch);
        return $info;
    }

    private static function getDifferenceInMilliseconds(float $stopTime, float $startTime): int
    {
        $status = ($stopTime - $startTime) * 1000;
        return floor($status);
    }

}
