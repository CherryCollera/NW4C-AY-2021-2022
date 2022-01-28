<?php
class Util {
    static function baranggayToMunicipality($baranggay, $haystack) {
        foreach ($haystack as $key => $value) {
            if (in_array($baranggay, $value)) return $key;
        }

        return false;
    }
}