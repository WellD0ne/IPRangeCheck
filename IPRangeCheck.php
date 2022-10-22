<?php

namespace Welld0ne;

/**
 * Проверка вхождения IP адреса в заданный блок CIDR
 */
class IPRangeCheck
{
    /**
     * IPv4 address, ex: "127.0.0.1"
     * @var string
     */
    protected $IPAddress;

    /**
     * Array with IPv4 range CIDR, ex: ["127.0.0.0/8"]
     * @var array
     */
    protected $IPRange;

    /**
     * IPRangeCheck constructor
     * @param array $IPRange
     * @param string|null $IPAddress
     */
    public function __construct(array $IPRange, string $IPAddress = null)
    {
        $this->IPRange = $IPRange;
        $this->IPAddress = $IPAddress ?? $_SERVER['REMOTE_ADDR'];
    }

    /**
     * The method allows you to check if an IPv4 address belongs to a given range
     * @return bool
     */
    public function check() : bool
    {
        $ip_long = ip2long($this->IPAddress);

        foreach ($this->IPRange as $range)
        {
            $ip_arr = explode('/', $range);
            $network_long = ip2long($ip_arr[0]);

            $x = ip2long($ip_arr[1]);
            $mask = long2ip($x) == $ip_arr[1] ? $x : 0xffffffff << (32 - $ip_arr[1]);

            if(( $ip_long & $mask ) == ( $network_long & $mask )) return true;
        }
        return false;
    }
}