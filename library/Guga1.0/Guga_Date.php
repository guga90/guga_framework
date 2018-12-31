<?php

class Guga_Date extends DateTime {

    /**
     * @param $time [optional]
     * @param $object [optional]
     */
    public function __construct($time = 'now', $object = null) {

        $hour = substr($time, 10, strlen($time));
        $data = substr($time, 0, 10);
        $data = implode("-", array_reverse(explode("-", $data)));
        $data = implode("-", array_reverse(explode("/", $data)));
        $time = $data . $hour;

        if ($object) {
            parent::__construct($time, $object);
        } else {
            parent::__construct($time);
        }
    }

    /**
     * Return Date in ISO8601 format
     *
     * @return String
     */
    public function __toString() {
        return $this->format('Y-m-d H:i:s');
    }

    /**
     * Return Date in ISO8601 format
     *
     * @return String
     */
    public function __toDateString() {
        return $this->format('Y-m-d');
    }

    /**
     * Return difference between $this and $now
     *
     * @param Datetime|String $now
     * @return DateInterval
     */
    public function diff($object = 'NOW', $absolute = null) {
        if (!($object instanceOf DateTime)) {
            $object = new DateTime($object);
        }
        return parent::diff($object, $absolute);
    }

    /**
     * Return Age in Years
     *
     * @param Datetime|String $now
     * @return Integer
     */
    public function getAge($now = 'NOW') {
        return $this->diff($now)->format('%y');
    }

    /*
     * @access public
     * @param string $d1, $d2
     * @return array
     */

    static function DataDiff($d1, $d2) {

        $d1 = (is_string($d1) ? strtotime($d1) : $d1);
        $d2 = (is_string($d2) ? strtotime($d2) : $d2);

        $diff_secs = abs($d1 - $d2);
        $base_year = min(date("Y", $d1), date("Y", $d2));

        $diff = mktime(0, 0, $diff_secs, 1, 1, $base_year);
        return array(
            "years" => str_pad(date("Y", $diff) - $base_year, 2, "0", STR_PAD_LEFT),
            "months_total" => str_pad((date("Y", $diff) - $base_year) * 12 + date("n", $diff) - 1, 2, "0", STR_PAD_LEFT),
            "months" => str_pad(date("n", $diff) - 1, 2, "0", STR_PAD_LEFT),
            "days_total" => str_pad(floor($diff_secs / (3600 * 24)), 2, "0", STR_PAD_LEFT),
            "days" => str_pad(date("j", $diff) - 1, 2, "0", STR_PAD_LEFT),
            "hours_total" => str_pad(floor($diff_secs / 3600), 2, "0", STR_PAD_LEFT),
            "hours" => str_pad(date("G", $diff), 2, "0", STR_PAD_LEFT),
            "minutes_total" => str_pad(floor($diff_secs / 60), 2, "0", STR_PAD_LEFT),
            "minutes" => str_pad((int) date("i", $diff), 2, "0", STR_PAD_LEFT),
            "seconds_total" => str_pad($diff_secs, 2, "0", STR_PAD_LEFT),
            "seconds" => str_pad((int) date("s", $diff), 2, "0", STR_PAD_LEFT)
        );
    }

}
