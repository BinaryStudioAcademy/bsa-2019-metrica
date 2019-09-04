<?php


namespace App\Utils;

class HostIndicationsService
{
    public function getDomainLookupTime(string $domain): ?int
    {
        $startTime = microtime(true);
        $ip = gethostbyname($this->getClearDomain($domain));
        $stopTime  = microtime(true);

        if ($ip === $domain) {
            return null;
        }

        return $this->getDifferenceInMilliseconds($stopTime, $startTime);
    }

    public function getServerResponseTime(string $domain, string $url): ?int
    {
        $info = $this->getInfo($this->getClearDomain($domain).'/'.$this->getClearUrl($url));

        if (!$info) {
            return null;
        }

        return floor($info['starttransfer_time']*1000);
    }

    private function getInfo(string $pageUrl)
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

    private function getDifferenceInMilliseconds(float $stopTime, float $startTime): int
    {
        $status = ($stopTime - $startTime) * 1000;
        return floor($status);
    }

    private function getClearDomain(string $domain): string
    {
        return preg_replace('/^http[s]?:\/\//i', '', $domain);
    }

    private function getClearUrl(string $url): string
    {
        return preg_replace('/^[/]/i', '', $url);
    }
}
