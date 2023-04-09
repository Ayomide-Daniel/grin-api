<?php

namespace App\Traits;

trait CanDictify
{
    /**
     * @param array<mixed> $data
     * @param string $key
     * @param bool $oneToOne
     * 
     * @return array<mixed>
     */
    public function dictify(array $data, string $key, bool $oneToOne = false): array
    {
        $dict = [];
        foreach ($data as $item) {
            if ($oneToOne) {
                $dict[$item[$key]] = $item;
            } else {
                $dict[$item[$key]][] = $item;
            }   
        }
        return $dict;
    }
}
?>